<?php
include 'conexao.php';

$id_custo = $_POST['id_custo'] ?? '';
$id_veiculo = $_POST['id_veiculo'] ?? '';
$valor = $_POST['custoATT'] ?? 0; 
$valor = floatval($valor); 

if (!$id_custo || !$id_veiculo) {
    echo "Dados inválidos.";
    exit;
}


$selectSql2 = "SELECT custos_extra FROM veiculo WHERE id_veiculo = ?";
$stmtSelect2 = $con->prepare($selectSql2);
$stmtSelect2->bind_param("i", $id_veiculo);
$stmtSelect2->execute();
$result2 = $stmtSelect2->get_result();
$custoAtual2 = $result2->fetch_assoc();
$stmtSelect2->close();

$custoATUAL = floatval($custoAtual2['custos_extra']);

$custoFINAL = $custoATUAL - $valor;


$stmt2 = $con->prepare("UPDATE veiculo SET custos_extra = ? WHERE id_veiculo = ?");
$stmt2->bind_param("di", $custoFINAL, $id_veiculo);
$stmt2->execute();
$stmt2->close();


$sql = "DELETE FROM custos_garantia WHERE id_custos_garantia = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $id_custo);

if ($stmt->execute()) {
    echo "Despesa excluída com sucesso!";
} else {
    echo "Erro ao excluir despesa: " . $stmt->error;
}

$stmt->close();
$con->close();
?>
