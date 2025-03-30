<?php

namespace App\Controllers;

use Twig\Environment;

class CategoriaController
{
  private $twig;

  public function __construct(Environment $twig)
  {
    $this->twig = $twig;
  }
  public function index()
  {
    // Render the index template
    echo $this->twig->render('Views/categoria.html', [
      'title' => 'Categorias',
      'description' => 'Categorias de produtos e serviços',
      'keywords' => 'categorias, produtos, serviços'
    ]);
  }
}
