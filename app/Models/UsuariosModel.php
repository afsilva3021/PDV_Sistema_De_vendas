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
}
