<?php

namespace App\Controllers;

use App\Models\UserModel as User;
use Twig\Environment;

class AuthController
{
  private $user;
  private $twig;

  public function __construct(User $user, Environment $twig)
  {
    $this->user = $user;
    $this->twig = $twig;
  }

  public function login()
  {
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
      $password = trim($_POST['password']);

      // Validação do email
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo $this->twig->render('login.html', [
          'error' => 'Email inválido',
        ]);
        return;
      }

      try {
        $user = $this->user->authenticate($email, $password);

        if ($user) {
          // Autenticação bem-sucedida
          $_SESSION['user_id'] = $user['id'];
          $_SESSION['user_name'] = $user['name']; // Armazena o nome do usuário na sessão
          header('Location: /home'); // Redireciona para a página home
          exit;
        } else {
          // Credenciais inválidas
          echo $this->twig->render('login.html', [
            'title' => 'Login',
            'error' => 'Credenciais inválidas',
          ]);
        }
      } catch (\Exception $e) {
        echo $this->twig->render('login.html', [
          'error' => 'Erro interno: ' . $e->getMessage()
        ]);
      }
    } else {
      echo $this->twig->render('login.html', [
        'title' => 'Login',
      ]);
    }
  }

  public function logout()
  {
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }

    // Destruir a sessão
    session_unset(); // Remove todas as variáveis de sessão
    session_destroy(); // Destroi a sessão

    // Redirecionar para a página de login
    header('Location: /');
    exit;
  }
}
