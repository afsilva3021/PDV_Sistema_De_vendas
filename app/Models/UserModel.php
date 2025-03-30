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
      // Conexão com o banco de dados
      $dbConect = new Database();
      $pdo = $dbConect->connect();

      // Prevenir injeção SQL com prepared statements
      $stmt = $pdo->prepare("SELECT ID, SENHA FROM USUARIOS WHERE EMAIL = ?");
      $stmt->bindParam(1, $email, PDO::PARAM_STR);
      $stmt->execute();

      // Buscar o resultado
      $result = $stmt->fetch(PDO::FETCH_ASSOC);

      // Verificar se o usuário existe
      if ($result) {
        // Verificar se a senha fornecida corresponde ao hash armazenado no banco password_verify
        if ($password === $result['SENHA']) {
          // Retornar os dados do usuário autenticado
          return [
            'id' => $result['ID'],
            'email' => $email
          ];
        } else {
          // Senha incorreta
          return false;
        }
      } else {
        // Usuário não encontrado
        return false;
      }
    } catch (PDOException $e) {
      // Lidar com erros de banco de dados
      throw new \Exception("Erro ao acessar o banco de dados: " . $e->getMessage());
    }
  }
}
