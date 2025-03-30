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
    echo $this->twig->render('Views/DocumentoEntrada.html', [
      'title' => 'Documento de Entrada',
      'description' => 'Cadastro de Documento de Entrada',
      'keywords' => 'documento, entrada, cadastro'
    ]);
  }
}
