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
    echo $this->twig->render('categoria.html', [
      'user_name' => $_SESSION['user_name'],
      'title' => 'Categorias'
    ]);
  }
}
