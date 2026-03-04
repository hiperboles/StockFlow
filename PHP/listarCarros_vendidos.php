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

if (!$cod_empresa) {
    http_response_code(400);
    echo json_encode(["error" => "Empresa não identificada."]);
    exit;
}

// Consulta veículos e suas imagens
$stmt = $con->prepare("
   SELECT 
    v.id_veiculo, v.placa, v.cor, v.fabricante, v.carroceria, 
    v.statusveiculo, v.modelo, v.tipo, f.valor, v.ano, v.custos_extra,
    v.data_compra, v.data_venda, v.quilometragem, v.combustivel,
    v.valor_compra,
    f.data_final,
    f.custos,
    i.caminho_imagem,
    cg.data_custo,
    cg.id_custos_garantia, 
    cg.custos AS custo_garantido, 
    cg.quantidade, 
    cg.descricao_custo
    FROM veiculo v
    LEFT JOIN custos_garantia cg ON v.id_veiculo = cg.cod_veiculo
    LEFT JOIN imagem_veiculo i ON v.id_veiculo = i.cod_veiculo
    LEFT JOIN venda f ON v.id_veiculo = f.cod_veiculo
    WHERE v.cod_empresa = ? AND v.statusveiculo = 'Vendido'
    GROUP BY v.id_veiculo, i.caminho_imagem, f.data_final, cg.data_custo, cg.custos, cg.quantidade, cg.descricao_custo;
");
$stmt->bind_param("i", $cod_empresa);
$stmt->execute();
$result = $stmt->get_result();

$carros = [];
while ($row = $result->fetch_assoc()) {
    $id = $row['id_veiculo'];

    // Formata datas
    foreach (['data_compra', 'data_venda'] as $campo) {
        if (!empty($row[$campo]) && $row[$campo] !== '0000-00-00') {
            $row[$campo] = date('d/m/Y', strtotime($row[$campo]));
        } else {
            $row[$campo] = null;
        }
    }

    // Agrupa imagens
    if (!isset($carros[$id])) {
        $carros[$id] = $row;
        $carros[$id]['imagens'] = [];
        $carros[$id]['custoLISTA']=[];
    }

    if (!empty($row['caminho_imagem'])) {
        $carros[$id]['imagens'][] = $row['caminho_imagem'];
    }

    if(!empty($row['data_custo']) || !empty($row['custo_garantido']) || !empty($row['quantidade']) || !empty($row['descricao_custo'])){
        $carros[$id]['custoLISTA'][] = [
        'id_custo' => $row['id_custos_garantia'],
        'dataCusto' => $row['data_custo'],
        'custoGarantido' => $row['custo_garantido'],
        'Qt' => $row['quantidade'],
        'descricaoCusto' => $row['descricao_custo']];
    }

    $carros[$id]['imagens'] = array_values(array_unique($carros[$id]['imagens']));
    $carros[$id]['custoLISTA'] = array_values(array_map('unserialize', array_unique(array_map('serialize', $carros[$id]['custoLISTA']))));

    unset($carros[$id]['caminho_imagem']);

    unset(
    $carros[$id]['id_custo_garantia'],
    $carros[$id]['data_custo'],
    $carros[$id]['custo_garantido'],
    $carros[$id]['quantidade'],
    $carros[$id]['descricao_custo']
    );
}

$carros = array_values($carros);

header('Content-Type: application/json');
echo json_encode($carros, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
?>
