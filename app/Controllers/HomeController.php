<?php

namespace App\Controllers;

use Twig\Environment;

class HomeController
{
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function home()
    {
        // Renderizar a página inicial
        echo $this->twig->render('home.html', [
            'title' => 'Página Inicial',
        ]);
    }
}
