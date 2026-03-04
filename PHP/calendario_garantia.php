<?php
require "conexao.php";
session_start();
$id_empresa = $_SESSION['id_empresa'] ?? 0;

$mes = $_POST['mes'] ?? date('m');
$ano = $_POST['ano'] ?? date('Y');

// Traduz meses
$meses = [
  1 => "Janeiro", 2 => "Fevereiro", 3 => "Março", 4 => "Abril",
  5 => "Maio", 6 => "Junho", 7 => "Julho", 8 => "Agosto",
  9 => "Setembro", 10 => "Outubro", 11 => "Novembro", 12 => "Dezembro"
];

$query = "SELECT DAY(DATE_ADD(v.data_compra, INTERVAL 1 YEAR)) AS dia,
                 DATE_FORMAT(DATE_ADD(v.data_compra, INTERVAL 1 YEAR), '%d/%m/%Y') AS data_garantia,
                 v.placa, v.modelo
          FROM veiculo v 
          WHERE v.cod_empresa = ?
          AND YEAR(DATE_ADD(v.data_compra, INTERVAL 1 YEAR)) = ?
          AND MONTH(DATE_ADD(v.data_compra, INTERVAL 1 YEAR)) = ?
          AND v.data_compra IS NOT NULL";

$stmt = $con->prepare($query);
$stmt->bind_param("iii", $id_empresa, $ano, $mes);
$stmt->execute();
$result = $stmt->get_result();

$garantias = [];
while ($row = $result->fetch_assoc()) {
  $garantias[$row['dia']][] = "{$row['placa']} - {$row['modelo']} (Expira em {$row['data_garantia']})";
}
$stmt->close();

$diasNoMes = cal_days_in_month(CAL_GREGORIAN, $mes, $ano);
$primeiroDia = date('w', strtotime("$ano-$mes-01"));
$nomeMes = $meses[intval($mes)];
?>

<div class="mes-calendario">
  <h3 class="mes-titulo"><?= $nomeMes ?> <?= $ano ?></h3>
  <table class="calendario-table">
    <thead>
      <tr><th>D</th><th>S</th><th>T</th><th>Q</th><th>Q</th><th>S</th><th>S</th></tr>
    </thead>
    <tbody><tr>
    <?php
    for ($i = 0; $i < $primeiroDia; $i++) echo "<td></td>";

    for ($dia = 1; $dia <= $diasNoMes; $dia++) {
      if (($dia + $primeiroDia - 1) % 7 == 0 && $dia != 1) echo "</tr><tr>";

      $temGarantia = isset($garantias[$dia]);
      $classe = $temGarantia ? "garantia-dia" : "";
      echo "<td class='$classe'><div class='numero-dia'>$dia</div>";

      if ($temGarantia) {
        echo "<div class='garantia-tooltip'>";
        foreach ($garantias[$dia] as $info) {
          echo "<small>🛡️ $info</small><br>";
        }
        echo "</div>";
      }

      echo "</td>";
    }
    ?>
    </tr></tbody>
  </table>
</div>
