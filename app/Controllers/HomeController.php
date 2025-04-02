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
            'user_name' => $_SESSION['user_name'],
            'title' => 'Página Inicial',
        ]);
    }
}
