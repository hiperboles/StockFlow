<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <!-- Meta tags Obrigatórias -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!-- Ligação css -->
     <link rel="stylesheet" href="css/avisos.css">

     <!-- Fontes de texto -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital@0;1&family=Special+Gothic+Expanded+One&display=swap" rel="stylesheet">


    <!-- icones -->
     <script src="https://kit.fontawesome.com/d15c84f3d2.js" crossorigin="anonymous"></script>

    <title>Início</title>
  </head>
  <body>
    <div class="container">

      <?php

      if(isset($_GET['i'])){
        $tipo = $_GET['i'];
      }

      if($tipo == 1){
        echo '<div class="warn">
        
          <div class="icon-aviso"><i class="fa-solid fa-xmark x-aviso" style="color: #ad2525;"></i></i></div>
          <h2>Erro! verifique os dados novamente.</h2>
          <p>Empresa não encontrada ou senha incorreta!</p>
          <a href="pagina-login.php">Voltar para o login</a>
        
        </div>';
      }else if($tipo == 2){
        echo '<div class="warn">
        
          <div class="icon-aviso"><i class="fa-solid fa-user-xmark x-aviso" style="color: #ad2525;"></i></div>
          <h2>Erro! verifique os dados novamente.</h2>
          <p>Usuario não encontrado!</p>
          <a href="pagina-login.php">Voltar para o login</a>
        
        </div>';
      }else if($tipo == 3){
        echo '<div class="warn">
        
          <div class="icon-aviso"><i class="fa-solid fa-check x-aviso" style="color: #2bab3a;"></i></div>
          <h2>Registro excluído.</h2>
          <a href="index.php">Voltar para o inicio</a>
        
        </div>';
      }else if($tipo == 4){
        echo '<div class="warn">
        
          <div class="icon-aviso"><i class="fa-solid fa-user-xmark x-aviso" style="color: #ad2525;"></i></div>
          <h2>Erro! Algo de errado ocorreu.</h2>
          <p>Não foi possivel excluir o registro.</p>
          <a href="perfilEmpresa.php">Voltar para o inicio</a>
        
        </div>';
      }else if($tipo == 5){
        echo '<div class="warn">
        
          <div class="icon-aviso"><i class="fa-solid fa-check x-aviso" style="color: #2bab3a;"></i></div>
          <h2>Alteração no registro</h2>
          <p>Registro alterado com sucesso.</p>
          <a href="perfilEmpresa.php">Voltar para o inicio</a>
        
        </div>';
      }else if($tipo == 6){
        echo '<div class="warn">
        
          <div class="icon-aviso"><i class="fa-solid fa-user-xmark x-aviso" style="color: #ad2525;"></i></div>
          <h2>Erro! Algo de errado ocorreu.</h2>
          <p>Não foi possivel alterar o registro.</p>
          <a href="perfilEmpresa.php">Voltar para o inicio</a>
          </div>';
      }

      ?>


    </div>
  </body>
</html>s