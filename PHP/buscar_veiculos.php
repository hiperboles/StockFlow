<?php
include 'conexao.php';

$fabricante = $_POST['fabricante'] ?? '';
$busca = $_POST['busca'] ?? '';

if (empty($fabricante)) {
    echo "<p style='text-align:center;'>Nenhum fabricante selecionado.</p>";
    exit;
}

$sql = "
SELECT 
    v.id_veiculo,
    v.modelo,
    v.fabricante,
    v.ano,
    v.valor,
    v.quilometragem,
    v.cor,
    v.statusveiculo,
    iv.caminho_imagem,
    e.nome_fantasia AS empresa_nome,
    e.cidade,
    e.estado
FROM veiculo v
LEFT JOIN imagem_veiculo iv ON v.id_veiculo = iv.cod_veiculo
LEFT JOIN empresa e ON v.cod_empresa = e.id_empresa
WHERE v.fabricante = ?
  AND v.statusveiculo = 'Disponível'
  AND (
      v.modelo LIKE CONCAT('%', ?, '%')
      OR v.cor LIKE CONCAT('%', ?, '%')
      OR v.ano LIKE CONCAT('%', ?, '%')
  )
ORDER BY v.id_veiculo DESC
";

$stmt = $con->prepare($sql);
$stmt->bind_param("ssss", $fabricante, $busca, $busca, $busca);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<p style='text-align:center;font-size:1.05rem;'>Nenhum veículo disponível encontrado.</p>";
    exit;
}

$veiculos = [];
while ($row = $result->fetch_assoc()) {
    $id = $row['id_veiculo'];
    if (!isset($veiculos[$id])) {
        $veiculos[$id] = [
            'modelo' => $row['modelo'],
            'fabricante' => $row['fabricante'],
            'ano' => $row['ano'],
            'valor' => $row['valor'],
            'quilometragem' => $row['quilometragem'],
            'empresa_nome' => $row['empresa_nome'],
            'cidade' => $row['cidade'],
            'estado' => $row['estado'],
            'imagens' => []
        ];
    }

    $caminho = $row['caminho_imagem'];
    if ($caminho) {
        // normaliza o caminho da imagem
        if (strpos($caminho, 'uploads/') === 0) {
            $veiculos[$id]['imagens'][] = $caminho;
        } else {
            $veiculos[$id]['imagens'][] = 'uploads/' . basename($caminho);
        }
    }
}

// Renderização dos cards
foreach ($veiculos as $id => $v) {
    echo "<a href='detalhes.php?id={$id}' class='carro-card' style='text-decoration:none;color:inherit;'>";


    // === Carrossel ===
    if (count($v['imagens']) > 0) {
        echo "<div id='carousel$id' class='carousel slide' data-bs-ride='carousel' data-bs-interval='3500'>";
        echo "<div class='carousel-inner'>";
        foreach ($v['imagens'] as $i => $imgPath) {
            $active = $i === 0 ? 'active' : '';
            echo "
                <div class='carousel-item $active'>
                    <img src='" . htmlspecialchars($imgPath) . "' class='d-block w-100' alt='Imagem do veículo'>
                </div>";
        }
        echo "</div>";

        if (count($v['imagens']) > 1) {
            echo "
            <button class='carousel-control-prev' type='button' data-bs-target='#carousel$id' data-bs-slide='prev'>
                <span class='carousel-control-prev-icon' aria-hidden='true'></span>
                <span class='visually-hidden'>Anterior</span>
            </button>
            <button class='carousel-control-next' type='button' data-bs-target='#carousel$id' data-bs-slide='next'>
                <span class='carousel-control-next-icon' aria-hidden='true'></span>
                <span class='visually-hidden'>Próxima</span>
            </button>";
        }

        echo "</div>";
    } else {
        echo "<img src='../imagens/sem-foto.png' alt='Sem imagem disponível' class='d-block w-100'>";
    }

   // === Informações do veículo ===
echo "<div class='car-info'>
       <h5>" . htmlspecialchars($v['modelo']) . "</h5>
       <p><strong>Ano:</strong> " . htmlspecialchars($v['ano']) . "</p>
       <p><strong>Preço:</strong> R$ " . number_format($v['valor'], 2, ',', '.') . "</p>
       <p><strong>Empresa:</strong> " . htmlspecialchars($v['empresa_nome']) . "</p>
       <p><strong>Quilometragem:</strong> " . number_format($v['quilometragem'], 0, ',', '.') . " km</p>
       <p><strong>Localização:</strong> " . htmlspecialchars($v['cidade']) . " - " . htmlspecialchars($v['estado']) . "</p>
     </div>";

echo "</a>";

}


