<?php

namespace Core;

use App\Controllers\AuthController;
use App\Controllers\HomeController;
use App\Models\UserModel;

class Router
{
    private $userModel;
    private $twig;

    public function __construct()
    {
        $this->userModel = new UserModel(); // Inicialize o modelo de usuário

        $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../app/Views/');
        $this->twig = new \Twig\Environment($loader, [
            'cache' => __DIR__ . '/../cache',
            'cache' => false,
            'debug' => true
        ]);

        $this->twig->addExtension(new \Twig\Extension\DebugExtension());
    }

    public function route()
    {
        session_start();

        $uri = filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL);
        $method = $_SERVER['REQUEST_METHOD'];

        $authController = new AuthController($this->userModel, $this->twig);
        $homeController = new HomeController($this->twig);

        // Definir rotas
        $routes = [
            'GET' => [
                '/' => [$authController, 'login'], // Exibe o formulário de login
                '/home' => [$homeController, 'home'], // Página inicial após login
            ],
            'POST' => [
                '/' => [$authController, 'login'], // Processa o login
            ],
        ];

        try {
            if (isset($routes[$method][$uri])) {
                // Middleware de autenticação para rotas protegidas
                if ($uri === '/home' && !isset($_SESSION['user_id'])) {
                    header('Location: /login');
                    exit;
                }

                // Executar a rota
                call_user_func($routes[$method][$uri]);
            } else {
                // Rota não encontrada
                http_response_code(404);
                echo $this->twig->render('404.html', ['message' => 'Página não encontrada']);
            }
        } catch (\Exception $e) {
            // Erro interno do servidor
            http_response_code(500);
            echo $this->twig->render('500.html', ['message' => $e->getMessage()]);
        }
    }
}
