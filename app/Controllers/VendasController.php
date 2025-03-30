<?php

namespace App\Controllers;

use Twig\Environment;

class VendasController
{
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function venda()
    {
        // Render the index template
        echo $this->twig->render('Views/vendas.html', [
            'title' => 'Vendas',
            'description' => 'Vendas cadastradas',
            'keywords' => 'vendas, cadastro, lista'
        ]);
    }
}