<?php

namespace App\Models;

use App\Config\Database;
use PDO;
use PDOException;

class UserModel
{
  public function authenticate($email, $password)
  {
    try {
      $dbConect = new Database();
      $pdo = $dbConect->connect();

      error_log("Email fornecido: " . $email);
      error_log("Senha fornecida: " . $password);

      $stmt = $pdo->prepare("SELECT ID, NOME, SENHA FROM USUARIOS WHERE EMAIL = ?");
      $stmt->bindParam(1, $email, PDO::PARAM_STR);
      $stmt->execute();

      $result = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($result) {
        error_log("Hash da senha no banco: " . $result['SENHA']);
        if (password_verify($password, $result['SENHA'])) {
          error_log("Usuário autenticado com sucesso: " . $result['NOME']);
          return [
            'id' => $result['ID'],
            'name' => $result['NOME'],
            'email' => $email
          ];
        } else {
          error_log("Senha inválida!");
          return false;
        }
      } else {
        error_log("Email não encontrado: " . $email);
        return false;
      }
    } catch (PDOException $e) {
      throw new \Exception("Erro ao acessar o banco de dados: " . $e->getMessage());
    }
  }
}
