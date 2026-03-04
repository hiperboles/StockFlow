<?php

session_start();

if (isset($_SESSION['id_empresa'])) {
  $nome = $_SESSION['nome_fantasia'];
  
}

if (isset($_SESSION['cod_empresa'])) {
  $nome = $_SESSION['nome_funcionario'];
  
}

if (!empty($_SESSION['erro_email'])) {
  echo "<p style='color:red;'>".$_SESSION['erro_email']."</p>";
  unset($_SESSION['erro_email']);
}
if (!empty($_SESSION['erro_cnpj'])) {
  echo "<p style='color:red;'>".$_SESSION['erro_cnpj']."</p>";
  unset($_SESSION['erro_cnpj']);
}
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/buscaCep.js"></script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital@0;1&family=Special+Gothic+Expanded+One&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/d15c84f3d2.js" crossorigin="anonymous"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="css/perfilEmpresa.css">
   
    <title>Perfil da Empresa</title>
</head>
<body>

<?php

require "PHP/conexao.php";

$id_empresa = $_SESSION['id_empresa'];

$sql = "SELECT id_empresa, email, cnpj, nome_fantasia, telefone, cep, endereco, cidade, estado, numero, bairro 
        FROM empresa 
        WHERE id_empresa = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $id_empresa);
$stmt->execute();
$result = $stmt->get_result();
$empresa = $result->fetch_assoc();
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
        <i class="fa-solid fa-hand-holding-dollar fa-2x"></i>
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
      <a href="relatorioTeste.php" class="ul-obj"><span>
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
  <span>
  <i class="fa-solid fa-circle-user fa-2x"></i>
</span>
<?php
  echo "<span class='text'>$nome</span>";
?>

    </li>
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
        <i class="fa-solid fa-car fa-2x"></i>
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


<!-- CONTAINER -->
<div class="container">
    <div class="formulario">
    <h2 class="title">Informações do perfil</h2>
    <form id="Perfil" method="post">

    <div class="formss">
        <label id="id_empresa_label">ID da Empresa:</label>
        <input type="text" name="id_empresa" id="id_empresa" readonly>

        <label>Email:</label>
        <input type="email" name="email" id="email" required >

        <label>CNPJ:</label>
        <input type="text" name="cnpj" id="cnpj" required maxlength="14">

        <label>Nome Fantasia:</label>
        <input type="text" name="nome_fantasia" id="nome_fantasia" required maxlength="30">

        <label>Telefone:</label>
        <input type="text" name="telefone" id="telefone" required maxlength="15">

        <label>CEP:</label>
        <input type="text" name="cep" id="cep" required maxlength="10">
    </div>
        <!-- separar -->

        <div class="formss">

        <label>Endereço:</label>
        <input type="text" name="endereco" id="endereco" required maxlength="50">

        <label>Número:</label>
        <input type="text" name="numero" id="numero" required maxlength="7">

        <label>Bairro:</label>
        <input type="text" name="bairro" id="bairro" required maxlength="40">

        <label>Cidade:</label>
        <input type="text" name="cidade" id="cidade" required readonly maxlength="50">

        <label>Estado:</label>
        <input type="text" name="estado" id="estado" required readonly maxlength="5">
        </div>
         <button type="button" id="btnAtualizar" class="botoes">Atualizar Empresa</button> 
         <button type="button" id="btnDeletar" class="botoes">Deletar Empresa</button>
    </form>
    </div>
</div>

<script>
    window.empresa = <?= json_encode($empresa); ?>;

    document.getElementById('id_empresa').value = empresa.id_empresa;
    document.getElementById('email').value = empresa.email;
    document.getElementById('cnpj').value = empresa.cnpj;
    document.getElementById('nome_fantasia').value = empresa.nome_fantasia;
    document.getElementById('telefone').value = empresa.telefone;
    document.getElementById('cep').value = empresa.cep;
    document.getElementById('endereco').value = empresa.endereco;
    document.getElementById('numero').value = empresa.numero;
    document.getElementById('bairro').value = empresa.bairro;
    document.getElementById('cidade').value = empresa.cidade;
    document.getElementById('estado').value = empresa.estado;
   
</script>


<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Plugins -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

<!-- Seus scripts -->
<script src="js/validadarEmpresaPerfil.js"></script>
<script src="js/sidebar.js"></script>


</body>
</html>
