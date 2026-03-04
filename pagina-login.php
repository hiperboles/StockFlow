<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/pagina-login.css">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital@0;1&family=Special+Gothic+Expanded+One&display=swap" rel="stylesheet">
  <title>Login</title>
</head>
<body>
    <nav class="navbar">
      <img src="imagens/logo-sembgrecortada.png" class="logo">
      <ul class="buttons">
        <li><a href="index.php" class="links">Inicio</a></li>
        <li><a href="pagina-cadastro-empresa.php" class="login">Cadastro</a></li>
      </ul>
    </nav>

  <div class="container">
    <img src="imagens/logo-sembgrecortada.png" alt="">
    <form id="loginForm" method="post">
      <h2>Faça <span>login</span>.</h2>
      
      <div class="div-form-checks">
  <div class="form-check">
    <input class="form-check-input" type="radio" name="tipo_usuario" id="empresa" value="empresa" checked>
    <label class="form-check-label" for="empresa">Empresa</label>
  </div>

  <div class="form-check">
    <input class="form-check-input" type="radio" name="tipo_usuario" id="funcionario" value="funcionario">
    <label class="form-check-label" for="funcionario">Funcionário</label>
  </div>
</div>

      <div class="input-box">
        <input type="email" class="log" placeholder="Email" id="email" name="email" required>
      </div>
      <div class="input-box">
        <input type="password" class="log" placeholder="Senha" id="senha" name="senha" required maxlength="15">
        <button type="button" class="toggle-password" data-target="senha" aria-label="Mostrar senha">Mostrar</button>
      </div>



      <p>Não possui conta? <a href="pagina-cadastro-empresa.php" class="links">Cadastre-se</a></p>
      <p>Esqueceu a senha? <a href="recuperar-senha/forgot_password.php" class="links">Recupere</a></p>
      <input type="submit" class="button" value="Login" id="botaoLogar">
    </form>
  </div>

  <script>
    const form = document.getElementById('loginForm');
    form.addEventListener('submit', function(e) {
      e.preventDefault();
      const tipo = document.querySelector('input[name="tipo_usuario"]:checked').value;
      if (tipo === 'empresa') {
        form.action = 'PHP/login_empresa.php';
      } else {
        form.action = 'PHP/login_funcionario.php';
      }
      form.submit();
    });

    function togglePasswordVisibility(btn) {
    const targetId = btn.getAttribute('data-target');
    const input = document.getElementById(targetId);
    if (!input) return;

    if (input.type === 'password') {
        input.type = 'text';
        btn.textContent = 'Ocultar';
        btn.setAttribute('aria-pressed', 'true');
    } else {
        input.type = 'password';
        btn.textContent = 'Mostrar';
        btn.setAttribute('aria-pressed', 'false');
    }
}

// liga eventos aos botões já presentes no DOM
document.querySelectorAll('.toggle-password').forEach(function(btn) {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        togglePasswordVisibility(btn);
    });

    // Suporte via teclado (Enter / Space)
    btn.addEventListener('keyup', function(e) {
        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            togglePasswordVisibility(btn);
        }
    });
});
  </script>
  
</body>
</html>
