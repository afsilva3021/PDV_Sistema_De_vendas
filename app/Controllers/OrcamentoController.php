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

  public function index()
  {
    // Render the index view
    echo $this->twig->render('Views/orccamento.html', [
      'title' => 'Orçamento',
      'description' => 'Orçamento de serviços e produtos',
      'keywords' => 'orçamento, serviços, produtos'
    ]);
  }
}
