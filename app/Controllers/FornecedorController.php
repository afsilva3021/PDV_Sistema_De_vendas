<?php

namespace App\Controllers;

use Twig\Environment;

class FornecedorControllers
{
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function fornecedor()
    {
        echo $this->twig->render('fornecedor.html', [
            'title' => 'Fornecedores'
        ]);
    }
}