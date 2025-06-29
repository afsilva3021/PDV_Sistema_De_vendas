<?php

namespace App\Models;

use App\Config\Database;
use PDO;

class OrcamentoModel
{
    public function getSourceProduto(string $termo): array
    {
        try {
            $dbConect = new Database();
            $pdo = $dbConect->connect();

            $sql = "SELECT * FROM PRODUTOS 
                WHERE STATUS = 'ATIVO' 
                AND (NOME LIKE :termo OR EAN LIKE :termo OR CODIGO LIKE :termo)
                ORDER BY NOME ASC";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':termo', '%' . $termo . '%');
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            throw new \Exception("Erro ao buscar produtos: " . $e->getMessage());
        }
    }
}
