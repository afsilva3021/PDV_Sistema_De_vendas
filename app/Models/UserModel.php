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

      $stmt = $pdo->prepare("SELECT ID, NOME, SENHA FROM USUARIOS WHERE EMAIL = ?");
      $stmt->bindParam(1, $email, PDO::PARAM_STR);
      $stmt->execute();

      $result = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($result) {
        if (password_verify($password, $result['SENHA'])) {
          return [
            'id' => $result['ID'],
            'name' => $result['NOME'], // Retorna o nome do usuário
            'email' => $email
          ];
        } else {
          return false;
        }
      } else {
        return false;
      }
    } catch (PDOException $e) {
      throw new \Exception("Erro ao acessar o banco de dados: " . $e->getMessage());
    }
  }
}
