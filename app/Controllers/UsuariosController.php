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

    public function cadastrar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = trim($_POST['nome']);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $senha = trim($_POST['senha']);
            $departamento = trim($_POST['departamento']);
            $bloqueio = filter_input(INPUT_POST, 'bloqueado', FILTER_VALIDATE_INT);
            $grupo = trim($_POST['grupo']);
            $desconto = filter_input(INPUT_POST, 'desconto', FILTER_VALIDATE_FLOAT);
            $telefone = filter_input(INPUT_POST, 'telefone', FILTER_VALIDATE_INT);

            if (empty($nome) || empty($email) || empty($senha)) {
                // Renderizar a página com mensagem de erro
                $usuarios = $this->usuariosModel->getAllUsuarios();
                echo $this->twig->render('usuarios.html', [
                    'title' => 'Lista de Usuários',
                    'usuarios' => $usuarios,
                    'error' => 'Os campos Nome, Email e Senha são obrigatórios.',
                ]);
                return;
            }

            try {
                // Cadastrar o usuário
                $id = $this->usuariosModel->createUsuario($nome, $email, $senha, $departamento, $bloqueio, $grupo, $desconto, $telefone);

                // Renderizar a página com mensagem de sucesso e lista atualizada
                $usuarios = $this->usuariosModel->getAllUsuarios();
                echo $this->twig->render('usuarios.html', [
                    'title' => 'Lista de Usuários',
                    'usuarios' => $usuarios,
                    'success' => 'Usuário cadastrado com sucesso! ID: ' . $id,
                ]);
            } catch (\Exception $e) {
                // Renderizar a página com mensagem de erro
                $usuarios = $this->usuariosModel->getAllUsuarios();
                echo $this->twig->render('usuarios.html', [
                    'title' => 'Lista de Usuários',
                    'usuarios' => $usuarios,
                    'error' => 'Erro ao cadastrar usuário: ' . $e->getMessage(),
                ]);
            }
        } else {
            // Renderizar a página de usuários
            $usuarios = $this->usuariosModel->getAllUsuarios();
            echo $this->twig->render('usuarios.html', [
                'title' => 'Lista de Usuários',
                'usuarios' => $usuarios,
            ]);
        }
    }
}
