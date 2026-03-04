<?php
session_start();
if (isset($_SESSION['id_empresa'])) {
  $nome = $_SESSION['nome_fantasia'];
} else if (isset($_SESSION['cod_empresa'])) {
  $nome = $_SESSION['nome_funcionario'];
} else {
  $nome = '';
}

$modelo = htmlspecialchars($_GET['modelo'] ?? '');
$placa = htmlspecialchars($_GET['placa'] ?? '');
$fabricante = htmlspecialchars($_GET['fabricante'] ?? '');
$ano = htmlspecialchars($_GET['ano'] ?? '');
$custos = htmlspecialchars($_GET['custos_extra'] ?? '');
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

  <!-- jQuery e Plugins -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.12.1/html2pdf.bundle.min.js"></script>

  <script src="js/buscaCep.js"></script>

  <!-- CSS personalizado -->
  <link rel="stylesheet" href="css/venda.css">
</head>
<body>
  <form id="form" method="post" action="PHP/concluir_venda.php">
    <div id="content">
      <h2>Registro de Venda de Veículo</h2>

      <label for="dataVenda">Data da Venda:</label>
      <input type="text" id="dataVenda" name="dataVenda" placeholder="dd/mm/aaaa" required>
      <small class="error-message" id="error-dataVenda"></small>

      <label for="vendedor">Nome do Vendedor:</label>
      <input type="text" id="vendedor" name="vendedor" value="<?php echo $nome ?>" placeholder="Nome completo do vendedor" required>
      <small class="error-message" id="error-vendedor"></small>

      <label for="comprador">Nome do Comprador:</label>
      <input type="text" id="comprador" name="comprador" placeholder="Nome completo do comprador" required>
      <small class="error-message" id="error-comprador"></small>

      <label for="cpf_comprador">CPF do Comprador:</label>
      <input type="text" id="cpf_comprador" name="cpf_comprador" placeholder="CPF do comprador" required>
      <small class="error-message" id="error-cpf_comprador"></small>

      <label for="telefone_comprador">Telefone Cliente:</label>
      <input type="tel" placeholder="(DDD) 00000-0000" id="telefone_comprador" name="telefone_comprador" maxlength="15" autocomplete="off">
      <small class="error-message" id="error-telefone_comprador"></small>

      <label for="cep">CEP Cliente:</label>
      <input type="text" placeholder="00000-000" id="cep" name="cep" maxlength="9" autocomplete="off">
      <small class="error-message" id="error-cep"></small>

      <label for="cidade">Cidade Cliente:</label>
      <input type="text" placeholder="Informe sua cidade" id="cidade" name="cidade" autocomplete="off">
      <small class="error-message" id="error-cidade"></small>

      <label for="endereco">Endereço Cliente:</label>
      <input type="text" placeholder="Seu endereço" id="endereco" name="endereco" autocomplete="off">
      <small class="error-message" id="error-endereco"></small>

      <label for="numero">N° Cliente:</label>
      <input type="text" placeholder="Informe seu N°" id="numero" name="numero" autocomplete="off" maxlength="7">
      <small class="error-message" id="error-numero"></small>

      <label for="bairro">Bairro Cliente:</label>
      <input type="text" placeholder="Seu bairro" id="bairro" name="bairro" autocomplete="off">
      <small class="error-message" id="error-bairro"></small>

      <label for="estado">Estado Cliente:</label>
      <input type="text" placeholder="Seu Estado" id="estado" name="estado" autocomplete="off">
      <small class="error-message" id="error-estado"></small>

      <label for="email_cli">Email Cliente:</label>
      <input type="email" placeholder="Informe seu melhor email" id="email_cli" name="email_cli" autocomplete="off">
      <small class="error-message" id="error-email_cli"></small>

      <label for="fabricante">Fabricante do Veículo:</label>
      <input type="text" id="fabricante" name="fabricante" value="<?php echo $fabricante ?>" required readonly>

      <label for="modelo">Modelo do Veículo:</label>
      <input type="text" id="modelo" name="modelo" value="<?php echo $modelo ?>" required readonly>

      <label for="ano">Ano:</label>
      <input type="text" id="ano" name="ano" value="<?php echo $ano ?>" required readonly>

      <label for="placa">Placa:</label>
      <input type="text" id="placa" name="placa" value="<?php echo $placa ?>" required readonly>

      <label for="valor">Valor da Venda (R$):</label>
      <input type="text" id="valor" name="valor" placeholder="Ex: 85000,00" required>
      <small class="error-message" id="error-valor"></small>

      <label for="valorEntrada">Valor da Entrada (R$):</label>
      <input type="text" id="valorEntrada" name="valorEntrada" placeholder="Ex: 15000,00" required>
      <small class="error-message" id="error-valorEntrada"></small>

      <input type="hidden" id="custos_extras" name="custos_extras" value="<?php echo $custos ?>">

      <label for="observacoes">Observações:</label>
      <textarea id="observacoes" name="observacoes" rows="3" placeholder="Informações adicionais..."></textarea>
      <small class="error-message" id="error-observacoes"></small>
    </div>

    <div class="btn">
      <input type="submit" id="btnVenda" value="Registrar Venda">
      <input type="button" id="btnGerarContrato" value="Gerar Contrato" disabled>
    </div>

    <p id="msg-sucesso" style="display:none;">✅ Todos os campos foram validados com sucesso!</p>
  </form>

  <script>
  $(document).ready(function() {
    // Máscaras
    $('#dataVenda').mask('00/00/0000');
    $('#cpf_comprador').mask('000.000.000-00');
    $('#telefone_comprador').mask('(00) 00000-0000');
    $('#cep').mask('00000-000');

    const campos = [
      "dataVenda", "vendedor", "comprador", "cpf_comprador", "telefone_comprador",
      "cep", "cidade", "endereco", "numero", "bairro", "estado",
      "email_cli", "valor", "valorEntrada", "observacoes"
    ];

    function validarCampo(id) {
      const campo = document.getElementById(id);
      const valor = campo.value.trim();
      const errorSpan = document.getElementById("error-" + id);
      let valido = true;
      errorSpan.textContent = "";

      switch (id) {
        case "dataVenda":
          if (!/^\d{2}\/\d{2}\/\d{4}$/.test(valor)) {
            errorSpan.textContent = "Data inválida (use dd/mm/aaaa).";
            valido = false;
          }
          break;
        case "cpf_comprador":
          if (valor.length < 14) {
            errorSpan.textContent = "CPF inválido.";
            valido = false;
          }
          break;
        case "telefone_comprador":
          if (valor.length < 14) {
            errorSpan.textContent = "Telefone incompleto.";
            valido = false;
          }
          break;
        case "cep":
          if (valor.length < 9) {
            errorSpan.textContent = "CEP inválido.";
            valido = false;
          }
          break;
        case "email_cli":
          if (valor && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(valor)) {
            errorSpan.textContent = "E-mail inválido.";
            valido = false;
          }
          break;
        case "valor":
        case "valorEntrada":
          const num = parseFloat(valor.replace(',', '.'));
          if (isNaN(num) || num < 0) {
            errorSpan.textContent = "Informe um valor numérico válido.";
            valido = false;
          }
          break;
        default:
          if (!valor) {
            errorSpan.textContent = "Campo obrigatório.";
            valido = false;
          }
      }

      campo.classList.toggle("invalid", !valido);
      campo.classList.toggle("valid", valido);
      return valido;
    }

    function verificarTodosCampos() {
      let todosValidos = campos.every(id => validarCampo(id));
      const msgSucesso = document.getElementById("msg-sucesso");
      const gerarContratoBtn = document.getElementById("btnGerarContrato");

      if (todosValidos) {
        msgSucesso.style.display = "block";
        gerarContratoBtn.removeAttribute("disabled");
      } else {
        msgSucesso.style.display = "none";
        gerarContratoBtn.setAttribute("disabled", "true");
      }
    }

    campos.forEach(id => {
      const campo = document.getElementById(id);
      campo.addEventListener("input", () => {
        validarCampo(id);
        verificarTodosCampos();
      });
      campo.addEventListener("blur", () => {
        validarCampo(id);
        verificarTodosCampos();
      });
    });

    $("#form").on("submit", function(e) {
      let valido = true;
      campos.forEach(id => { if (!validarCampo(id)) valido = false; });
      if (!valido) {
        e.preventDefault();
        alert("⚠️ Corrija os campos com erro antes de enviar.");
      }
    });

    // 🔹 adiciona evento ao botão
    document.getElementById("btnGerarContrato").addEventListener("click", gerarContrato);
  });

  // 🔹 função global corrigida
  function gerarContrato() {
    const contratoHTML = `
      <div style="font-family: Arial; padding: 40px; line-height: 1.6;">
        <h2 style="text-align:center; color:#1F4F9C;">Contrato de Compra e Venda de Veículo</h2>
        <hr>
        <p><strong>Data da Venda:</strong> ${dataVenda.value}</p>
        <p><strong>Vendedor:</strong> ${vendedor.value}</p>
        <p><strong>Comprador:</strong> ${comprador.value}</p>
        <p><strong>CPF:</strong> ${cpf_comprador.value}</p>
        <p><strong>Telefone:</strong> ${telefone_comprador.value}</p>
        <p><strong>Endereço:</strong> ${endereco.value}, ${numero.value}, ${bairro.value} - ${cidade.value}/${estado.value}</p>
        <p><strong>CEP:</strong> ${cep.value}</p>
        <p><strong>E-mail:</strong> ${email_cli.value}</p>
        <hr>
        <p><strong>Veículo:</strong> ${fabricante.value} ${modelo.value} - ${ano.value}</p>
        <p><strong>Placa:</strong> ${placa.value}</p>
        <p><strong>Valor Total:</strong> R$ ${valor.value}</p>
        <p><strong>Entrada:</strong> R$ ${valorEntrada.value}</p>
        <p><strong>Custos Extras:</strong> R$ ${custos_extras.value || "0,00"}</p>
        <p><strong>Observações:</strong> ${observacoes.value}</p>
        <br><br>
        <p style="text-align:center;">_____________________________________<br>Assinatura do Vendedor</p>
        <br><br>
        <p style="text-align:center;">_____________________________________<br>Assinatura do Comprador</p>
      </div>
    `;

    const tempDiv = document.createElement("div");
    tempDiv.innerHTML = contratoHTML;
    document.body.appendChild(tempDiv);

    const options = {
      margin: 10,
      filename: `contrato_${placa.value}.pdf`,
      html2canvas: { scale: 2 },
      jsPDF: { unit: "mm", format: "a4", orientation: "portrait" }
    };

    html2pdf().set(options).from(tempDiv).save().then(() => document.body.removeChild(tempDiv));
  }
  </script>
</body>
</html>
