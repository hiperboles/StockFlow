<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="css/pagina-inicial.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital@0;1&family=Special+Gothic+Expanded+One&display=swap" rel="stylesheet">

    <title>Stock Flow</title>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
    <img src="imagens/logo-sembgrecortada.png" class="logo">
    <ul class="buttons">
        <li><a href="pagina-login.php" class="links">Login</a></li>
        <li><a href="pagina-cadastro-empresa.php" class="login">Cadastrar</a></li>
    </ul>
</nav>

<!-- CARROSSEL DE MARCAS -->
<section class="inicio">
    <div class="carrossel-container">
        <h2 class="carrossel-title">Marcas procuradas</h2>
        <button class="btn btn-left" onclick="scrollCarrossel('left')">&#8249;</button>
        <div class="carrossel" id="carrossel">
            <div class="card marca-card" data-marca="Toyota">
                <img src="imagens/traced-toyota.png" alt="Toyota">
                <p class="modelo">Toyota</p>
            </div>

            <div class="card marca-card" data-marca="Honda">
                <img src="imagens/traced-honda.png" alt="Honda">
                <p class="modelo">Honda</p>
            </div>

            <div class="card marca-card" data-marca="BYD">
                <img src="imagens/traced-byd.png" alt="BYD">
                <p class="modelo">BYD</p>
            </div>

            <div class="card marca-card" data-marca="Nissan">
                <img src="imagens/traced-nissan.png" alt="Nissan">
                <p class="modelo">Nissan</p>
            </div>
        </div>
        <button class="btn btn-right" onclick="scrollCarrossel('right')">&#8250;</button>
    </div>
</section>

<!-- SOBRE NÓS -->
<section class="sobreNos">
    <video class="videocarro" autoplay loop muted playsinline>
        <source src="videos/carrofundo.mp4" type="video/mp4">
    </video>
    <div class="content">
        <h2 class="hSobre">Controle seu estoque, <span>acelere</span> seus resultados.</h2>
        <p class="descricao">
            O Stock Flow é uma ferramenta desenvolvida com foco na modernização, praticidade e eficiência da gestão de estoque de veículos.
        </p>
    </div>
</section>

<!-- RECURSOS -->
<section class="recursos">
    <h2>Fun<span>ções</span></h2>
    <div class="rec">
        <div class="info">
            <h3>Equ<span>ipe</span></h3>
            <div class="list-content">
                <img src="videos/teamwork.gif" alt="">
                <ul>
                    <li>Gestão eficiente da equipe.</li>
                    <li>Controle de processos internos.</li>
                     <li>Comunicação integrada entre setores.</li>
                     <li>Delegação de tarefas de forma organizada.</li>
                     <li>Monitoramento do desempenho individual e coletivo.</li>
                </ul>
            </div>
        </div>

        <div class="info">
            <h3><span>Otimização</span> e Eficiência</h3>
            <div class="list-content">
                <img src="videos/productivity.gif" alt="">
                <ul>
                    <li>Automatização de tarefas repetitivas.</li>
                    <li>Melhora na performance do sistema.</li>
                    <li>Redução de erros operacionais.</li>
                    <li>Economia de tempo em processos administrativos.</li>
                    <li>Aumento da produtividade geral da empresa.</li>
                </ul>
            </div>
        </div>

        <div class="info">
            <h3>Controle de <span>Estoque</span></h3>
            <div class="list-content">
                <img src="videos/task-management.gif" alt="">
                <ul>
                    <li>Visualização completa do estoque.</li>
                    <li>Registro e monitoramento de veículos.</li>
                    <li>Controle automático de entrada e saída.</li>
                    <li>Monitoramento contínuo para evitar escassez no estoque.</li>
                    <li>Histórico detalhado de movimentações e atualizações.</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- RODAPÉ -->
<footer>
    <div class="footer-logo-bg">
        <img src="imagens/logo-sembgrecortada.png" alt="Logo Stock Flow" style="height: 50px;">
    </div>
    <p>© 2025 Stock Flow. Todos os direitos reservados.</p>
</footer>

<!-- SCRIPTS -->
<script src="js/carrossel.js"></script>
<script>
document.addEventListener("DOMContentLoaded", () => {
    const cards = document.querySelectorAll(".marca-card");
    cards.forEach(card => {
        card.addEventListener("click", () => {
            const marca = card.getAttribute("data-marca");
            if (!marca) return;
            window.location.href = `PHP/veiculos.php?marca=${encodeURIComponent(marca)}`;
        });
    });
});
</script>

</body>
</html>
