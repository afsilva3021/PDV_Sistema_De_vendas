<?php

namespace App\Controllers;

use Twig\Environment;

class DocuemtnoController
{
  private $twig;

  public function __construct(Environment $twig)
  {
    $this->twig = $twig;
  }

  public function documentoEntrada()
  {
    echo $this->twig->render('documentoEntrada.html', [
      'user_name' => $_SESSION['user_name'],
      'title' => 'Documento de Entrada'
    ]);
  }
}
