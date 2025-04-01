<?php

namespace App\Controllers;

use App\Models\ProdutosModel;
use Twig\Environment;

class ProdutoContrller
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
            ]);
        } catch (\Exception $e) {
            echo $this->twig->render('500.html', [
                'message' => $e->getMessage(),
            ]);
        }
        // Render the index template

    }
}
