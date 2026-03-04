<?php
include 'conexao.php';

// Pega o ID do veículo pela URL
$id = $_GET['id'] ?? 0;

// =============================
// Consulta principal do veículo
// =============================
$stmt = $con->prepare("
    SELECT 
        v.*, 
        e.nome_fantasia, 
        e.email, 
        e.telefone, 
        e.cidade, 
        e.estado
    FROM veiculo v
    LEFT JOIN empresa e ON v.cod_empresa = e.id_empresa
    WHERE v.id_veiculo = ?
");
$stmt->bind_param("i", $id);
$stmt->execute();
$carro = $stmt->get_result()->fetch_assoc();

// Se o veículo não for encontrado
if (!$carro) {
    die("<p style='text-align:center;font-size:1.1rem;'>Veículo não encontrado.</p>");
}

// =============================
// Busca as imagens do veículo
// =============================
$stmt_imgs = $con->prepare("SELECT caminho_imagem FROM imagem_veiculo WHERE cod_veiculo = ?");
$stmt_imgs->bind_param("i", $id);
$stmt_imgs->execute();
$imgs = $stmt_imgs->get_result()->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($carro['fabricante'].' '.$carro['modelo']) ?></title>
<link rel="stylesheet" href="../css/detalhes.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- ===============================
     NAVBAR FIXA
================================ -->
<nav class="navbar">
  <div class="voltar-container">
    <a href="veiculos.php?marca=<?= urlencode($carro['fabricante']) ?>" class="voltar">← Voltar</a>
  </div>
  <img src="../imagens/logo-sembgrecortada.png" class="logo" alt="Logo Stock Flow">
</nav>

<!-- ===============================
     CONTEÚDO PRINCIPAL
================================ -->
<div class="container-detalhes">
    <!-- GALERIA -->
    <div class="galeria">
        <div class="thumbs">
            <?php if (count($imgs) > 0): ?>
                <?php foreach ($imgs as $img): ?>
                    <img src="<?= htmlspecialchars($img['caminho_imagem']) ?>" 
                         onclick="mudarImagem('<?= htmlspecialchars($img['caminho_imagem']) ?>')">
                <?php endforeach; ?>
            <?php else: ?>
                <img src="../imagens/sem-foto.png" alt="Sem imagem disponível">
            <?php endif; ?>
        </div>

        <div class="imagem-principal">
            <img id="img-principal" 
                 src="<?= htmlspecialchars($imgs[0]['caminho_imagem'] ?? '../imagens/sem-foto.png') ?>" 
                 alt="Imagem principal do veículo">
        </div>
    </div>

    <!-- INFORMAÇÕES -->
    <div class="info-veiculo">
        <h2><?= htmlspecialchars($carro['fabricante'].' '.$carro['modelo']) ?></h2>

        <div class="info-bloco">
            <h4>Informações do veículo</h4>
            <p><strong>Fabricante:</strong> <?= htmlspecialchars($carro['fabricante']) ?></p>
            <p><strong>Modelo:</strong> <?= htmlspecialchars($carro['modelo']) ?></p>
            <p><strong>Cor:</strong> <?= htmlspecialchars($carro['cor']) ?></p>
            <p><strong>Carroceria:</strong> <?= htmlspecialchars($carro['carroceria']) ?></p>
            <p><strong>Tipo:</strong> <?= htmlspecialchars($carro['tipo']) ?></p>
            <p><strong>Ano:</strong> <?= htmlspecialchars($carro['ano']) ?></p>
            <p><strong>Quilometragem:</strong> <?= number_format($carro['quilometragem'], 0, ',', '.') ?> km</p>
            <p><strong>Valor:</strong> R$ <?= number_format($carro['valor'], 2, ',', '.') ?></p>
        </div>

        <div class="info-bloco">
            <h4>Empresa responsável</h4>
            <?php if (!empty($carro['nome_fantasia'])): ?>
                <p><strong>Nome:</strong> <?= htmlspecialchars($carro['nome_fantasia']) ?></p>
                <p><strong>Localização:</strong> <?= htmlspecialchars($carro['cidade']) ?> - <?= htmlspecialchars($carro['estado']) ?></p>
                <?php if (!empty($carro['telefone'])): ?>
                    <p><strong>Telefone:</strong> <?= htmlspecialchars($carro['telefone']) ?></p>
                    <a href="https://wa.me/55<?= preg_replace('/\D/', '', $carro['telefone']) ?>" target="_blank" class="btn-whatsapp">
                        💬 Contatar via WhatsApp
                    </a>
                <?php endif; ?>
            <?php else: ?>
                <p>⚠️ Nenhuma empresa associada a este veículo.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
function mudarImagem(src) {
    document.getElementById('img-principal').src = src;
}
</script>

<!-- ===============================
     RODAPÉ
================================ -->
<footer>
  <div class="footer-logo-bg">
      <img src="../imagens/logo-sembgrecortada.png" alt="Logo Stock Flow" height="50">
  </div>
  <p>© 2025 Stock Flow. Todos os direitos reservados.</p>
</footer>

</body>
</html>
