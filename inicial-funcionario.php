
<?php
session_start();
if (isset($_SESSION['id_empresa'])) {
  $nome = $_SESSION['nome_fantasia'];
  
}

if (isset($_SESSION['cod_empresa'])) {
  $nome = $_SESSION['nome_funcionario'];
  
}
?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <!-- Meta tags Obrigatórias -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!-- Ligação css -->
     <link rel="stylesheet" href="css/inicial-gerente.css">

     <!-- Fontes de texto -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital@0;1&family=Special+Gothic+Expanded+One&display=swap" rel="stylesheet">


    <!-- icones -->
     <script src="https://kit.fontawesome.com/d15c84f3d2.js" crossorigin="anonymous"></script>

    <title>Início</title>
  </head>
  <body>
    

  <?php


if (isset($_SESSION['id_empresa'])):
?>
<aside class="sidebar">
  <header>
    <button class="back sidebar-toggler">
      <i class="fa-solid fa-arrow-left"></i>
    </button>
  </header>

  <ul>
    <li>
      <a href="inicial-gerente.php" class="ul-obj"><span>
        <i class="fa-solid fa-house fa-2x"></i>
      </span>
      <span class="text">Inicio</span></a>
    </li>
    <li>
      <a href="cadastro-veiculo.php" class="ul-obj"><span>
        <i class="fa-solid fa-car fa-2x"></i>
      </span>
      <span class="text">Cadastro Veiculos</span></a>
    </li>

    <li>
      <a href="veiculos_vendidos.php" class="ul-obj"><span>
        <i class="fa-solid fa-car fa-2x"></i>
      </span>
      <span class="text">Vendidos</span></a>
    </li>
    
    <li>
      <a href="pagina-funcionario.php" class="ul-obj"><span>
        <i class="fa-solid fa-people-group fa-2x"></i>
      </span>
      <span class="text">Funcionários</span></a>
    </li>
    <li>
      <a href="" class="ul-obj"><span>
        <i class="fa-solid fa-chart-simple fa-2x"></i>
      </span>
      <span class="text">Relatórios</span></a>
    </li>
    <li>
      <a href="perfilEmpresa.php" class="ul-obj">
        <span><i class="fa-solid fa-circle-user fa-2x"></i></span>
        <span class="text">Perfil</span>
      </a>
    </li>
    <li>
      <a href="PHP/sair.php" class="ul-obj">
        <span><i class="fa-solid fa-right-from-bracket fa-2x"></i></span>
        <span class="text">Sair</span>
      </a>
    </li>
  </ul>
</aside>

<?php elseif (isset($_SESSION['id_funcionario'])): ?>
<aside class="sidebar">
  <header>
    <button class="back sidebar-toggler">
      <i class="fa-solid fa-arrow-left"></i>
    </button>
  </header>

  <ul>

    <li>
      <a href="inicial-funcionario.php" class="ul-obj"><span>
        <i class="fa-solid fa-house fa-2x"></i>
      </span>
      <span class="text">Inicio</span></a>
    </li>
    
    <li>
      <a href="cadastro-veiculo.php" class="ul-obj"><span>
        <i class="fa-solid fa-car fa-2x"></i>
      </span>
      <span class="text">Cadastro Veiculos</span></a>
    </li>

    <li>
      <a href="veiculos_vendidos.php" class="ul-obj"><span>
        <i class="fa-solid fa-hand-holding-dollar fa-2x"></i>
      </span>
      <span class="text">Vendidos</span></a>
    </li>
    <li>
      <a href="perfilFuncionario.php" class="ul-obj">
        <span><i class="fa-solid fa-circle-user fa-2x"></i></span>
        <span class="text">Perfil</span>
      </a>
    </li>
    <li>
      <a href="PHP/sair.php" class="ul-obj">
        <span><i class="fa-solid fa-right-from-bracket fa-2x"></i></span>
        <span class="text">Sair</span>
      </a>
    </li>
  </ul>
</aside>
<?php endif; ?>

    <div class="container my-4">
      <div class="search-container">
    <input type="text" id="buscaPlaca" placeholder="Buscar veículo pela placa..." />
    <button id="btnBuscar"><i class="fa-solid fa-magnifying-glass"></i></button>
  </div>
    
      <div id="localVeiculos" class="row">
        
      </div>
    </div>

    <div class="container-view">
  <div class="control" id="control">
    
  </div>

  <div class="control-imagens" id="control-imagens">

    <div class="slider">
      <div class="slides" id="slides">

      </div>

      <div class="botoes-imagens">
        <button class="prev" onclick="prevSlide()">&#10094</button>
        <button class="next" onclick="nextSlide()">&#10095</button>
      </div>
    </div>

  </div>
</div>

<div class="container-view-edit">
  <div class="control-edit" id="control-edit">
    
  </div>
</div>


 <!-- JavaScript (Opcional) -->
 <script src="js/sidebar.js"></script>
    <!-- jQuery primeiro, depois Popper.js, depois Bootstrap JS -->

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="js/buscaCarro.js"></script>
  </body>
</html>