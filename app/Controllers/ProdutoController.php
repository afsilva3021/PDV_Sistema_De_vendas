<?php

namespace App\Controllers;

use App\Models\ProdutosModel;
use Twig\Environment;

class ProdutoController
{

    private $produtosModel;
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->produtosModel = new ProdutosModel();
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
            echo $this->twig->render('produtos.html', [
                'title' => 'Produtos',
                'error' => $erro,
                'success' => $sucess,
            ]);
        } else {
            // Renderizar a página de cadastro
            echo $this->twig->render('produtos.html', [
                'title' => 'Produtos',
                'produtos' => $produtos,
            ]);
        }
    }

    public function updateProduto($id)
}
