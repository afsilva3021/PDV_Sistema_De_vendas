<?php

namespace App\Controllers;

use App\Models\UsuariosModel;
use Twig\Environment;

class UsuariosController
{
    private $usuariosModel;
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->usuariosModel = new UsuariosModel();
        $this->twig = $twig;
    }

    public function usuarios()
    {
        try {
            $usuarios = $this->usuariosModel->getAllUsuarios();
            echo $this->twig->render('usuarios.html', [
                'title' => 'Lista de Usuários',
                'usuarios' => $usuarios,
            ]);
        } catch (\Exception $e) {
            echo $this->twig->render('500.html', [
                'message' => $e->getMessage(),
            ]);
        }
    }
}
