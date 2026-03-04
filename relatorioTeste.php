<?php
session_start();
if (isset($_SESSION['id_empresa'])) {
  $nome = $_SESSION['nome_fantasia'];
}
if (isset($_SESSION['cod_empresa'])) {
  $nome = $_SESSION['nome_funcionario'];
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="css/relatorio.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <link rel="icon" href="https://www.chartjs.org/favicon.ico" type="image/x-icon">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital@0;1&family=Special+Gothic+Expanded+One&display=swap" rel="stylesheet">
  <script src="https://kit.fontawesome.com/d15c84f3d2.js" crossorigin="anonymous"></script>
</head>

<body>
  <aside class="sidebar">
    <header>
      <button class="back sidebar-toggler">
        <i class="fa-solid fa-arrow-left"></i>
      </button>
    </header>

    <ul>
      <li><a href="inicial-gerente.php" class="ul-obj"><i class="fa-solid fa-house fa-2x"></i><span class="text">Início</span></a></li>
      <li><a href="cadastro-veiculo.php" class="ul-obj"><i class="fa-solid fa-car fa-2x"></i><span class="text">Cadastro Veículos</span></a></li>
      <li><a href="veiculos_vendidos.php" class="ul-obj"><i class="fa-solid fa-hand-holding-dollar fa-2x"></i><span class="text">Vendidos</span></a></li>
      <li><a href="pagina-funcionario.php" class="ul-obj"><i class="fa-solid fa-people-group fa-2x"></i><span class="text">Funcionários</span></a></li>
      <li><a href="relatorioTeste.php" class="ul-obj"><i class="fa-solid fa-chart-simple fa-2x"></i><span class="text">Relatórios</span></a></li>
      <li><a href="perfilEmpresa.php" class="ul-obj"><i class="fa-solid fa-circle-user fa-2x"></i><span class="text">Perfil</span></a></li>
      <li><a href="PHP/sair.php" class="ul-obj"><i class="fa-solid fa-right-from-bracket fa-2x"></i><span class="text">Sair</span></a></li>
    </ul>
  </aside>

  <?php
  require "PHP/conexao.php";
  $id = $_SESSION['id_empresa'];


  $stmt = $con->prepare("SELECT SUM(CASE WHEN statusveiculo <> 'Vendido' THEN valor ELSE 0 END) as total, SUM(custos_extra) as totalCustos, COUNT(CASE WHEN statusveiculo <> 'Vendido' THEN id_veiculo END) as totalVeiculos FROM veiculo WHERE cod_empresa = ?");
  $stmt->bind_param("s", $id);
  $stmt->execute();
  $result = $stmt->get_result();

  $stmt2 = $con->prepare("SELECT COUNT(CASE WHEN statusveiculo = 'Manutenção' THEN statusveiculo END) as totalManutencao , COUNT(CASE WHEN statusveiculo = 'Disponivel' THEN statusveiculo END) as totalDisponivel , COUNT(CASE WHEN statusveiculo = 'Vendido' THEN statusveiculo END) as totalVendido , SUM(valor_compra) as totalCompra FROM veiculo WHERE cod_empresa = ?");
  $stmt2->bind_param("s", $id);
  $stmt2->execute();
  $result2 = $stmt2->get_result();

  $stm3 = $con->prepare("SELECT SUM(valor) as totalVenda , SUM(custos) as  totalCustosVenda FROM venda where cod_empresa = ?");
  $stm3->bind_param("s", $id);
  $stm3->execute();
  $result3 = $stm3->get_result();

  if ($result->num_rows > 0) {
    $valor = $result->fetch_assoc();
    $valorTotal = $valor["total"] !== null ? (float)$valor["total"] : 0;
    $valorCustosTotal = $valor["totalCustos"] !== null ? (float)$valor["totalCustos"] : 0;
    $QuantidadeVeiculos = $valor["totalVeiculos"] !== null ? (int)$valor["totalVeiculos"] : 0;
  }

  if ($result2->num_rows > 0) {
    $valor2 = $result2->fetch_assoc();
    $QuantidadeManutencao = $valor2["totalManutencao"] ?? 0;
    $QuantidadeDisponivel = $valor2["totalDisponivel"] ?? 0;
    $QuantidadeVendido = $valor2["totalVendido"] ?? 0;
    $totalCustosCompra = $valor2["totalCompra"] ?? 0;
  }

  if ($result3->num_rows > 0) {
    $valor3 = $result3->fetch_assoc();
    $valorDeVenda = $valor3["totalVenda"] ?? 0;
    $custosVenda = $valor3["totalCustosVenda"] ?? 0;
    $lucroAtual = $valorDeVenda - ($custosVenda + $valorCustosTotal + $totalCustosCompra);
  } else {
    $QuantidadeManutencao = 0;
  }

  $custoFinalTotal = $custosVenda + $valorCustosTotal;
  ?>

  <div class="container mt-5">
    <div class="row">
      <div class="col-12 text-center mb-4">
        <h1 class="titulo">Dashboard de Veículos</h1>
        <p class="sub-titulo">Aqui estão as informações de seu estoque</p>
        <h2 class="titulo-primeiro">Informações do Estoque</h2>
      </div>

<?php
// ============================
// 🧾 GARANTIAS A VENCER OU VENCIDAS
// ============================

$queryGarantia = $con->prepare("
    SELECT 
    v.modelo, 
    v.placa, 
    ven.dataVenda,
    ven.data_final AS fim_garantia
FROM venda ven
INNER JOIN veiculo v ON v.id_veiculo = ven.cod_veiculo
WHERE v.cod_empresa = ?
ORDER BY ven.data_final ASC;
");

$queryGarantia->bind_param("s", $id);
$queryGarantia->execute();
$resultGarantia = $queryGarantia->get_result();
?>

<section class="garantias">
    <h2 class="finance-title">Garantias Próximas ou Vencidas</h2>

    <?php if ($resultGarantia->num_rows > 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-striped text-center">
                <thead class="thead-dark">
                    <tr>
                        <th>Modelo</th>
                        <th>Placa</th>
                        <th>Data da Venda</th>
                        <th>Fim da Garantia</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($g = $resultGarantia->fetch_assoc()): ?>
                        <?php
                            $hoje = new DateTime();
                            $fim = new DateTime($g['fim_garantia']);
                            $diff = (int)$hoje->diff($fim)->format('%r%a');
                            if ($diff < 0) {
                                $status = "<span style='color:#E74C3C;font-weight:600;'>Vencida</span>";
                            } elseif ($diff <= 15) {
                                $status = "<span style='color:#E67E22;font-weight:600;'>Próxima do Fim</span>";
                            } else {
                                $status = "<span style='color:#27AE60;font-weight:600;'>Ativa</span>";
                            }
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($g['modelo']); ?></td>
                            <td><?php echo htmlspecialchars($g['placa']); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($g['dataVenda'])); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($g['fim_garantia'])); ?></td>
                            <td><?php echo $status; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p class="text-center text-muted">Nenhuma garantia próxima do fim ou vencida recentemente.</p>
    <?php endif; ?>
</section>

<?php $con->close(); ?>


      <div class="primeiro-grafico">
        <div class="div-canvas">
          <canvas id="graficoValorTotal"></canvas>
        </div>

        <div class="div-blocos">
          <div class="bloco1">
            <div class="blocos">
              <h5 class="block-title">Veículos</h5>
              <div class="mostrar"><i class="fa-solid fa-car-side icone" style="color: #1f4f9c;"></i><span class="quantity"><?php echo $QuantidadeVeiculos; ?></span></div>
            </div>
            <div class="blocos">
              <h5 class="block-title">Em manutenção</h5>
              <div class="mostrar"><i class="fa-solid fa-wrench icone" style="color: #1f4f9c;"></i><span class="quantity"><?php echo $QuantidadeManutencao; ?></span></div>
            </div>
          </div>

          <div class="bloco2">
            <div class="blocos">
              <h5 class="block-title">Disponíveis</h5>
              <div class="mostrar"><i class="fa-solid fa-thumbs-up icone" style="color: #1f4f9c;"></i><span class="quantity"><?php echo $QuantidadeDisponivel; ?></span></div>
            </div>
            <div class="blocos">
              <h5 class="block-title">Vendidos</h5>
              <div class="mostrar"><i class="fa-solid fa-dollar-sign icone" style="color: #1f4f9c;"></i><span class="quantity"><?php echo $QuantidadeVendido; ?></span></div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

  <section class="financeiro">
    <h2 class="finance-title">Informações Financeiras</h2>

    <div class="ultimoGrafico">
      <canvas id="graficoFinanceiro"></canvas>

      <div class="dataFinanceiro">
        <div class="calculadores valorTotal">R$ <?php echo number_format($valorTotal, 2, ',', '.'); ?></div>
        <div class="calculadores valorCustoTotal">R$ <?php echo number_format($custoFinalTotal, 2, ',', '.'); ?></div>
        <div class="calculadores lucroAtual">R$ <?php echo number_format($lucroAtual, 2, ',', '.'); ?></div>
      </div>
    </div>
  </section>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    const ctx = document.getElementById('graficoValorTotal');
    new Chart(ctx, {
      type: 'pie',
      data: {
        labels: ['Em manutenção', 'Disponíveis', 'Vendidos'],
        datasets: [{
          label: 'Informações',
          data: [<?php echo $QuantidadeManutencao ?>, <?php echo $QuantidadeDisponivel ?>, <?php echo $QuantidadeVendido ?>],
          backgroundColor: ['#1F4F9C', '#2E75D0', '#54A0FF'],
          borderWidth: 0.5
        }]
      },
      options: { responsive: true, plugins: { legend: { position: 'top' } } }
    });

    const ctx2 = document.getElementById('graficoFinanceiro');
new Chart(ctx2, {
  type: "bar",
  data: {
    labels: [
      "Capital",
      "Custos Extras",
      "<?php echo ($lucroAtual < 0) ? 'Prejuízo' : 'Lucro'; ?>"
    ],
    datasets: [{
      label: "Resumo Financeiro (R$)",
      data: [<?php echo $valorTotal; ?>, <?php echo $custoFinalTotal; ?>, <?php echo $lucroAtual; ?>],
      backgroundColor: ['#345DB7', '#E67E22', '<?php echo ($lucroAtual < 0) ? 'rgba(197, 43, 43, 1)' : 'rgb(38, 179, 57)'; ?>'],
      borderRadius: 12
    }]
  },
  options: {
    responsive: true,
    plugins: { legend: { display: false } }
  }
});

  </script>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  <script src="js/sidebar.js"></script>
</body>
</html>
