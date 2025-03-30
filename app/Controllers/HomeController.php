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

    public function index()
    {
        // Render the index template
        echo $this->twig->render('Views/index.html', [
            'title' => 'Home',
            'description' => 'Página inicial do sistema',
            'keywords' => 'home, sistema, inicial'
        ]);
    }
}