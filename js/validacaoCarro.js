document.addEventListener("DOMContentLoaded", () => {
  const form = document.querySelector("form");

  const campos = [
    "ano", "placa", "status", "fabricante", "modelo", "carroceria",
    "cor", "cambio", "combustivel", "km", "valor", "custos_extra",
    "data_compra", "valor_venda"
  ];

  $('#data_compra').mask('00/00/0000');

  // Função para formatar valor monetário (R$)
  function formatarValor(campo) {
    let valor = campo.value.replace(/\D/g, "");
    if (valor === "") return;
    valor = (valor / 100).toFixed(2) + "";
    valor = valor.replace(".", ",");
    valor = valor.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    campo.value = "R$ " + valor;
  }

  // Função para formatar quilometragem
  function formatarKm(campo) {
    let valor = campo.value.replace(/\D/g, "");
    if (valor === "") return;
    valor = valor.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    campo.value = valor;
  }

  // Aplica as máscaras em tempo real
  ["valor", "valor_venda", "custos_extra"].forEach(id => {
    const campo = document.getElementById(id);
    campo.addEventListener("input", () => formatarValor(campo));
  });

  const kmCampo = document.getElementById("km");
  kmCampo.addEventListener("input", () => formatarKm(kmCampo));

  // Validação dos campos
  campos.forEach(id => {
    const campo = document.getElementById(id);
    const span = document.createElement("small");
    span.style.color = "red";
    span.className = "error-message";
    campo.parentNode.appendChild(span);

    if (campo.tagName === "SELECT" || campo.type === "file") {
      campo.addEventListener("change", () => validarCampo(id));
    } else {
      campo.addEventListener("input", () => validarCampo(id));
    }
  });

  function validarCampo(id) {
    const campo = document.getElementById(id);
    const valor = campo.value.trim();
    const errorSpan = document.querySelector(`#${id} + .error-message`);
    errorSpan.textContent = "";

    switch (id) {
      case "ano":
        if (!valor || valor < 1900 || valor > 2099) {
          errorSpan.textContent = "Informe um ano válido entre 1900 e 2099.";
          return false;
        }
        break;

      case "placa":
        const placa = valor.toUpperCase().trim();
        const regexPlaca = /^[A-Z]{3}-?\d[A-Z0-9]\d{2}$/;
        if (!regexPlaca.test(placa)) {
          errorSpan.textContent =
            "Informe uma placa válida (ABC-1234 ou ABC1D23).";
          return false;
        }
        const formatoAntigo = /^[A-Z]{3}\d{4}$/;
        if (formatoAntigo.test(placa)) {
          campo.value = placa.replace(/^([A-Z]{3})(\d{4})$/, "$1-$2");
        } else {
          campo.value = placa;
        }
        break;

      case "status":
      case "fabricante":
      case "modelo":
      case "carroceria":
      case "cor":
      case "cambio":
      case "combustivel":
        if (!valor) {
          errorSpan.textContent = "Campo obrigatório.";
          return false;
        }
        break;

      case "km":
        if (!valor) {
          errorSpan.textContent = "Informe a quilometragem.";
          return false;
        }
        break;

      case "valor":
      case "valor_venda":
      case "custos_extra":
        if (!valor) {
          errorSpan.textContent = "Campo obrigatório.";
          return false;
        }
        break;

      case "data_compra":
        if (valor.length < 10) {
          errorSpan.textContent = "Informe uma data válida.";
          return false;
        }
        break;

     
    }

    return true;
  }

  form.addEventListener("submit", function (e) {
    let valido = true;
    campos.forEach(id => {
      if (!validarCampo(id)) valido = false;
    });

    if (!valido) {
      e.preventDefault();
      alert("Por favor, corrija os erros destacados nos campos.");
    }
  });
});
