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

        // Iniciar a sessão, se ainda não estiver ativa
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function usuarios()
    {
        $usuarios = $this->usuariosModel->getAllUsuarios();
        echo $this->twig->render('usuarios.html', [
            'title' => 'Cadastro de Usuários',
            'user_name' => $_SESSION['user_name'],
            'usuarios' => $usuarios,
            'error' => $error ?? null,
            'success' => $success ?? null,
        ]);
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
            $telefone = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_NUMBER_INT);

            $error = null; // Inicializar a variável $error
            $success = null; // Inicializar a variável $success


            // Validação básica
            if (empty($nome) || empty($email) || empty($senha)) {
                $error = 'Os campos Nome, Email e Senha são obrigatórios.';
            } else {
                try {
                    // Criptografar a senha
                    $hashedPassword = password_hash($senha, PASSWORD_DEFAULT);

                    // Cadastrar o usuário
                    $this->usuariosModel->createUsuario($nome, $email, $hashedPassword, $departamento, $bloqueio, $grupo, $desconto, $telefone);

                    $success = 'Usuário cadastrado com sucesso!';
                } catch (\Exception $e) {
                    $error = 'Erro ao cadastrar usuário: ' . $e->getMessage();
                }
            }

            // Renderizar a página com mensagens de erro ou sucesso
            $usuarios = $this->usuariosModel->getAllUsuarios();
            echo $this->twig->render('usuarios.html', [
                'title' => 'Cadastro de Usuários',
                'usuarios' => $usuarios,
                'error' => $error ?? null,
                'success' => $success ?? null,
            ]);
        }
    }



    public function editar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
            $nome = trim($_POST['nome']);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $senha = isset($_POST['senha']) ? trim($_POST['senha']) : null;
            $departamento = trim($_POST['departamento']);
            $bloqueio = filter_input(INPUT_POST, 'bloqueado', FILTER_VALIDATE_INT);
            $grupo = trim($_POST['grupo']);
            $desconto = filter_input(INPUT_POST, 'desconto', FILTER_VALIDATE_FLOAT);
            $telefone = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_NUMBER_INT);

            $error = null; // Inicializar a variável $error
            $success = null; // Inicializar a variável $success

            if (empty($nome) || empty($email)) {
                $error = 'Os campos Nome e Email são obrigatórios.';
            } else {
                try {
                    $hashedPassword = !empty($senha) ? password_hash($senha, PASSWORD_DEFAULT) : null;
                    $this->usuariosModel->updateUsuario($id, $nome, $email, $hashedPassword, $departamento, $bloqueio, $grupo, $desconto, $telefone);
                    $success = 'Usuário atualizado com sucesso!';
                } catch (\Exception $e) {
                    $error = 'Erro ao atualizar usuário: ' . $e->getMessage();
                }
            }

            // Obter a lista de usuários para renderizar a página
            $usuarios = $this->usuariosModel->getAllUsuarios();

            // Renderizar a página com mensagens de erro ou sucesso
            echo $this->twig->render('usuarios.html', [
                'title' => 'Usuários',
                'usuarios' => $usuarios,
                'error' => $error,
                'success' => $success,
            ]);
        }
    }
}
