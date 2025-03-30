<?php

namespace App\Controllers;

use Twig\Environment;

class ProdutoContrllers
{
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }
    public function produto()
    {
        // Render the index template
        echo $this->twig->render('Views/produto.html', [
            'title' => 'Produtos',
            'description' => 'Produtos cadastrados',
            'keywords' => 'produtos, cadastro, lista'
        ]);
    }
}