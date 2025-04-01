<?php

namespace App\Models;

use App\Config\Database;
use PDO;

class ClientesModel
{
    public function getAllClientes()
    {
      try {
        $dbConect = new Database();
        $pdo = $dbConect->connect();

        $stmt = $pdo->query("SELECT * FROM CLIENTES");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
      }catch (\Exception $e){
        throw new \Exception("Erro ao buscar Clientes". $e->getMessage());
      }
    }
}