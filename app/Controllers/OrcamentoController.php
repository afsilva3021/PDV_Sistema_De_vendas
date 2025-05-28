<?php

namespace App\Controllers;

use Twig\Environment;

class OrcamentoController
{
  private $twig;

  public function __construct(Environment $twig)
  {
    $this->twig = $twig;
  }

  public function orcamento()
  {
    // Render the index view
    echo $this->twig->render('orcamento.html', [
      'user_name' => $_SESSION['user_name'],
      'title' => 'Orçamento',
      'numped' => rand(0, 999999),
      'dthoje' => date('Y-m-d'),
    ]);
  }
}
