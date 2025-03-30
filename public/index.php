<?php

require __DIR__ . '/../vendor/autoload.php';

use Core\Router;

// Instanciar a classe Router
$router = new Router();

// Processar as rotas
$router->route();