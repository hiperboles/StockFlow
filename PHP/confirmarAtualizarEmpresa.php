<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <!-- Meta tags Obrigatórias -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/atualizarEmpresa.css">
    <title>Exclusão de Produto</title>
  </head>
  <body>
 
   <div class="container">
    <h3> Atualizar  Empresa </h3>
	
   <?php
     session_start();
      $id_empresa=$_SESSION["id_empresa"];
    $email_att = $_POST['email'];
    $cnpj_att = $_POST['cnpj'];
    $nome_fantasia_att = $_POST['nome_fantasia'];
    $telefone_att = $_POST['telefone'];
    $cep_att = $_POST['cep'];
    $endereco_att = $_POST['endereco'];
    $numero_att = $_POST['numero'];
    $bairro_att = $_POST['bairro'];
    $cidade_att = $_POST['cidade'];
    $estado_att = $_POST['estado'];

    require "conexao.php";


$sql = "SELECT email , cnpj ,nome_fantasia, telefone, cep, endereco, cidade, estado, numero, bairro FROM empresa WHERE id_empresa = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $id_empresa);
$stmt->execute();
$result = $stmt->get_result();
$empresa = $result->fetch_assoc();



$email          = $empresa['email'];
$cnpj           = $empresa['cnpj'];
$nome_fantasia  = $empresa['nome_fantasia'];
$telefone       = $empresa['telefone'];
$cep            = $empresa['cep'];
$endereco       = $empresa['endereco'];
$cidade         = $empresa['cidade'];
$estado         = $empresa['estado'];
$numero         = $empresa['numero'];
$bairro         = $empresa['bairro'];


      

    ?>

<form action="atualizarEmpresa.php" method="POST">
    <input type="hidden" name="id_empresa" value="<?php echo $id_empresa; ?>">
    <input type="hidden" name="email" value="<?php echo $email_att; ?>">
    <input type="hidden" name="cnpj" value="<?php echo $cnpj_att; ?>">
    <input type="hidden" name="nome_fantasia" value="<?php echo $nome_fantasia_att; ?>">
    <input type="hidden" name="telefone" value="<?php echo $telefone_att; ?>">
    <input type="hidden" name="cep" value="<?php echo $cep_att; ?>">
    <input type="hidden" name="endereco" value="<?php echo $endereco_att; ?>">
    <input type="hidden" name="numero" value="<?php echo $numero_att; ?>">
    <input type="hidden" name="bairro" value="<?php echo $bairro_att; ?>">
    <input type="hidden" name="cidade" value="<?php echo $cidade_att; ?>">
    <input type="hidden" name="estado" value="<?php echo $estado_att; ?>">

    <button type="submit" class="btn btn-success">Sim</button>
    <a href="../perfilEmpresa.php" class="btn btn-danger">Não</a>
</form>

<table class="table table-bordered mt-4">
  <thead class="thead-dark">
    <tr>
      <th>Campo</th>
      <th>Valor Atual</th>
      <th>Novo Valor</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Email</td>
      <td><?php echo $email; ?></td>
      <td><?php echo $email_att; ?></td>
    </tr>
    <tr>
      <td>CNPJ</td>
      <td><?php echo $cnpj; ?></td>
      <td><?php echo $cnpj_att; ?></td>
    </tr>
    <tr>
      <td>Nome Fantasia</td>
      <td><?php echo $nome_fantasia; ?></td>
      <td><?php echo $nome_fantasia_att; ?></td>
    </tr>
    <tr>
      <td>Telefone</td>
      <td><?php echo $telefone; ?></td>
      <td><?php echo $telefone_att; ?></td>
    </tr>
    <tr>
      <td>CEP</td>
      <td><?php echo $cep; ?></td>
      <td><?php echo $cep_att; ?></td>
    </tr>
    <tr>
      <td>Endereço</td>
      <td><?php echo $endereco; ?></td>
      <td><?php echo $endereco_att; ?></td>
    </tr>
    <tr>
      <td>Número</td>
      <td><?php echo $numero; ?></td>
      <td><?php echo $numero_att; ?></td>
    </tr>
    <tr>
      <td>Bairro</td>
      <td><?php echo $bairro; ?></td>
      <td><?php echo $bairro_att; ?></td>
    </tr>
    <tr>
      <td>Cidade</td>
      <td><?php echo $cidade; ?></td>
      <td><?php echo $cidade_att; ?></td>
    </tr>
    <tr>
      <td>Estado</td>
      <td><?php echo $estado; ?></td>
      <td><?php echo $estado_att; ?></td>
    </tr>
  </tbody>
</table>


  </div>

    <!-- JavaScript (Opcional) -->
    <!-- jQuery primeiro, depois Popper.js, depois Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>