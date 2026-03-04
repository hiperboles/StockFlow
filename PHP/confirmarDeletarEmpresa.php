<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <!-- Meta tags Obrigatórias -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS -->
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
      integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
      crossorigin="anonymous"
    />

    <title>Exclusão de Produto</title>

    <style>
      body {
        background-color: #f8f9fa;
      }
      .card {
        max-width: 500px;
        margin: 50px auto;
      }
      .btn-sim {
        background-color: #dc3545;
        border-color: #dc3545;
        color: white;
      }
      .btn-sim:hover {
        background-color: #c82333;
        border-color: #bd2130;
      }
      .btn-nao {
        background-color: #6c757d;
        border-color: #6c757d;
        color: white;
      }
      .btn-nao:hover {
        background-color: #5a6268;
        border-color: #545b62;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <div class="card shadow-sm p-4">
        <h3 class="text-center mb-4">Exclusão da Empresa</h3>
        <p class="text-center mb-4">Deseja excluir o registro?</p>
        <div class="d-flex justify-content-center gap-3">
          <?php
            session_start();
            $id_empresa = $_SESSION["id_empresa"];
            echo "<a href='excluirEmpresa.php?id=$id_empresa' class='btn btn-sim px-4'>Sim</a>";
            echo "<a href='../perfilEmpresa.php' class='btn btn-nao px-4'>Não</a>";
          ?>
        </div>
      </div>
    </div>

    <!-- JavaScript (Opcional) -->
    <!-- jQuery primeiro, depois Popper.js, depois Bootstrap JS -->
    <script
      src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
      integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
      integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
      integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
