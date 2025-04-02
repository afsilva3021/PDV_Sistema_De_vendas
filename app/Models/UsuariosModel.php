<?php

namespace App\Models;

use App\Config\Database;
use PDO;

class UsuariosModel
{
  public function getAllUsuarios()
  {
    try {
      $dbConect = new Database();
      $pdo = $dbConect->connect();

      $stmt = $pdo->query("SELECT * FROM USUARIOS");
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (\PDOException $e) {
      throw new \Exception("Erro ao buscar usuários: " . $e->getMessage());
    }
  }

  public function getUsuarioById($id)
  {
    try {
      $dbConect = new Database();
      $pdo = $dbConect->connect();

      $stmt = $pdo->prepare("SELECT * FROM USUARIOS WHERE ID = ?");
      $stmt->bindParam(1, $id, PDO::PARAM_INT);
      $stmt->execute();

      return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna os dados do usuário como array associativo
    } catch (\PDOException $e) {
      throw new \Exception("Erro ao buscar usuário: " . $e->getMessage());
    }
  }


  public function createUsuario($nome, $email, $senha, $departamento, $bloqueado, $grupo, $desconto, $telefone)
  {
    try {
      $dbConect = new Database();
      $pdo = $dbConect->connect();

      $stmt = $pdo->prepare("INSERT INTO USUARIOS (NOME, EMAIL, SENHA, DEPARTAMENTO, BLOQUEADO, GRUPO, DESCONTO, TELEFONE) 
                               VALUES (:nome, :email, :senha, :departamento, :bloqueado, :grupo, :desconto, :telefone)");

      $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
      $stmt->bindParam(':email', $email, PDO::PARAM_STR);
      $stmt->bindParam(':senha', $senha, PDO::PARAM_STR);
      $stmt->bindParam(':departamento', $departamento, PDO::PARAM_STR);
      $stmt->bindParam(':bloqueado', $bloqueado, PDO::PARAM_BOOL);
      $stmt->bindParam(':grupo', $grupo, PDO::PARAM_STR);
      $stmt->bindParam(':desconto', $desconto, PDO::PARAM_STR);
      $stmt->bindParam(':telefone', $telefone, PDO::PARAM_STR);

      $stmt->execute();

      return $pdo->lastInsertId(); // Retorna o ID do usuário inserido
    } catch (\PDOException $e) {
      throw new \Exception("Erro ao cadastrar usuário: " . $e->getMessage());
    }
  }


  public function updateUsuario($id, $nome, $email, $senha, $departamento, $bloqueado, $grupo, $desconto, $telefone)
  {
    try {
      $dbConect = new Database();
      $pdo = $dbConect->connect();

      // Montar a consulta SQL dinamicamente
      $query = "UPDATE USUARIOS 
                    SET NOME = :nome, EMAIL = :email, DEPARTAMENTO = :departamento, 
                        BLOQUEADO = :bloqueado, GRUPO = :grupo, DESCONTO = :desconto, TELEFONE = :telefone";

      // Adicionar o campo SENHA apenas se ele for fornecido
      if (!empty($senha)) {
        $query .= ", SENHA = :senha";
      }

      $query .= " WHERE ID = :id";

      $stmt = $pdo->prepare($query);

      // Vincular os parâmetros obrigatórios
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
      $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
      $stmt->bindParam(':email', $email, PDO::PARAM_STR);
      $stmt->bindParam(':departamento', $departamento, PDO::PARAM_STR);
      $stmt->bindParam(':bloqueado', $bloqueado, PDO::PARAM_INT);
      $stmt->bindParam(':grupo', $grupo, PDO::PARAM_STR);
      $stmt->bindParam(':desconto', $desconto, PDO::PARAM_STR);
      $stmt->bindParam(':telefone', $telefone, PDO::PARAM_STR);

      // Vincular a senha apenas se ela for fornecida
      if (!empty($senha)) {
        $hashedPassword = password_hash($senha, PASSWORD_DEFAULT);
        error_log("Hash gerado para a senha: " . $hashedPassword);
        $stmt->bindParam(':senha', $senha, PDO::PARAM_STR);
      }

      $stmt->execute();

      return $stmt->rowCount(); // Retorna o número de linhas afetadas
    } catch (\PDOException $e) {
      throw new \Exception("Erro ao atualizar usuário: " . $e->getMessage());
    }
  }
}
