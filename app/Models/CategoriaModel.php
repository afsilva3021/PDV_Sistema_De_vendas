<?php

namespace App\Models;

use app\Config\Database;
use PDO;

class CategoriaModel
{
    public function getAllCategorias($categoriaId)
    {
        $dbConect = new Database();
        $pdo = $dbConect->connect();

        $stmt = $pdo->prepare("SELECT COUNT(*) FROM categorias WHERE id = :id");
        $stmt->bindParam(':id', $categoriaId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchColumn() > 0;
    }
}
