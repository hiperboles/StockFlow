<?php
require "conexao.php";
session_start();

$id_funcionario = $_SESSION['id_funcionario'] ?? null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = intval($_POST['id'] ?? 0);
    $ano = intval($_POST['ano'] ?? 0);
    $placa = trim($_POST['placa'] ?? '');
    $data_compra = trim($_POST['data_compra'] ?? '');
    $status = trim($_POST['status'] ?? '');
    $fabricante = trim($_POST['fabricante'] ?? '');
    $modelo = trim($_POST['modelo'] ?? '');
    $cor = trim($_POST['cor'] ?? '');
    $carroceria = trim($_POST['carroceria'] ?? '');
    $cambio = trim($_POST['cambio'] ?? '');
    $combustivel = trim($_POST['combustivel'] ?? '');
    $km = floatval($_POST['km'] ?? 0);
    $valor = floatval($_POST['valor'] ?? 0);
    $valor_compra = floatval($_POST['valor_compra'] ?? 0);
    $custos_extra = floatval($_POST['custos_extra'] ?? 0);

    // Formata a data
    if (!empty($data_compra)) {
        $dataObj = strpos($data_compra, '/') !== false 
            ? DateTime::createFromFormat('d/m/Y', $data_compra) 
            : DateTime::createFromFormat('Y-m-d', $data_compra);
        $data_compra = $dataObj ? $dataObj->format('Y-m-d') : null;
    } else {
        $data_compra = null;
    }

    // Atualiza o veículo
    $sql = "UPDATE veiculo SET 
                ano = ?, placa = ?, data_compra = ?, statusveiculo = ?, fabricante = ?, modelo = ?, cor = ?, 
                carroceria = ?, tipo = ?, combustivel = ?, quilometragem = ?, valor = ?, valor_compra = ?, custos_extra = ?
            WHERE id_veiculo = ?";

    $stmt = $con->prepare($sql);
    if (!$stmt) die("Erro ao preparar query: " . $con->error);

    $stmt->bind_param(
        "isssssssssdddsi",
        $ano, $placa, $data_compra, $status, $fabricante, $modelo, $cor, 
        $carroceria, $cambio, $combustivel, $km, $valor, $valor_compra, $custos_extra, $id
    );

    if (!$stmt->execute()) die("Erro ao atualizar veículo: " . $stmt->error);

    // ===== Imagens =====
    if (isset($_FILES['imagens']) && count($_FILES['imagens']['name']) > 0 && $_FILES['imagens']['name'][0] !== "") {

        // Pega imagens antigas e deleta
        $sqlImgs = "SELECT caminho_imagem FROM imagem_veiculo WHERE cod_veiculo = ?";
        $stmtImgs = $con->prepare($sqlImgs);
        $stmtImgs->bind_param("i", $id);
        $stmtImgs->execute();
        $result = $stmtImgs->get_result();
        while ($row = $result->fetch_assoc()) {
            if (file_exists($row['caminho_imagem'])) unlink($row['caminho_imagem']);
        }
        $stmtImgs->close();

        // Deleta registros antigos
        $stmtDel = $con->prepare("DELETE FROM imagem_veiculo WHERE cod_veiculo = ?");
        $stmtDel->bind_param("i", $id);
        $stmtDel->execute();
        $stmtDel->close();

        // Pasta de upload
        $uploadDir = "uploads/";
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

        // Salva imagens novas
        foreach ($_FILES['imagens']['tmp_name'] as $key => $tmp_name) {
            if ($_FILES['imagens']['error'][$key] !== UPLOAD_ERR_OK) continue;
            $arquivo = basename($_FILES['imagens']['name'][$key]);
            $caminhoIMAGEM = $uploadDir . uniqid("img_") . "_" . $arquivo;

            // Garante que é imagem
            if (strpos($_FILES['imagens']['type'][$key], 'image/') !== 0) continue;

            if (move_uploaded_file($tmp_name, $caminhoIMAGEM)) {
                $stmtInsert = $con->prepare("INSERT INTO imagem_veiculo (cod_veiculo, caminho_imagem) VALUES (?, ?)");
                $stmtInsert->bind_param("is", $id, $caminhoIMAGEM);
                $stmtInsert->execute();
                $stmtInsert->close();
            }
        }
    }

    // Redireciona após atualizar
    if ($id_funcionario === null) {
        header("Location: ../inicial-gerente.php");
    } else {
        header("Location: ../inicial-funcionario.php");
    }
    exit;
}
?>
