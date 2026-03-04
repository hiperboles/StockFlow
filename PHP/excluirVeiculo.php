<?php
session_start();
require "conexao.php";

if (!isset($_POST['id_veiculo'])) {
    echo json_encode(['success' => false, 'msg' => 'ID do veículo não fornecido']);
    exit;
}

$idVeiculo = intval($_POST['id_veiculo']); //string para int


$stmtImgs = $con->prepare("SELECT caminho_imagem FROM imagem_veiculo WHERE cod_veiculo = ?");
$stmtImgs->bind_param("i", $idVeiculo);
$stmtImgs->execute();
$resultImgs = $stmtImgs->get_result();

$imagens = [];
while ($row = $resultImgs->fetch_assoc()) {
    $imagens[] = $row['caminho_imagem'];
}
$stmtImgs->close();


foreach ($imagens as $img) {
    if (file_exists($img)) {
        unlink($img);
    }
}


$stmtDelImgs = $con->prepare("DELETE FROM imagem_veiculo WHERE cod_veiculo = ?");
$stmtDelImgs->bind_param("i", $idVeiculo);
$stmtDelImgs->execute();
$stmtDelImgs->close();


$stmtDelVeiculo = $con->prepare("DELETE FROM veiculo WHERE id_veiculo = ?");
$stmtDelVeiculo->bind_param("i", $idVeiculo);
if ($stmtDelVeiculo->execute()) {
    echo json_encode(['success' => true, 'msg' => 'Veículo excluído com sucesso']);
} else {
    echo json_encode(['success' => false, 'msg' => 'Erro ao excluir veículo']);
}
$stmtDelVeiculo->close();
$con->close();

?>
