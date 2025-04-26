<?php

namespace Core;

use App\Controllers\AuthController;
use App\Controllers\HomeController;
use App\Controllers\UsuariosController;
use App\Controllers\ProdutoController; // Corrigido o nome da classe
use App\Controllers\ClientesController;
use App\Controllers\OrcamentoController;
use App\Models\UserModel;

class Router
{
    private $userModel;
    private $twig;

    public function __construct()
    {
        $this->userModel = new UserModel();

        $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../app/Views/');
        $this->twig = new \Twig\Environment($loader, [
            'cache' => false,
            'debug' => true,
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
        $produtoController = new ProdutoController($this->twig);
        $clientesController = new ClientesController($this->twig);
        $usuariosController = new UsuariosController($this->twig);
        $orcamentoController = new OrcamentoController($this->twig);

        $routes = [
            'GET' => [
                '/' => [$authController, 'login'],
                '/orcamento' => [$orcamentoController, 'orcamento'],
                '/home' => [$homeController, 'home'],
                '/clientes' => [$clientesController, 'clientes'],
                '/produtos' => [$produtoController, 'produtos'],
                '/usuarios' => [$usuariosController, 'usuarios'],
                '/logout' => [$authController, 'logout'],
            ],
            'POST' => [
                '/' => [$authController, 'login'],
                '/cadastrarUsuario' => [$usuariosController, 'cadastrar'],
                '/editarUsuarios' => [$usuariosController, 'editar'],
                '/cadastrarProdutos' => [$produtoController, 'cadastrar'],
                '/editarProdutos' => [$produtoController, 'editar'],

            ],
        ];

        try {
            // Tratamento de rotas dinâmicas
            if (preg_match('#^/editar/(\d+)$#', $uri, $matches)) {
                $id = $matches[1]; // Extrai o ID da URI
                if ($method === 'GET') {
                    call_user_func([$usuariosController, 'editar'], $id); // Exibe o formulário de edição
                    call_user_func([$produtoController, 'editar'], $id);
                } elseif ($method === 'POST') {
                    call_user_func([$usuariosController, 'editar'], $id); // Processa a atualização
                    call_user_func([$produtoController, 'editar'], $id);
                }
            } elseif (isset($routes[$method][$uri])) {
                // Middleware de autenticação para rotas protegidas
                $protectedRoutes = ['/home', '/clientes', '/produtos', '/orcamento','/usuarios', '/cadastrarUsuario', '/cadastrarProdutos', '/editarUsuarios', '/editarProdutos'];
                if (in_array($uri, $protectedRoutes) && !isset($_SESSION['user_id'])) {
                    header('Location: /');
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
