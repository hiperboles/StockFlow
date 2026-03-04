<?php
require '../PHP/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $token = $_GET['token'] ?? '';

    $stmt = $con->prepare("SELECT * FROM password_resets WHERE token = ? AND expires_at > NOW()");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    $reset = $result->fetch_assoc();

    if (!$reset) {
        die('<div class="alert alert-danger text-center mt-5">Token inválido ou expirado.</div>');
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Redefinir Senha</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 450px;
            margin-top: 80px;
        }
        .error-message {
            color: red;
            font-size: 0.9em;
        }
        #forcaSenha {
            font-weight: bold;
            margin-top: 5px;
        }
        .toggle-password {
  border: none;
  background: #1f4f9c;
  color: #fff;
  font-size: 13px;
  cursor: pointer;
  padding: 3px 3px;
  border-radius: 6px;
  transition: all 0.25s ease;
  outline: none;
  margin-top: 5px;
}

.toggle-password:hover {
  background: #2a63c4;
}

.toggle-password:active {
  background: #163b7a;
}

.toggle-password:focus {
  outline: none;
  box-shadow: none;
}
    </style>
</head>
<body>
    <div class="container">
        <div class="card shadow-sm p-4">
            <h3 class="mb-4 text-center">Redefinir Senha</h3>
            <form method="POST" id="loginForm">
                <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

                <div class="form-group">
                    <label for="senha">Nova Senha</label>
                    <input type="password" class="form-control" placeholder="Informe sua senha" id="senha" name="senha" autocomplete="off">
                    <button type="button" class="toggle-password" data-target="senha" aria-label="Mostrar senha">Mostrar</button>
                    <small class="error-message" id="error-senha"></small>
                    <div id="forcaSenha"></div>
                </div>

                <div class="form-group">
                    <label for="consenha">Confirme sua Senha</label>
                    <input type="password" class="form-control" placeholder="Confirme sua senha" id="consenha" name="consenha" autocomplete="off">
                    <button type="button" class="toggle-password" data-target="consenha" aria-label="Mostrar senha">Mostrar</button>
                    <small class="error-message" id="error-consenha"></small>
                </div>

                <button type="submit" class="btn btn-primary btn-block mt-3">Redefinir Senha</button>
            </form>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const campos = ['senha', 'consenha'];

        function validarCampo(id) {
            const valor = document.getElementById(id).value.trim();
            const errorElement = document.getElementById('error-' + id);
            errorElement.textContent = '';

            if (!valor) {
                errorElement.textContent = 'Campo obrigatório';
                if (id === 'senha' || id === 'consenha') {
                    document.getElementById('forcaSenha').textContent = '';
                }
                return false;
            }

            if (id === 'senha') {
                let mensagens = [];
                if (valor.length < 8) mensagens.push("mínimo 8 caracteres");
                if (!valor.match(/[A-Z]/)) mensagens.push("1 letra maiúscula");
                if (!valor.match(/[a-z]/)) mensagens.push("1 letra minúscula");
                if (!valor.match(/[0-9]/)) mensagens.push("1 número");
                if (!valor.match(/[\!\@\#\$\%\^\&\*]/)) mensagens.push("1 caractere especial (!@#$%^&*)");

                const forcaSenha = document.getElementById('forcaSenha');

                if (mensagens.length === 0) {
                    forcaSenha.style.color = "green";
                    forcaSenha.textContent = "Senha forte ✅";
                    return true;
                } else {
                    forcaSenha.style.color = "red";
                    forcaSenha.textContent = "Faltando: " + mensagens.join(", ");
                    return false;
                }
            }

            if (id === 'consenha') {
                const senha = document.getElementById('senha').value;
                if (valor !== senha) {
                    errorElement.textContent = 'As senhas não conferem';
                    return false;
                }
            }

            return true;
        }

        campos.forEach(function(id) {
            const input = document.getElementById(id);
            input.addEventListener('input', function() {
                validarCampo(id);
            });
            input.addEventListener('blur', function() {
                validarCampo(id);
            });
        });

        const form = document.getElementById('loginForm');
        form.addEventListener('submit', function(e) {
            let valido = true;
            campos.forEach(function(id) {
                if (!validarCampo(id)) {
                    valido = false;
                }
            });
            if (!valido) {
                e.preventDefault();
                alert('Por favor, corrija os erros no formulário.');
            }
        });
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
<?php
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'] ?? '';
    $newPasswordPlain = $_POST['senha'] ?? ''; // Corrigido: o campo é "senha" no formulário

    if (!$token || !$newPasswordPlain) {
        die('<div class="alert alert-danger text-center mt-5">Dados incompletos.</div>');
    }

    $stmt = $con->prepare("SELECT * FROM password_resets WHERE token = ? AND expires_at > NOW()");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    $reset = $result->fetch_assoc();

    if ($reset) {
        $email = $reset['email'];
        $newPasswordHash = password_hash($newPasswordPlain, PASSWORD_DEFAULT);

        $stmt = $con->prepare("UPDATE empresa SET senha = ? WHERE email = ?");
        $stmt->bind_param("ss", $newPasswordHash, $email);
        $stmt->execute();

        $stmt = $con->prepare("DELETE FROM password_resets WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();

        header('Location: ../pagina-login.php');
        exit();
    } else {
        echo '<div class="alert alert-danger text-center mt-5">Token inválido ou expirado.</div>';
    }
}
?>


