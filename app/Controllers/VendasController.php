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

    public function vendas()
    {
        // Render the index template
        echo $this->twig->render('vendas.html', [
            'user_name' => $_SESSION['user_name'],
            'title' => 'Vendas',
            'numped' => rand(0, 999999),
            'dthoje' => date('Y-m-d'),
        ]);
    }
}
