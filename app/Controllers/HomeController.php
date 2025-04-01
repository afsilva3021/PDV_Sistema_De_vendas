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
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            header('Location: /');
            exit;
        }

        echo $this->twig->render('home.html', [
            'title' => 'Página Inicial',
            'user_name' => $_SESSION['user_name'], // Passa o nome do usuário para o template
        ]);
    }
}
