<?php
session_start();
$abrirModal = false;
if (isset($_SESSION['abrir_modal_empresa_cadastrado']) && $_SESSION['abrir_modal_empresa_cadastrado']) {
    $abrirModal = true;
    unset($_SESSION['abrir_modal_empresa_cadastrado']);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

  <!-- Css -->
  <link rel="stylesheet" href="css/pagina-cadastro.css">

  <!-- Fontes -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital@0;1&family=Special+Gothic+Expanded+One&display=swap" rel="stylesheet">

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="js/buscaCep.js"></script>

  <title>Cadastro</title>

  <style>
    .error-message {
      color: red;
      font-size: 0.9em;
      display: block;
    }
    #forcaSenha {
      margin-top: 5px;
      font-weight: bold;
    }
  </style>
</head>
<body>
  
    <nav class="navbar">
      <img src="imagens/logo-sembgrecortada.png" class="logo">
      <ul class="buttons">
        <li><a href="index.php" class="links">Inicio</a></li>
        <li><a href="pagina-login.php" class="login">Login</a></li>
        
      </ul>
    </nav>



<div class="modal fade bd-example-modal-lg" data-backdrop = "false" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content p-4">
      <div class="modal-header">
        <h5 class="modal-title" id="myLargeModalLabel" style="color: red;">Aviso</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
        </button>
      </div>
      <div class="modal-body">
        Empresa ja cadastrada com esse email ou CNPJ!
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal" style="background-color: rgb(31, 79, 156); border: none;">Fechar</button>
      </div>
    </div>
  </div>
</div>
  <div class="container">
  <div class="title">
        <h2>Crie sua <span>conta</span></h2>
      </div>
    <form id="loginForm" method="post" action="PHP/CadEmpresa.php" novalidate>
      
    <div class="campos">
      <div class="divs" id="dados-empresa">
        <label for="cnpj">CNPJ</label>
        <input type="text" placeholder="Informe seu CNPJ" id="cnpj" name="cnpj" maxlength="14" autocomplete="off">
        <small class="error-message" id="error-cnpj"></small>

        <label for="nome-fantasia">Nome Fantasia</label>
        <input type="text" placeholder="Informe seu nome fantasia" id="nome-fantasia" name="nomefantasia" maxlength="20" autocomplete="off">
        <small class="error-message" id="error-nome-fantasia"></small>

        <label for="telefone">Telefone</label>
        <input type="tel" placeholder="DDD + Seu telefone" id="telefone" name="telefone" maxlength="11" autocomplete="off">
        <small class="error-message" id="error-telefone"></small>

        <label for="cep">CEP</label>
        <input type="text" placeholder="Seu CEP" id="cep" name="cep" maxlength="9" autocomplete="off">
        <small class="error-message" id="error-cep"></small>

        <label for="cidade">Cidade</label>
        <input type="text" placeholder="Informe sua cidade" id="cidade" name="cidade" autocomplete="off">
        <small class="error-message" id="error-cidade"></small>

        <label for="endereco">Endereço</label>
        <input type="text" placeholder="Seu endereço" id="endereco" name="endereco" autocomplete="off">
        <small class="error-message" id="error-endereco"></small>
      </div>

      <div class="divs" id="metade">
        <label for="numero">N°</label>
        <input type="text" placeholder="Informe seu N°" id="numero" name="numero"  autocomplete="off" maxlength="7">
        <small class="error-message" id="error-numero"></small>

        <label for="bairro">Bairro</label>
        <input type="text" placeholder="Seu bairro" id="bairro" name="bairro" autocomplete="off">
        <small class="error-message" id="error-bairro"></small>

        <label for="estado">Estado</label>
        <input type="text" placeholder="Seu Estado" id="estado" name="estado" autocomplete="off">
        <small class="error-message" id="error-estado"></small>

        <label for="email">Email</label>
        <input type="email" placeholder="Informe seu melhor email" id="email" name="email" autocomplete="off">
        <small class="error-message" id="error-email"></small>

        <label for="senha">Senha</label>
        <input type="password" placeholder="Informe sua senha" id="senha" name="senha" autocomplete="off">
        <button type="button" class="toggle-password mostrar-senha" data-target="senha" aria-label="Mostrar senha">Mostrar</button>
        <small class="error-message" id="error-senha"></small>
        <div id="forcaSenha"></div>

        <label for="consenha">Confirme sua senha</label>
        <input type="password" placeholder="Confirme sua senha" id="consenha" name="consenha" autocomplete="off">
        <button type="button" class="toggle-password mostrar-senha-confirm" data-target="consenha" aria-label="Mostrar senha">Mostrar</button>
        <small class="error-message" id="error-consenha"></small>
        </div>
        </div>
        <div class="btn">
        <input type="submit" id="btnCadastrar" value="Cadastrar">
        <p>Ir para o <a href="pagina-login.php">Login.</a></p>
        </div>
      
    </form>
  </div>

<script>


document.addEventListener('DOMContentLoaded', function() {
    const campos = [
        'cnpj', 'nome-fantasia', 'telefone', 'cep', 'cidade', 'endereco', 
        'numero', 'bairro', 'estado', 'email', 'senha', 'consenha'
    ];

   
    $('#telefone').mask('(00) 00000-0000');
    $('#cnpj').mask('00.000.000/0000-00');

    function validarSenha(valor, errorElement) {
        const forcaSenha = document.getElementById('forcaSenha');
        let mensagens = [];

        if (valor.length < 8) mensagens.push("mínimo 8 caracteres");
        if (!/[A-Z]/.test(valor)) mensagens.push("1 letra maiúscula");
        if (!/[a-z]/.test(valor)) mensagens.push("1 letra minúscula");
        if (!/[0-9]/.test(valor)) mensagens.push("1 número");
        if (!/[\!\@\#\$\%\^\&\*]/.test(valor)) mensagens.push("1 caractere especial (!@#$%^&*)");

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

    function validarCampo(id) {
        const campo = document.getElementById(id);
        const valor = campo.value.trim();
        const errorElement = document.getElementById('error-' + id);
        errorElement.textContent = ''; 

        if (!valor) {
            errorElement.textContent = 'Campo obrigatório';
            if (id === 'senha' || id === 'consenha') {
                document.getElementById('forcaSenha').textContent = '';
            }
            return false;
        }

        switch(id) {
           case 'cnpj':
    
            const cnpjLimpo = valor.replace(/\D/g, '');

            if (!/^\d{14}$/.test(cnpjLimpo)) {
        errorElement.textContent = 'CNPJ inválido (14 dígitos numéricos)';
        return false;
      }
    break;
    case 'numero':
      const apenasNumeros = valor.replace(/\D/g, '');

if (!/^\d+$/.test(apenasNumeros) ) {
  errorElement.textContent = 'Digite apenas números';
  return false;
}
break;

            case 'telefone':
                const telefoneNumeros = valor.replace(/\D/g, '');
                if (telefoneNumeros.length < 10 || telefoneNumeros.length > 11) {
                    errorElement.textContent = 'Telefone inválido (10 ou 11 dígitos)';
                    return false;
                }
                break;

            case 'cep':
                if (!/^\d{5}-?\d{3}$/.test(valor)) {
                    errorElement.textContent = 'CEP inválido (formato 00000-000 ou 00000000)';
                    return false;
                }
                break;

            case 'email':
                if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(valor)) {
                    errorElement.textContent = 'Email inválido';
                    return false;
                }
                break;

            case 'numero':
                if (isNaN(valor) || Number(valor) <= 0) {
                    errorElement.textContent = 'Número inválido';
                    return false;
                }
                break;

            case 'senha':
                return validarSenha(valor, errorElement);

            case 'consenha':
                const senha = document.getElementById('senha').value.trim();
                if (!valor) {
                    errorElement.textContent = 'Campo obrigatório';
                    return false;
                }
                if (valor !== senha) {
                    errorElement.textContent = 'As senhas não conferem';
                    return false;
                }
                break;
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

        
        const senhaValor = document.getElementById('senha').value.trim();
        const consenhaValor = document.getElementById('consenha').value.trim();
        if (senhaValor !== consenhaValor) {
            valido = false;
            document.getElementById('error-consenha').textContent = 'As senhas não conferem';
        }

        if (!valido) {
            e.preventDefault();
            alert('Por favor, corrija os erros no formulário.');
        }
    });

    
    <?php if ($abrirModal): ?>
        $(document).ready(function () {
            $('.bd-example-modal-lg').modal('show');
        });
    <?php endif; ?>
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
  <!-- Bootstrap JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  <script src="js/modal.js"></script>
</body>
</html>
