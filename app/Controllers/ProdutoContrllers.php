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
    public function produtos()
    {
        // Render the index template
        echo $this->twig->render('produtos.html', [
            'title' => 'Produtos'
        ]);
    }
}