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
    <link rel="stylesheet" href="css/perfilFuncionario.css">

       <!-- Fontes de texto -->
       <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital@0;1&family=Special+Gothic+Expanded+One&display=swap" rel="stylesheet">


    <!-- icones -->
     <script src="https://kit.fontawesome.com/d15c84f3d2.js" crossorigin="anonymous"></script>

  
  </head>
  <body>
  <?php


require "PHP/conexao.php";

$id_funcionario = $_SESSION['id_funcionario'];

$sql = "SELECT id_funcionario , email ,nome, telefone , cpf FROM funcionario WHERE id_funcionario = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $id_funcionario);
$stmt->execute();
$result = $stmt->get_result();
$funcionario = $result->fetch_assoc();
?>

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


  

<div class="container">
  <div class="formulario">
    <h2 class="title">Informações do perfil</h2>
    <form id="Perfil" method="post">

      <div class="formss">
        <label>ID do Funcionário:</label>
        <input type="text" name="id_funcionario" id="id_funcionario" readonly>

        <label>Email:</label>
        <input type="email" name="email" id="email" readonly>

        <label>CPF:</label>
        <input type="text" name="cpf" id="cpf" readonly>
      </div>

      <div class="formss">
        <label>Nome:</label>
        <input type="text" name="nome" id="nome" readonly>

        <label>Telefone:</label>
        <input type="text" name="telefone" id="telefone" readonly>
      </div>

      <!-- Botão escondido, já que o formulário é apenas de visualização -->
      <button type="button" id="btnAtualizar" class="botoes" style="display: none;">Atualizar Funcionário</button> 
    </form>
  </div>
</div>


<script>
    
    window.funcionario = <?= json_encode($funcionario); ?>;

    document.getElementById('id_funcionario').value = funcionario.id_funcionario;
    document.getElementById('email').value = funcionario.email;
    document.getElementById('nome').value = funcionario.nome;
    document.getElementById('telefone').value = funcionario.telefone;
    document.getElementById('cpf').value = funcionario.cpf;
</script>


    
    
    
    <!-- jQuery primeiro, depois Popper.js, depois Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <!-- JavaScript (Opcional) -->
     <script src="js/validarFuncionarioPerfil.js"></script>
    <script src="js/perfilFuncionario.js"></script>
    <script src="js/sidebar.js"></script>
  </body>
</html>