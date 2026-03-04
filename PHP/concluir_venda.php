<?php
session_start();
require "conexao.php";

$id_funcionario = $_SESSION['id_funcionario'] ?? null;

if (isset($_SESSION['id_empresa'])) {
    $cod_empresa = $_SESSION['id_empresa'];
} elseif (isset($_SESSION['id_funcionario'])) {
    $cod_empresa = $_SESSION['cod_empresa'];
} else {
    $cod_empresa = null;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $dataVenda= $_POST['dataVenda'] ?? '';
    $vendedor= $_POST['vendedor'] ?? '';
    $comprador= $_POST['comprador'] ?? '';
    $cpf = $_POST['cpf_comprador'] ?? '';
    $telefone  = $_POST['telefone_comprador'] ?? '';
    $cep   = $_POST['cep'] ?? '';
    $cidade   = $_POST['cidade'] ?? '';
    $endereco  = $_POST['endereco'] ?? '';
    $numero   = $_POST['numero'] ?? '';
    $bairro  = $_POST['bairro'] ?? '';
    $estado   = $_POST['estado'] ?? '';
    $email   = $_POST['email_cli'] ?? '';
    $fabricante   = $_POST['fabricante'] ?? '';
    $modelo    = $_POST['modelo'] ?? '';
    $ano = $_POST['ano'] ?? '';
    $placa = $_POST['placa'] ?? '';
    $valor  = floatval($_POST['valor'] ?? 0);
    $valorEntrada  = floatval($_POST['valorEntrada'] ?? 0);
    $valorFaltante = floatval($_POST['valorFaltante'] ?? 0);
    $observacoes  = $_POST['observacoes'] ?? '';
    $custos = $_POST['custos_extras'] ?? 0;

    if (!empty($dataVenda)) {
        $dataObj = strpos($dataVenda, '/') !== false
            ? DateTime::createFromFormat('d/m/Y', $dataVenda)
            : DateTime::createFromFormat('Y-m-d', $dataVenda);

        if (!$dataObj) {
            die("Data de venda inválida. Use dd/mm/yyyy ou yyyy-mm-dd.");
        }

        $dataVenda = $dataObj->format('Y-m-d');
        $dataObj->modify('+90 days');
        $dataFinal = $dataObj->format('Y-m-d');
    } else {
        die("Data de venda não informada.");
    }

    $con->begin_transaction();

    try {
        $sqlIdVeiculo = "SELECT id_veiculo FROM veiculo WHERE placa = ?";
        $stmtId = $con->prepare($sqlIdVeiculo);
        $stmtId->bind_param("s", $placa);
        $stmtId->execute();
        $stmtId->bind_result($idVeiculo);
        $stmtId->fetch();
        $stmtId->close();

        if (empty($idVeiculo)) {
            throw new Exception("Veículo não encontrado para a placa informada.");
        }
        $sqlVenda = "INSERT INTO venda (
            cod_empresa, cod_veiculo, dataVenda, vendedor, comprador, cpf_comprador, telefone_comprador, 
            cep, cidade, endereco, numero, bairro, estado, email_cli, fabricante, modelo, 
            ano, placa, valor, valorEntrada, valorFaltante, observacoes, data_final,custos
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)";

        $stmtVenda = $con->prepare($sqlVenda);
        if (!$stmtVenda) {
            throw new Exception("Erro ao preparar SQL da venda: " . $con->error);
        }

        $stmtVenda->bind_param(
            "iissssssssisssssssidssss",
            $cod_empresa, $idVeiculo, $dataVenda, $vendedor, $comprador, $cpf, $telefone,
            $cep, $cidade, $endereco, $numero, $bairro, $estado, $email,
            $fabricante, $modelo, $ano, $placa,
            $valor, $valorEntrada, $valorFaltante, $observacoes, $dataFinal,$custos
        );

        $stmtVenda->execute();
        $stmtVenda->close();

       
        $sqlVeiculo = "UPDATE veiculo SET statusveiculo = 'Vendido', data_venda = ? WHERE placa = ?";
        $stmtVeiculo = $con->prepare($sqlVeiculo);
        $stmtVeiculo->bind_param("ss", $dataVenda, $placa);
        $stmtVeiculo->execute();
        $stmtVeiculo->close();

        $con->commit();

        
        $destino = $id_funcionario ? "../inicial-funcionario.php" : "../inicial-gerente.php";
        header("Location: $destino");
        exit;

    } catch (Exception $e) {
        $con->rollback();
        die("Erro ao concluir a venda: " . $e->getMessage());
    }

    $con->close();
}
?>
