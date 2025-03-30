<?php

namespace App\Controllers;

use Twig\Environment;

class ClientesController
{
  private $twig;

  public function __construct(Environment $twig)
  {
    $this->twig = $twig;
  }

  public function cliente()
  {
    // Render the index template
    echo $this->twig->render('clientes.html', [
      'title' => 'Clientes'
    ]);
  }
}
