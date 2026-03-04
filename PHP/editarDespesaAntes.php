<?php
include 'conexao.php'; 
session_start();

$id_funcionario = $_SESSION['id_funcionario'] ?? null;

if (isset($_SESSION['id_empresa'])) {
    $cod_empresa = $_SESSION['id_empresa'];
} elseif (isset($_SESSION['id_funcionario'])) {
    $cod_empresa = $_SESSION['cod_empresa'];
} else {
    $cod_empresa = null;
}
$id_veiculo = $_POST['id_veiculo'];
$id_custo   = $_POST['id_custo'] ?? '';
$descricao  = $_POST['descricaoATT'] ?? '';
$valor      = $_POST['custoATT'] ?? '';
$qt         = $_POST['qtATT'] ?? '';

if (empty($id_custo) || empty($descricao) || empty($valor) || empty($qt)) {
    echo "Dados incompletos.";
    exit;
}

// 1️⃣ Seleciona o valor atual antes do update
$selectSql = "SELECT custos FROM custos_garantia WHERE id_custos_garantia = ?";
$stmtSelect = $con->prepare($selectSql);
if (!$stmtSelect) {
    die("Erro na preparação do SELECT: " . $con->error);
}
$stmtSelect->bind_param("i", $id_custo);
$stmtSelect->execute();
$result = $stmtSelect->get_result();
$custoAtual = $result->fetch_assoc();
$stmtSelect->close();

$custoAntes = $custoAtual['custos'];



if($custoAntes < $valor){
  $custoTBVENDA = $valor - $custoAntes;
}else if($custoAntes > $valor){
  $custoTBVENDA = $valor - $custoAntes;
}else{
  $custoTBVENDA = 0;
}



$selectSql2 = "SELECT custos_extra FROM veiculo WHERE id_veiculo = ?";
$stmtSelect2 = $con->prepare($selectSql2);
if (!$stmtSelect2) {
    die("Erro na preparação do SELECT: " . $con->error);
}
$stmtSelect2->bind_param("i", $id_veiculo);
$stmtSelect2->execute();
$result2 = $stmtSelect2->get_result();
$custoAtual2 = $result2->fetch_assoc();
$stmtSelect2->close();

$custoVENDAATUAL = $custoAtual2['custos_extra'];


$custosFINAIS = $custoVENDAATUAL + $custoTBVENDA;


$stmt2 = $con->prepare("UPDATE veiculo SET custos_extra = ? WHERE id_veiculo = ?");
$stmt2->bind_param("di", $custosFINAIS, $id_veiculo);
$stmt2->execute();
$stmt2->close();






// 2️⃣ Faz o update
$sql = "UPDATE custos_garantia 
        SET descricao_custo = ?, custos = ?, quantidade = ? 
        WHERE id_custos_garantia = ?";
$stmt = $con->prepare($sql);

if (!$stmt) {
    die("Erro na preparação da query: " . $con->error);
}

$stmt->bind_param("sdii", $descricao, $valor, $qt, $id_custo);

if ($stmt->execute()) {
    if ($id_funcionario === null) {
        header("Location: ../inicial-gerente.php");
    } else {
        header("Location: ../inicial-funcionario.php");
    }
    exit;
} else {
    echo "Erro ao atualizar despesa: " . $stmt->error;
}

$stmt->close();
$con->close();
?>
