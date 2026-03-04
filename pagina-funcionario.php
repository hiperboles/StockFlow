<?php
session_start();
$abrirModal = false;

if (isset($_SESSION['abrir_modal_funcionario_cadastrado']) && $_SESSION['abrir_modal_funcionario_cadastrado']) {
    $abrirModal = true;
    unset($_SESSION['abrir_modal_funcionario_cadastrado']);
}
if (isset($_SESSION['id_empresa'])) {
    $nome = $_SESSION['nome_fantasia'];
    
  }
  
  if (isset($_SESSION['cod_empresa'])) {
    $nome = $_SESSION['nome_funcionario'];
    
  }
?>

<?php

if (!empty($_SESSION['erro_email'])) {
    echo "<p style='color:red;'>".$_SESSION['erro_email']."</p>";
    unset($_SESSION['erro_email']);
}
if (!empty($_SESSION['erro_cpf'])) {
    echo "<p style='color:red;'>".$_SESSION['erro_cpf']."</p>";
    unset($_SESSION['erro_cpf']);
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital@0;1&family=Special+Gothic+Expanded+One&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/d15c84f3d2.js" crossorigin="anonymous"></script>

    <!-- CSS Custom -->
    <link rel="stylesheet" href="css/pagina-funcionarios.css">
   
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
   
    <title>Funcionários</title>

   

<style>
    .error-message {
      color: red;
      font-size: 0.9em;
      margin-top: 2px;
      margin-bottom: 8px;
      display: block;
    }
    #forcaSenha {
      margin-top: 5px;
      font-weight: bold;
    }
  </style>
</head>
<body>

<script>
    
    setTimeout(function() {
        const erroEmail = document.getElementById('erro-email');
        const erroCpf = document.getElementById('erro-cpf');

        if (erroEmail) {
            erroEmail.style.display = 'none';
        }
        if (erroCpf) {
            erroCpf.style.display = 'none';
        }
    }, 5000);
</script>


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
    <div class="funcionarios">
        <!-- MODAL -->
        <div class="modal fade bd-example-modal-lg" data-backdrop="false" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content p-4">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myLargeModalLabel" style="color: red;">Aviso</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body">
                        CPF ou Email já cadastrado!
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal" style="background-color: rgb(31, 79, 156); border: none;">Fechar</button>
                    </div>
                </div>
            </div> 
        </div>

        <h2 class="hFuncionarios">Funci<span class="espanta">onários</span></h2>

        <?php
        include("PHP/conexao.php");
        $cod_empresa = $_SESSION['id_empresa'];
        $sql = "SELECT * FROM funcionario WHERE cod_empresa = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $cod_empresa);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            echo "<button class='users button-data' id='{$row['id_funcionario']}' onclick='consulta(this)'>";
            echo "<i class='fa-solid fa-address-card mCard'></i> " . htmlspecialchars($row['nome']);
            echo "</button>";
        }

        $stmt->close();
        $con->close();
        ?>
    </div>

    <!-- WIDGET BAR -->
    <div class="wid-bar">
        <div class="bar">
            <button class="bar-button trash">
                <i class="fa-solid fa-trash" style="color: #ffffff;"></i>
            </button>
            <button class="bar-button plus">
                <i class="fa-solid fa-plus" style="color: #ffffff;"></i>
            </button>
            <button class="bar-button edit">
                <i class="fa-solid fa-pen-to-square" style="color: #ffffff;"></i>
            </button>
        </div>
    </div>

    <!-- FORMULÁRIO DE CADASTRO -->
    <div class="cadFuncionario">
        <form id="loginForm" action="PHP/CadFuncionario.php" method="post">
            <h2>Cadastro de <span class="espanta">Funcionário</span>.</h2>

            <label for="nome">Nome</label>
            <input type="text" name="nome" id="nome" class="inps" required autocomplete="off" maxlength="50" placeholder="Informe seu nome">
            <small class="error-message" id="error-nome"></small>

            <label for="cpf">CPF</label>
            <input type="text" name="cpf" id="cpf" class="inps" required maxlength="11" autocomplete="off" placeholder="Informe seu cpf">

            <small class="error-message" id="error-cpf"></small>

            <label for="telefone">Telefone</label>
            <input type="text" id="telefone" name="telefone" class="inps" required maxlength="11" autocomplete="off" placeholder="Informe seu telefone">
            <small class="error-message" id="error-telefone"></small>

            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="inps" required autocomplete="off" placeholder="Informe seu email">
            <small class="error-message" id="error-email"></small>

            <label for="senha">Senha</label>
            <input type="password" placeholder="Informe sua senha" id="senha" name="senha" autocomplete="off" class="inps">
            <button type="button" class="toggle-password" data-target="senha" aria-label="Mostrar senha">Mostrar</button>
            <small class="error-message" id="error-senha"></small>
            <div id="forcaSenha"></div>

            <label for="consenha">Confirme sua senha</label>
            <input type="password" placeholder="Confirme sua senha" id="consenha" name="consenha" autocomplete="off" class="inps">
            <button type="button" class="toggle-password" data-target="consenha" aria-label="Mostrar senha">Mostrar</button>
            <small class="error-message" id="error-consenha"></small>

            <input type="submit" id="btnCadastrar" value="Cadastrar" class="subButton">
            <span id="forcaSenha"></span>
        </form>
    </div>

    <!-- CONSULTA DE FUNCIONÁRIO -->
    <div class="divConsulta">
        <div class="consultaDados">
            <form id="loginForm2" class="formConsulta" method="post">
                <div class="logo-id">
                    <i class="fa-solid fa-id-card-clip fa-sm"></i>
                </div>

                <label class="label-funcionario">ID do Funcionário:</label>
                <input type="text" id="consulta_id_funcionario" readonly class="inpsData" name="consulta_id_funcionario">

                <label class="label-email">Email:</label>
                <input type="email" id="consulta_email" readonly class="inpsData" name="consulta_email">

                <label>Nome:</label>
                <input type="text" id="consulta_nome" readonly class="inpsData" name="consulta_nome" maxlength="30"> 

                <label>Telefone:</label>
                <input type="text" id="consulta_telefone" readonly class="inpsData" name="consulta_telefone"maxlength="15">

                <label>CPF:</label>
                <input type="text" id="consulta_cpf" readonly class="inpsData" name="consulta_cpf" maxlength="11">

                <button type="button" class="excluir-botao" id="btnExcluir">Excluir</button>
                <button type="button" class="edit-botao" id="btnAtualizar">Salvar</button>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const campos = ['consulta_cpf', 'consulta_nome', 'consulta_telefone', 'consulta_email'];

    
    $('#telefone').mask('(00) 00000-00000');

    function validarCampo(id) {
        const campo = document.getElementById(id);
        const valor = campo.value.trim();
        let errorElement = document.getElementById('error-' + id);

        if (!errorElement) {
            errorElement = document.createElement('small');
            errorElement.id = 'error-' + id;
            errorElement.style.color = 'red';
            campo.after(errorElement);
        }
        errorElement.textContent = '';

        if (!valor) {
            errorElement.textContent = 'Campo obrigatório';
            return false;
        }

        switch(id) {
            case 'consulta_cpf':
                const cpfNumeros = valor.replace(/\D/g, '');
                if (!/^\d{11}$/.test(cpfNumeros)) {
                    errorElement.textContent = 'CPF inválido (11 dígitos)';
                    return false;
                }
                break;

            case 'consulta_telefone':
                const telefoneNumeros = valor.replace(/\D/g, '');
                if (telefoneNumeros.length < 11) {
                    errorElement.textContent = 'Telefone inválido (mínimo 11 dígitos)';
                    return false;
                }
                if (telefoneNumeros.length > 11) {
                    errorElement.textContent = 'Telefone inválido (máximo 11 dígitos)';
                    return false;
                }
                break;

            case 'consulta_email':
                const regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!regexEmail.test(valor)) {
                    errorElement.textContent = 'Email inválido';
                    return false;
                }
                break;

            case 'consulta_nome':
                if (valor.length < 3) {
                    errorElement.textContent = 'Nome muito curto';
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

    
    const form = document.getElementById('loginForm2');
    form.addEventListener('submit', function(e) {
        let valido = true;
        campos.forEach(function(id) {
            if (!validarCampo(id)) valido = false;
        });

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
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const campos = [
        'cpf', 'nome', 'telefone', 'email', 'senha', 'consenha'
    ];

    
    $('#telefone').mask('(00) 00000-0000');

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

        
        switch (id) {
            case 'cpf':
                const cpfLimpo = valor.replace(/\D/g, '');
                if (!/^\d{11}$/.test(cpfLimpo)) {
                    errorElement.textContent = 'CPF inválido (deve conter 11 dígitos numéricos)';
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

            case 'email':
                if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(valor)) {
                    errorElement.textContent = 'Email inválido';
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
        if (!input) return;

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

    
    <?php if (isset($abrirModal) && $abrirModal): ?>
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

<!-- JS EXTERNOS -->
<script src="js/ConsultaFuncionario.js"></script>
<script src="js/sidebar.js"></script>
<script src="js/funcionarios.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

</body>
</html>
