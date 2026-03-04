<?php
include 'conexao.php';
$fabricante = $_GET['marca'] ?? ''; // continua vindo da URL ?marca=Honda
if (!$fabricante) die("Nenhum fabricante selecionado.");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Veículos - <?= htmlspecialchars($fabricante) ?></title>

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- CSS personalizado -->
<link rel="stylesheet" href="../css/veiculos.css">
</head>
<body>

<!-- ================= NAVBAR ================= -->
<nav class="navbar">
  <div class="voltar-container">
    <a href="../index.php" class="voltar">← Voltar</a>
  </div>
  <img src="../imagens/logo-sembgrecortada.png" alt="Logo Stock Flow" class="logo">
</nav>

<!-- ================= TÍTULO ================= -->
<h2>Veículos <?= htmlspecialchars($fabricante) ?></h2>

<!-- ================= BARRA DE PESQUISA ================= -->
<div class="search-bar">
    <input type="text" id="busca" placeholder="Pesquise modelo, ano, tipo e muito mais..." class="search-input">
    <button id="btnSearch" class="search-btn">🔍</button>
</div>

<!-- ================= RESULTADO ================= -->
<div id="resultado" class="grid-carros"></div>

<!-- ================= RODAPÉ ================= -->
<footer>
  <div class="footer-logo-bg">
      <img src="../imagens/logo-sembgrecortada.png" alt="Logo Stock Flow" height="50">
  </div>
  <p>© 2025 Stock Flow. Todos os direitos reservados.</p>
</footer>

<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- ================= SCRIPT ================= -->
<script>
const fabricante = <?= json_encode($fabricante) ?>;

const input = document.getElementById('busca');
const resultado = document.getElementById('resultado');
const btn = document.getElementById('btnSearch');

async function buscar() {
    const form = new FormData();
    form.append('fabricante', fabricante);
    form.append('busca', input.value);

    try {
        const res = await fetch('buscar_veiculos.php', {
            method: 'POST',
            body: form
        });
        const html = await res.text();
        resultado.innerHTML = html;

        // Reinicializa os carrosséis do Bootstrap após carregar o conteúdo
        const carrosseis = document.querySelectorAll('.carousel');
        carrosseis.forEach(c => new bootstrap.Carousel(c));
    } catch (err) {
        console.error(err);
        resultado.innerHTML = '<p style="text-align:center;">Erro ao buscar veículos.</p>';
    }
}

// eventos de busca
input.addEventListener('input', buscar);
btn.addEventListener('click', (e) => { e.preventDefault(); buscar(); });
window.addEventListener('DOMContentLoaded', buscar);

// Navbar com sombra ao rolar
window.addEventListener("scroll", function() {
  const navbar = document.querySelector(".navbar");
  if (window.scrollY > 10) {
    navbar.classList.add("scrolled");
  } else {
    navbar.classList.remove("scrolled");
  }
});
</script>

</body>
</html>
