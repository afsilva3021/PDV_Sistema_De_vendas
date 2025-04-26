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
      $stmt->bindParam(':categoria', $categoria, PDO::PARAM_INT); // Vincular o parâmetro :categoria
      $stmt->bindParam(':imagem', $imagem, PDO::PARAM_STR);
      $stmt->bindParam(':status', $status, PDO::PARAM_STR);

      $stmt->execute();
    } catch (\Exception $e) {
      throw new \Exception("Erro ao criar produto: " . $e->getMessage());
    }
  }

  public function produtoExiste($id)
  {
    $dbConect = new Database();
    $pdo = $dbConect->connect();

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM produtos WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchColumn() > 0;
  }



  public function updateProduto($id, $nome, $codigo, $ean, $preco, $custo, $quantidade, $descricao, $imagem, $status)
  {
    try {
      $dbConect = new Database();
      $pdo = $dbConect->connect();

      $query = "UPDATE PRODUTOS
                  SET NOME = :nome, CODIGO = :codigo, EAN = :ean, DESCRICAO = :descricao, 
                      CUSTO = :custo, PRECO = :preco, QUANTIDADE_ESTOQUE = :quantidade, 
                      IMAGEM = :imagem, STATUS = :status
                  WHERE ID = :id";

      $stmt = $pdo->prepare($query);

      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
      $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
      $stmt->bindParam(':codigo', $codigo, PDO::PARAM_INT);
      $stmt->bindParam(':ean', $ean, PDO::PARAM_INT);
      $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);
      $stmt->bindParam(':custo', $custo, PDO::PARAM_STR);
      $stmt->bindParam(':preco', $preco, PDO::PARAM_STR);
      $stmt->bindParam(':quantidade', $quantidade, PDO::PARAM_INT);
      $stmt->bindParam(':imagem', $imagem, PDO::PARAM_STR);
      $stmt->bindParam(':status', $status, PDO::PARAM_STR);

      $stmt->execute();

      return $stmt->rowCount();
    } catch (\Exception $e) {
      throw new \Exception("Erro ao editar produto: " . $e->getMessage());
    }
  }
}
