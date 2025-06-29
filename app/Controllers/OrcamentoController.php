<?php

namespace App\Controllers;

use Twig\Environment;
use Dompdf\Dompdf;
use App\Models\OrcamentoModel;

class OrcamentoController
{
  private $twig;
  private $orcamentoModel;

  public function __construct(Environment $twig)
  {
    $this->orcamentoModel = new OrcamentoModel();
    $this->twig = $twig;
  }

  public function orcamento()
  {
    $termo = $_GET['buscar_produto'] ?? '';
    $produtos = $this->orcamentoModel->getSourceProduto($termo);

    // Se for POST, salva os dados e gera PDF
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $orcamento = [
        'cliente'    => $_POST['cliente'] ?? '',
        'cnpjcpf'    => $_POST['cnpjcpf'] ?? '',
        'numped'     => $_POST['numped'] ?? '',
        'data'       => $_POST['data'] ?? '',
        'status'     => $_POST['status'] ?? '',
        'descricao'  => $_POST['descricao'] ?? '',
        'itens'      => $_POST['itens'] ?? [],
      ];

      $_SESSION['orcamento'] = $orcamento;

      // Gera o HTML do orçamento para o PDF
      $html = $this->twig->render('orcamento_pdf.html', [
        'orcamento' => $orcamento
      ]);

      // Gera o PDF com Dompdf
      $dompdf = new Dompdf();
      $dompdf->loadHtml($html);
      $dompdf->setPaper('A4', 'portrait');
      $dompdf->render();

      // Exibe o PDF no navegador
      $dompdf->stream("orcamento.pdf", ["Attachment" => false]);
      exit;
    }

    // Se for GET, apenas exibe o formulário
    $orcamento = isset($_SESSION['orcamento']) ? $_SESSION['orcamento'] : [];

    echo $this->twig->render('orcamento.html', [
      'user_name' => $_SESSION['user_name'],
      'title'     => 'Orçamento',
      'numped'    => rand(0, 999999),
      'dthoje'    => date('Y-m-d'),
      'orcamento' => $orcamento,
      'itens_compra' => $orcamento['itens'] ?? [],
      'produtos'  => $produtos,
    ]);
  }
}
