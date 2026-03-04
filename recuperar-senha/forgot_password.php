<?php require '../PHP/conexao.php'; ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Recuperação de Senha</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background-color: #f8f9fa;
    }
    .container {
      max-width: 400px;
      margin-top: 80px;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="card shadow-sm p-4">
      <h3 class="mb-4 text-center">Recuperar Senha</h3>
      <form method="POST" action="enviar_email.php">
        <div class="form-group">
          <input 
            type="email" 
            name="email" 
            class="form-control" 
            placeholder="Seu e-mail" 
            required 
            autofocus
          >
        </div>
        <button type="submit" class="btn btn-primary btn-block">Enviar link de recuperação</button>
      </form>
    </div>
  </div>
</body>
</html>
