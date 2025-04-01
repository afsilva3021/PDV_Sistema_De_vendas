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


  public function createUsuario($nome, $email, $senha, $departamento, $bloqueado, $grupo, $desconto, $telefone) 
  {
    try {
      $dbConect = new Database();
      $pdo = $dbConect->connect();

      $stmt = $pdo->prepare("INSERT INTO USUARIOS (NOME, EMAIL, SENHA, DEPARTAMENTO, BLOQUEADO, GRUPO, DESCONTO, TELEFONE) VALUES (:nome, :email, :senha, :departamento, :bloqueado, :grupo, :desconto, :telefone)");
      $hashedPassword = password_hash($senha, PASSWORD_DEFAULT);

      $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
      $stmt->bindParam(':email', $email, PDO::PARAM_STR);
      $stmt->bindParam(':senha', $hashedPassword, PDO::PARAM_STR);
      $stmt->bindParam(':departamento', $departamento, PDO::PARAM_STR);
      $stmt->bindParam(':bloqueado', $bloqueado, PDO::PARAM_BOOL);
      $stmt->bindParam(':grupo', $grupo, PDO::PARAM_STR);
      $stmt->bindParam(':desconto', $desconto, PDO::PARAM_STR);
      $stmt->bindParam(':telefone', $telefone, PDO::PARAM_INT);

      $stmt->execute();

      return $pdo->lastInsertId(); // Retorna o ID do usuarios Inserido
    } catch (\Exception $e){
      throw new \Exception("Erro ao cadastrar usuário: " . $e->getMessage());
    }
  }
}
