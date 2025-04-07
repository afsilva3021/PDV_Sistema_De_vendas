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

  public function createProduto($nome, $codigo, $ean, $descricao, $custo, $preco, $quantidade, $categoria, $imagem, $status)
  {
    try {
      $dbConect = new Database();
      $pdo = $dbConect->connect();

      // Inserir os dados no banco de dados
      $stmt = $pdo->prepare("INSERT INTO PRODUTOS (NOME, CODIGO, EAN, DESCRICAO, CUSTO, PRECO, QUANTIDADE_ESTOQUE, CATEGORIA_ID, IMAGEM, STATUS)
                               VALUES (:nome, :codigo, :ean, :descricao, :custo, :preco, :quantidade, :categoria, :imagem, :status)");

      $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
      $stmt->bindParam(':codigo', $codigo, PDO::PARAM_INT);
      $stmt->bindParam(':ean', $ean, PDO::PARAM_INT);
      $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);
      $stmt->bindParam(':custo', $custo, PDO::PARAM_STR);
      $stmt->bindParam(':preco', $preco, PDO::PARAM_STR);
      $stmt->bindParam(':quantidade', $quantidade, PDO::PARAM_INT);
      $stmt->bindParam(':categoria', $categoria, PDO::PARAM_INT);
      $stmt->bindParam(':imagem', $imagem, PDO::PARAM_STR); // Certifique-se de vincular o parâmetro :imagem
      $stmt->bindParam(':status', $status, PDO::PARAM_STR);

      $stmt->execute();
    } catch (\Exception $e) {
      throw new \Exception("Erro ao criar produto: " . $e->getMessage());
    }
  }


  public function editarProduto($id, $nome, $codigo, $ean, $descricao, $custo, $preco, $quantidade, $categoria, $image, $status)
  {
    try {
      $dbConect = new Database();
      $pdo = $dbConect->connect();

      $stmt = $pdo->prepare("INSERT INTO PRODUTOS (NOME, CODIGO, EAN, DESCRICAO, CUSTO, PRECO, QUANTIDADE_ESTOQUE, CATEGORIA_ID, IMAGE, STATUS)
              VALUES (:nome, :codigo, :ean, :descricao, :custo, :preco, :quantidade_estoque, :categoria_id, :image, :status)");

    $stmt->brindParam(':nome', $nome, PDO::PARAM_STR);
    
    } catch (\Exception $e) {
    }
  }
}
