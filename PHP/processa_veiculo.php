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

if ($_SERVER["REQUEST_METHOD"] == "POST") {

   
    function limparNumero($valor) {
        $valor = preg_replace('/[^\d,.-]/', '', $valor); 
        $valor = str_replace('.', '', $valor); 
        $valor = str_replace(',', '.', $valor);
        return floatval($valor);
    }

    
    $placa = strtoupper(trim($_POST['placa'] ?? '')); 
    $cor = $_POST['cor'] ?? '';
    $marca = $_POST['fabricante'] ?? '';
    $categoria = $_POST['carroceria'] ?? '';
    $statusveiculo = $_POST['status'] ?? '';
    $modelo = $_POST['modelo'] ?? '';
    $tipo = $_POST['cambio'] ?? '';
    $combustivel = $_POST['combustivel'] ?? '';

    $valor_compra = limparNumero($_POST['valor'] ?? 0);
    $valor_venda = limparNumero($_POST['valor_venda'] ?? 0);
    $custos_extra = limparNumero($_POST['custos_extra'] ?? 0);
    $km = limparNumero($_POST['km'] ?? 0);
    $ano = intval($_POST['ano'] ?? 0);

    // 🗓️ Conversão da data de compra
    if (!empty($_POST['data_compra'])) {
        if (strpos($_POST['data_compra'], '/') !== false) {
            $dataObj = DateTime::createFromFormat('d/m/Y', $_POST['data_compra']);
        } else {
            $dataObj = DateTime::createFromFormat('Y-m-d', $_POST['data_compra']);
        }

        $data_compra = $dataObj ? $dataObj->format('Y-m-d') : null;
    } else {
        $data_compra = null;
    }

    
    $sql_check = "SELECT id_veiculo FROM veiculo WHERE UPPER(placa) = ? AND cod_empresa = ?";
    $stmt_check = $con->prepare($sql_check);

    if (!$stmt_check) {
        die("Erro na verificação de placa: " . $con->error);
    }

    $stmt_check->bind_param("si", $placa, $cod_empresa);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        // Redireciona com erro para mostrar modal
        header("Location: cadastro-veiculo.php?erro=placa_duplicada");
        exit;
    }
    $stmt_check->close();

 
    $sql = "INSERT INTO veiculo 
        (placa, cor, fabricante, carroceria, statusveiculo, modelo, tipo, valor, ano, custos_extra, cod_empresa, data_compra, quilometragem, combustivel, valor_compra) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $con->prepare($sql);
    if (!$stmt) {
        die("Erro na preparação do cadastro: " . $con->error);
    }

    $stmt->bind_param(
        "sssssssdiidsisd",
        $placa, $cor, $marca, $categoria, $statusveiculo, $modelo, $tipo,
        $valor_venda, $ano, $custos_extra, $cod_empresa, $data_compra, $km, $combustivel, $valor_compra
    );

    if ($stmt->execute()) {
        $idVeiculo = $stmt->insert_id;

       
        $uploadDir = "uploads/";
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

        if (isset($_FILES['imagens'])) {
            foreach ($_FILES['imagens']['tmp_name'] as $key => $tmp_name) {
                if ($_FILES['imagens']['error'][$key] === UPLOAD_ERR_OK) {
                    $nomeArquivo = basename($_FILES['imagens']['name'][$key]);
                    $caminhoFinal = $uploadDir . uniqid() . "_" . $nomeArquivo;

                    if (move_uploaded_file($tmp_name, $caminhoFinal)) {
                        $sqlImg = "INSERT INTO imagem_veiculo (cod_veiculo, caminho_imagem) VALUES (?, ?)";
                        $stmtImg = $con->prepare($sqlImg);
                        $stmtImg->bind_param("is", $idVeiculo, $caminhoFinal);
                        $stmtImg->execute();
                        $stmtImg->close();
                    }
                }
            }
        }

      
        if ($id_funcionario === null) {
            header("Location: ../inicial-gerente.php?sucesso=veiculo");
        } else {
            header("Location: ../inicial-funcionario.php?sucesso=veiculo");
        }
        exit;

    } else {
        header("Location: ../cadastro-veiculo.php?erro=cadastro");
        exit;
    }

    $stmt->close();
}

$con->close();
?>
