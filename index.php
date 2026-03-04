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

<style>
.carrossel-container {
  position: relative;
  overflow: hidden;
  width: 100%;
}

.carrossel-track {
  display: flex;
  gap: 20px;
  transition: transform 0.5s ease;
}

.btn-left,
.btn-right {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  background-color: rgba(31, 79, 156, 0.8);
  color: #fff;
  border: none;
  font-size: 2rem;
  padding: 0.2rem 0.6rem;
  cursor: pointer;
  z-index: 10; /* garante que fique acima dos cards */
  border-radius: 5px;
}

.btn-left { left: 10px; }
.btn-right { right: 10px; }

.marca-card {
  flex: 0 0 auto;
  width: 150px;
  cursor: pointer;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.marca-card:hover {
  transform: scale(1.05);
  box-shadow: 0 8px 20px rgba(31, 79, 156, 0.3);
}

</style>

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
    <div class="carrossel-container" style="position: relative;">
        <h2 class="carrossel-title">Marcas procuradas</h2>
        <button class="btn btn-left" onclick="scrollCarrossel('left')">&#8249;</button>
        <div class="carrossel" id="carrossel">
            <div class="card marca-card" data-marca="AstonMartin">
            <img src="imagens/traced-astonmartin.png" alt="AstonMartin">
            <p class="modelo">AstonMartin</p>
        </div>

        <div class="card marca-card" data-marca="Audi">
            <img src="imagens/traced-audi.png" alt="Audi">
            <p class="modelo">Audi</p>
        </div>

        <div class="card marca-card" data-marca="BMW">
            <img src="imagens/traced-bmw.png" alt="BMW">
            <p class="modelo">BMW</p>
        </div>

        <div class="card marca-card" data-marca="BYD">
            <img src="imagens/traced-byd.png" alt="BYD">
            <p class="modelo">BYD</p>
        </div>

        <div class="card marca-card" data-marca="Cadillac">
            <img src="imagens/traced-cadillac.png" alt="Cadillac">
            <p class="modelo">Cadillac</p>
        </div>

        <div class="card marca-card" data-marca="Chery">
            <img src="imagens/traced-chery.png" alt="Chery">
            <p class="modelo">Chery</p>
        </div>

        <div class="card marca-card" data-marca="Chevrolet">
            <img src="imagens/traced-chevrolet.png" alt="Chevrolet">
            <p class="modelo">Chevrolet</p>
        </div>

        <div class="card marca-card" data-marca="Citroen">
            <img src="imagens/traced-citroen.png" alt="Citroen">
            <p class="modelo">Citroen</p>
        </div>

        <div class="card marca-card" data-marca="Dodge">
            <img src="imagens/traced-dodge.png" alt="Dodge">
            <p class="modelo">Dodge</p>
        </div>

        <div class="card marca-card" data-marca="Fiat">
            <img src="imagens/traced-fiat.png" alt="Fiat">
            <p class="modelo">Fiat</p>
        </div>

        <div class="card marca-card" data-marca="Ford">
            <img src="imagens/traced-ford.png" alt="Ford">
            <p class="modelo">Ford</p>
        </div>

        <div class="card marca-card" data-marca="Honda">
            <img src="imagens/traced-honda.png" alt="Honda">
            <p class="modelo">Honda</p>
        </div>

        <div class="card marca-card" data-marca="Hyundai">
            <img src="imagens/traced-hyundai.png" alt="Hyundai">
            <p class="modelo">Hyundai</p>
        </div>

        <div class="card marca-card" data-marca="Jeep">
            <img src="imagens/traced-jeep.png" alt="Jeep">
            <p class="modelo">Jeep</p>
        </div>

        <div class="card marca-card" data-marca="Kia">
            <img src="imagens/traced-kia.png" alt="Kia">
            <p class="modelo">Kia</p>
        </div>

        <div class="card marca-card" data-marca="LandRover">
            <img src="imagens/traced-landrover.png" alt="LandRover">
            <p class="modelo">LandRover</p>
        </div>

        <div class="card marca-card" data-marca="Mercedes">
            <img src="imagens/traced-mercedes.png" alt="Mercedes">
            <p class="modelo">Mercedes</p>
        </div>

        <div class="card marca-card" data-marca="Mitsubishi">
            <img src="imagens/traced-mitsubishi.png" alt="Mitsubishi">
            <p class="modelo">Mitsubishi</p>
        </div>

        <div class="card marca-card" data-marca="Nissan">
            <img src="imagens/traced-nissan.png" alt="Nissan">
            <p class="modelo">Nissan</p>
        </div>

        <div class="card marca-card" data-marca="Peugeot">
            <img src="imagens/traced-peugeot.png" alt="Peugeot">
            <p class="modelo">Peugeot</p>
        </div>

        <div class="card marca-card" data-marca="Porsche">
            <img src="imagens/traced-porsche.png" alt="Porsche">
            <p class="modelo">Porsche</p>
        </div>

        <div class="card marca-card" data-marca="Renault">
            <img src="imagens/traced-renault.png" alt="Renault">
            <p class="modelo">Renault</p>
        </div>

        <div class="card marca-card" data-marca="Tesla">
            <img src="imagens/traced-tesla.png" alt="Tesla">
            <p class="modelo">Tesla</p>
        </div>

        <div class="card marca-card" data-marca="Toyota">
            <img src="imagens/traced-toyota.png" alt="Toyota">
            <p class="modelo">Toyota</p>
        </div>

        <div class="card marca-card" data-marca="Volkswagen">
            <img src="imagens/traced-volkswagen.png" alt="Volkswagen">
            <p class="modelo">Volkswagen</p>
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
  const track = document.querySelector(".carrossel-track");
  const cards = document.querySelectorAll(".marca-card");
  const cardWidth = cards[0].offsetWidth + 20; // largura + gap
  let position = 0;

  // Movimento automático
  setInterval(() => {
    position -= 2; // velocidade do movimento
    // reinicia quando acabar
    if (Math.abs(position) >= track.scrollWidth / 2) position = 0;
    track.style.transform = `translateX(${position}px)`;
  }, 20);

  // Hover e click nos cards
  cards.forEach(card => {
    card.addEventListener("mouseenter", () => {
      card.style.transform = "scale(1.05)";
      card.style.boxShadow = "0 8px 20px rgba(31, 79, 156, 0.3)";
    });
    card.addEventListener("mouseleave", () => {
      card.style.transform = "scale(1)";
      card.style.boxShadow = "0 4px 12px rgba(0,0,0,0.1)";
    });
    card.addEventListener("click", () => {
      const marca = card.getAttribute("data-marca");
      window.location.href = `PHP/veiculos.php?marca=${encodeURIComponent(marca)}`;
    });
  });
});
</script>

</body>
</html>