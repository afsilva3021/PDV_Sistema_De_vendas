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
    $produtos = [
      ['ID' => 1, 'NOME' => 'Produto 1', 'CODIGO' => '001', 'EAN' => '123456', 'DESCRICAO' => 'Descrição 1', 'PRECO' => 10.00, 'QUANTIDADE_ESTOQUE' => 5, 'STATUS' => 'ativo'],
      // ... outros produtos ...
    ];
    $orcamento = isset($_SESSION['orcamento']) ? $_SESSION['orcamento'] : [];


    // Render the index view
    echo $this->twig->render('orcamento.html', [
      'user_name' => $_SESSION['user_name'],
      'title'  => 'Orçamento',
      'numped' => rand(0, 999999),
      'dthoje' => date('Y-m-d'),
      'produtos' => $produtos,
      'orcamento' => $orcamento
    ]);

    // 3. Gera o PDF com Dompdf
    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    // 4. Exibe no navegador
    $dompdf->stream("relatorio.pdf", ["Attachment" => false]); // false = abre no navegador
  }

  public function novoRcamento(): void
  {
    $produtos = $this->produtoModel->getAll(); // Busca todos os produtos
    $listaOrcamento = isset($_SESSION['orcamento']) ? $_SESSION['orcamento'] : [];

    echo $this->view->render('orcamento.html', [
      'produtos' => $produtos,
      'listaOrcamento' => $listaOrcamento
    ]);
  }
}
