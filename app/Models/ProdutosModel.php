<?php

namespace App\Models;

use App\Config\Database;
use PDO;

class ProdutosModel
{
  public function getAllProdutos()
  {
    try {
      $dbConect = new Database();
      $pdo = $dbConect->connect();

      $stmt = $pdo->query("SELECT * FROM PRODUTOS");
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (\Exception $e) {
      throw new \Exception("Erro ao buscar produtos: " . $e->getMessage());
    }
  }
}
