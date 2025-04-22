<?php

namespace App\Controllers;

use App\Models\ProdutosModel;
use App\Models\CategoriaModel;
use Twig\Environment;

class ProdutoController
{

    private $produtosModel;
    private $categoriaModel;
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->produtosModel = new ProdutosModel();
        $this->categoriaModel = new CategoriaModel();
        $this->twig = $twig;
    }

    public function produtos()
    {
        try {
            $produtos = $this->produtosModel->getAllProdutos();
            echo $this->twig->render('produtos.html', [
                'title' => 'Produtos',
                'produtos' => $produtos,
                'user_name' => $_SESSION['user_name'],
            ]);
        } catch (\Exception $e) {
            echo $this->twig->render('500.html', [
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function cadastrar()
    {
        $produtos = $this->produtosModel->getAllProdutos();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $erro = null;
            $sucess = null;

            // Receber os dados do formulário
            $nome = trim($_POST['nome']);
            $codigo = filter_input(INPUT_POST, 'codigo', FILTER_SANITIZE_NUMBER_INT);
            $ean = filter_input(INPUT_POST, 'codigoEan', FILTER_SANITIZE_NUMBER_INT);
            $preco = filter_input(INPUT_POST, 'preco', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $custo = filter_input(INPUT_POST, 'custo', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $quantidade = filter_input(INPUT_POST, 'quantidade', FILTER_SANITIZE_NUMBER_INT);
            $descricao = trim($_POST['descricao']);
            $categoria = filter_input(INPUT_POST, 'categoria', FILTER_SANITIZE_NUMBER_INT);
            $status = trim($_POST['status']);
            $imagem = null; // Não salvar imagem

            // Verificar campos obrigatórios
            if (empty($nome) || empty($codigo) || empty($preco) || empty($quantidade) || empty($status)) {
                $erro = "Os campos nome, código, preço, quantidade e status são obrigatórios.";
            } else {
                try {
                    // Chamar o modelo para salvar o produto
                    $this->produtosModel->createProduto($nome, $codigo, $ean, $descricao, $custo, $preco, $quantidade, $categoria, $imagem, $status);
                    $sucess = "Cadastro realizado com sucesso!";
                } catch (\Exception $e) {
                    $erro = 'Erro ao cadastrar produto: ' . $e->getMessage();
                }
            }

            // Renderizar a página com mensagens de erro ou sucesso
            $produtos = $this->produtosModel->getAllProdutos();
            echo $this->twig->render('produtos.html', [
                'title' => 'Produtos',
                'produtos' => $produtos,
                'error' => $erro,
                'success' => $sucess,
            ]);
        } else {
            // Renderizar a página de cadastro
            $produtos = $this->produtosModel->getAllProdutos();
            echo $this->twig->render('produtos.html', [
                'title' => 'Produtos',
                'produtos' => $produtos,
            ]);
        }
    }

    public function editar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
            $nome = trim($_POST['nome']);
            $codigo = trim($_POST['codigo']);
            $ean = filter_input(INPUT_POST, 'ean', FILTER_SANITIZE_NUMBER_INT);
            $preco = filter_input(INPUT_POST, 'preco', FILTER_SANITIZE_NUMBER_FLOAT);
            $custo = filter_input(INPUT_POST, 'custo', FILTER_SANITIZE_NUMBER_FLOAT);
            $quantidade = filter_input(INPUT_POST, 'quantidade', FILTER_SANITIZE_NUMBER_INT);
            if (is_null($quantidade) || $quantidade === false || $quantidade === '') {
                $quantidade = 0;
            }
            $descricao = trim($_POST['descricao']);
            $categoria = filter_input(INPUT_POST, 'categoria', FILTER_SANITIZE_NUMBER_INT);
            $status = trim($_POST['status']);
            $imagem = null; // Não salvar imagem

            $error = null;
            $sucess = null;

            // Verificar campos obrigados
            if (empty($nome) || empty($codigo) || empty($preco)) {
                $error = 'Nome do produto, Código e Preço são obrigatórios.';
            } else {
                try {
                    $this->produtosModel->updateProduto($id, $nome, $codigo, $ean, $preco, $custo, $quantidade, $categoria, $descricao, $imagem, $status);
                    $sucess = 'Produto atualizado com sucesso';
                } catch (\Exception $e) {
                    $error = 'Erro ao atualizar o produto: ' . $e->getMessage();
                }
            }

            $categoria = $this->categoriaModel->getAllCategorias($categoria);

            $produtos = $this->produtosModel->getAllProdutos();

            echo $this->twig->render('produtos.html', [
                'title' => 'Produros',
                'produtos' => $produtos,
                'categoria' => $categoria,
                'error' => $error,
                'success' => $sucess,
            ]);
        }
    }
}
