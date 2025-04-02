<?php

namespace App\Controllers;

use App\Models\ClientesModel;
use Twig\Environment;

class ClientesController
{
  private $clientesModel;
  private $twig;

  public function __construct(Environment $twig)
  {
    $this->clientesModel = new ClientesModel();
    $this->twig = $twig;
  }

  public function clientes()
  {

    try {
      $clientes = $this->clientesModel->getAllClientes();
      echo $this->twig->render('clientes.html', [
        'user_name' => $_SESSION['user_name'],
        'title' => 'Clientes',
        'clientes' => $clientes,
      ]);
    } catch (\Exception $e) {
      echo $this->twig->render('500.html', [
        'message' => $e->getMessage(),
      ]);
    }
  }
}
