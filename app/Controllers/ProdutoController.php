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
        // Render the index template

    }
}
