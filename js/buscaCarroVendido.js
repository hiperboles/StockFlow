$(document).ready(function () {
  const inputBusca = $('#buscaPlaca');
  const btnBusca = $('#btnBuscar');
  const container = $('#localVeiculos');

  // Função para buscar e renderizar veículos vendidos
  function listarVeiculosVendidos() {
    $.ajax({
      url: "PHP/listarCarros_vendidos.php",
      method: "GET",
      dataType: "json",
      success: function (data) {
        let conteudo = "";

        data.forEach(function (carro) {
          let imgHTML = "";
          if (carro.imagens && carro.imagens.length > 0) {
            imgHTML = `<img src="PHP/${carro.imagens[0]}" class="img-fluid mb-2 rounded" alt="${carro.modelo}">`;
          }

          var custos = Number(carro.custos_extra) + Number(carro.custos);

          let lucro_atual =
            Number(carro.valor) -
            (Number(carro.custos) + Number(carro.valor_compra) + Number(carro.custos_extra));

          conteudo += `
            <div class="col-md-4 mb-4 veiculo-total">
              <div class="card shadow-sm border-0 h-100 veiculo-card">
                <div class="card-img-top p-2">
                  ${imgHTML}
                </div>
                <div class="card-body">
                  <h5 class="card-title">${carro.fabricante} ${carro.modelo}</h5>
                  <p class="card-text text-muted small">
                    <strong>Placa:</strong> <span class="placa">${carro.placa}</span><br>
                    <strong>Cor:</strong> ${carro.cor}<br>
                    <strong>Ano:</strong> ${carro.ano}<br>
                    <strong>Combustível:</strong> ${carro.combustivel}<br>
                    <strong>Quilometragem:</strong> ${carro.quilometragem} KM<br>
                    <strong>Data Compra:</strong> <span class="text-success fw-bold">${carro.data_compra}</span><br>
                    <strong>Data Venda:</strong> <span class="text-success fw-bold">${carro.data_venda}</span><br>
                    <strong>Valor Vendido:</strong> <span class="text-success fw-bold">R$ ${Number(carro.valor).toFixed(2)}</span><br>
                    <strong>Lucro Atual:</strong> <span class="text-success fw-bold">R$ ${lucro_atual.toFixed(2)}</span><br>
                    <strong>Custos Atuais:</strong> <span class="text-danger fw-bold">${custos}</span><br>
                  </p>
                </div>
                <div class="card-footer d-flex justify-content-between align-items-center bg-white border-0">
                  <button class="btn btn-sm btn-outline-danger botoes" onclick="exclusaoVeiculo(this, ${carro.id_veiculo})">
                    <i class="fa-solid fa-trash"></i>
                  </button>
                  <button class="btn btn-sm view-veiculo botoes" onclick="visualizar(this, ${carro.id_veiculo})">
                    <i class="fa-solid fa-eye"></i>
                  </button>
                  <button class="btn btn-sm editar-veiculo botoes" onclick="editar(this, ${carro.id_veiculo})">
                    <i class="fa-solid fa-dollar-sign icone"></i>
                  </button>
                </div>
              </div>
            </div>`;
        });

        container.html(conteudo);
      },
      error: function (xhr, status, error) {
        console.error("Erro ao buscar veículos vendidos:", status, error);
        container.html(`<div class="col-12 text-danger">Erro ao carregar veículos vendidos.</div>`);
      },
    });
  }

  // Chama a função para listar os veículos ao carregar
  listarVeiculosVendidos();

  // Função para filtrar veículos pela placa
  function filtrarVeiculos() {
    const placa = inputBusca.val().toLowerCase();

    container.children().each(function () {
      const textoPlaca = $(this).find('.placa').text().toLowerCase();
      if (textoPlaca.includes(placa)) {
        $(this).fadeIn(200);
      } else {
        $(this).fadeOut(200);
      }
    });
  }

  // Filtrar enquanto digita
  inputBusca.on('input', filtrarVeiculos);

  // Filtrar ao clicar no botão
  btnBusca.on('click', filtrarVeiculos);
});


////////////////////////////////
//exclusao de veiculo (função)//
////////////////////////////////

function exclusaoVeiculo(btn, idVeiculo) {
  if (!confirm("Deseja realmente excluir este veículo?")) return;

  $.ajax({
    url: "PHP/excluirVeiculo.php",
    method: "POST",
    data: { id_veiculo: idVeiculo },
    success: function (res) {
      alert("Veículo excluído com sucesso!");
      $(btn).closest('.col-md-4').remove();
    },
    error: function (xhr, status, error) {
      console.error("Erro ao excluir veículo:", status, error);
      alert("Não foi possível excluir o veículo.");
    }
  });
}

////////////////////////////////
//visualizar carro(função)//////
////////////////////////////////

function visualizar(btn, idVeiculo){
  $.ajax({
    url: "PHP/listarCarros_vendidos.php",
    method: "GET",
    dataType: "json",
    success: function (data) {
      const carro = data.find(c => c.id_veiculo == idVeiculo);
      if (!carro) return;

      let imagensHTML = "";
      let imagemHTML = "";
      let despes = "";
      if (carro.imagens && carro.imagens.length > 0) {
        carro.imagens.forEach(img => {
          imagensHTML += `<img src="PHP/${img}" class="imagem-carros">`;
        });
      }

      if (carro.imagens && carro.imagens.length > 0) {
            imagemHTML += `<img src="PHP/${carro.imagens[0]}" class="img-fluid mb-2 rounded img-principal" alt="${carro.modelo}">`;
        }

         var lucro_atual = Number(carro.valor) -(Number(carro.custos) + Number(carro.valor_compra) + Number(carro.custos_extra));


         lucro_atual = parseFloat(lucro_atual.toFixed(2));

         var despesas_atual = Number(carro.custos_extra) + Number(carro.custos);

         despesas_atual = parseFloat(despesas_atual.toFixed(2));




      if (carro.custoLISTA && carro.custoLISTA.length > 0) {
        carro.custoLISTA.forEach(CUSTO => {
         despes += `
  <div class="listados shadow-sm p-3 mb-3 bg-white rounded" id="despesa-${CUSTO.id_custo}">
    <div class="info-despesa" id="info-${CUSTO.id_custo}">
      <h6 class="mb-1 text-primary font-weight-bold">${CUSTO.descricaoCusto}</h6>
      <p class="mb-0 text-secondary small">
        <span class="mr-2"><strong>Valor:</strong> R$ ${CUSTO.custoGarantido}</span>
        <span class="mr-2"><strong>Qtd:</strong> ${CUSTO.Qt}x</span>
        <span><strong>Data:</strong> ${CUSTO.dataCusto}</span>
      </p>
    </div>

    <div class="editar-despesa d-none" id="editar-${CUSTO.id_custo}">
      <input type="text" class="form-control mb-2" id="descricaoATT" value="${CUSTO.descricaoCusto}">
      <input type="number" step="0.01" class="form-control mb-2" id="custoATT" value="${CUSTO.custoGarantido}">
      <input type="number" class="form-control mb-2" id="qtATT" value="${CUSTO.Qt}">
      <div class="acoes-inline">
        <button class="btn btn-success btn-sm mr-2" onclick="salvarDespesas(${CUSTO.id_custo} , ${carro.id_veiculo})">
          <i class="fas fa-check"></i> Salvar
        </button>
        <button class="btn btn-secondary btn-sm" onclick="cancelarEdicaoInline(${CUSTO.id_custo})">
          <i class="fas fa-times"></i> Cancelar
        </button>
      </div>
    </div>

    <div class="acoes-despesa mt-2">
      <button class="btn btn-outline-primary btn-sm mr-2" onclick="editarInline(${CUSTO.id_custo})">
        <i class="fas fa-edit"></i> Editar
      </button>
      <button class="btn btn-outline-danger btn-sm" onclick="excluirDespesa(${CUSTO.id_custo}, ${carro.id_veiculo})">
        <i class="fas fa-trash-alt"></i> Excluir
      </button>
    </div>
  </div>
`;
        });
      }


      let conteudo = `
        ${imagemHTML}

  <div class="conteudo-carros">
  <div class="container-row">
    <div class="container-info">
      <div class="titulo-carro">
        <h4 class="h2-veiculo">Informações</h4>
      </div>

      <div class="info-carro">
        <div class="coluna-info">
          <label class="label-carro">Placa</label>
          <p class="p-carro">${carro.placa}</p>

          <label class="label-carro">Cor</label>
          <p class="p-carro">${carro.cor}</p>

          <label class="label-carro">Fabricante</label>
          <p class="p-carro">${carro.fabricante}</p>

          <label class="label-carro">Carroceria</label>
          <p class="p-carro">${carro.carroceria}</p>

          <label class="label-carro">Quilometragem</label>
          <p class="p-carro">${carro.quilometragem}</p>

          <label class="label-carro">Status</label>
          <p class="p-carro">${carro.statusveiculo}</p>
        </div>

        <div class="coluna-info">
          <label class="label-carro">Modelo</label>
          <p class="p-carro">${carro.modelo}</p>

          <label class="label-carro">Combustivel</label>
          <p class="p-carro">${carro.combustivel}</p>

          <label class="label-carro">Tipo</label>
          <p class="p-carro">${carro.tipo}</p>

          <label class="label-carro">Ano</label>
          <p class="p-carro">${carro.ano}</p>

          <label class="label-carro">Valor da Venda</label>
          <p class="p-carro" id="valor-carro">R$ ${carro.valor}</p>

          <label class="label-carro">Lucro Atual</label>
          <p class="p-carro" id="lucro-atual">R$ ${lucro_atual}</p>

        </div>
        <div class="coluna-info">
        <label class="label-carro">Despesas</label>
          <p class="p-carro text-danger">R$ ${despesas_atual}</p>
          <label class="label-carro">Data de Compra</label>
          <p class="p-carro">${carro.data_compra}</p>
          <label class="label-carro">Data de Venda</label>
          <p class="p-carro">${carro.data_venda}</p>
          <label class="label-carro">Fim da Garantia</label>
          <p class="p-carro">${carro.data_final}</p>
        </div>
      </div>
      </div>
      <div class="lista-despesas"> 
        <h4 class="h2-despesas">Despesas</h4>

        <div class="porta-despesas" id="porta-despesas">

        </div>
      </div>
    </div>
    `;

      $("#control").html(conteudo);
      $("#porta-despesas").html(despes);

      if (Number(lucro_atual) > 0) {
        $("#lucro-atual").addClass("ok").removeClass("maldito");
      } else {
        $("#lucro-atual").addClass("maldito").removeClass("ok");
      }

      if(carro.custos_extra > 0){
      $(".val-extra").removeClass("ok").addClass("valorExtra-carro");
      }else{
      $(".val-extra").removeClass("valorExtra-carro").addClass("ok");
      }
    },
    error: function(xhr, status, error){
      console.error(error);
    }
  });
}

////////////////////////////////
//////editar carro(função)//////
////////////////////////////////

function editar(btn, idVeiculo){
  $.ajax({
    url: "PHP/listarCarros_vendidos.php",
    method: "GET",
    dataType: "json",
    success: function (data) {
      const carro = data.find(c => c.id_veiculo == idVeiculo);
      if (!carro) return;

      let imagensHTML = "";
      let imgHTML = "";
      if (carro.imagens && carro.imagens.length > 0) {
        carro.imagens.forEach(img => {
          imagensHTML += `<img src="PHP/${img}" class="img-fluid mb-2 rounded imagem-carros">`;
        });
      }

      if (carro.imagens && carro.imagens.length > 0) {
        imgHTML = `<img src="PHP/${carro.imagens[0]}" class="img-fluid mb-2 rounded" alt="${carro.modelo}">`;
      }

      const valorCustoFormatado = (Number(carro.custos_extra) + Number(carro.custos)).toLocaleString('pt-BR', {
        style: 'currency',
        currency: 'BRL'
      });

      let conteudo = `
        ${imgHTML}
        <div class="conteudo-carros">
          <div class="container-carro-edit mt-5 mb-5">
            <div class="card shadow p-4 form-update-card">
              <h2 class="mb-4 text-center h2-title font-weight-bold edit-h2">
                Adicionar Custo ao Veículo
              </h2>

              <form method="POST" action="PHP/addcusto_veiculo.php" autocomplete="off">
                <input type="hidden" id="id" name="id" value="${carro.id_veiculo}">
                <input type="hidden" id="valor_custo_input" name="valor_custo">
                <input type="hidden" id="valor_custo_final_hidden" name="valor_custo_final">

                <div class="form-row">
                  <div class="col-md-4 mb-3">
                    <label class="form-label">
                      <i class="fa-solid fa-tag"></i> Descrição do Custo
                    </label>
                    <input type="text" id="descricao_custo" name="descricao_custo" class="form-control" placeholder="Ex: Bateria" required/>
                  </div>

                  <div class="col-md-4 mb-3">
                    <label class="form-label">
                      <i class="fa-solid fa-calendar-days"></i> Data Custo
                    </label>
                    <input type="text" id="data_custo" name="data_custo" class="form-control" placeholder="dd/mm/aaaa" required/>
                  </div>

                  <div class="col-md-4 mb-3">
                    <label class="form-label">
                      <i class="fa-solid fa-hashtag"></i> Quantidade
                    </label>
                    <input type="number" id="quantidade" name="quantidade" class="form-control" placeholder="Ex: 1" min="1" required/>
                  </div>

                  <div class="col-md-4 mb-3">
                    <label class="form-label">
                      <i class="fa-solid fa-money-bill"></i> Valor Unitário (R$)
                    </label>
                    <input type="number" step="0.01" id="valor" name="valor" class="form-control" placeholder="Ex: 100.00" required/>
                  </div>

                  <div class="col-md-12 mb-3">
                    <label class="form-label text-primary">
                      <i class="fa-solid fa-calculator"></i> Valor Total do Custo:
                      <strong id="valor_custo">R$ 0,00</strong>
                    </label>
                  </div>

                  <div class="col-md-12 mb-3">
                    <label class="form-label text-success">
                      <i class="fa-solid fa-wallet"></i> Valor Total de Custos Atual:
                      <strong>${valorCustoFormatado}</strong>
                    </label>
                  </div>

                  <div class="col-md-12 mb-3">
                    <label class="form-label text-danger">
                      <i class="fa-solid fa-wallet"></i> Valor Total de Custos Final:
                      <strong id="valor_custo_final_display">R$ 0,00</strong>
                    </label>
                  </div>

                </div>

                <button type="submit" class="btn btn-primary btn-lg btn-block mt-3 botao-edit">
                  <i class="fa-solid fa-save"></i> Atualizar Veículo
                </button>
              </form>
            </div>
          </div>
        </div>
      `;

      $("#control-edit").html(conteudo);

     
      const custoInicial = Number(carro.custos) + Number(carro.custos_extra);
      $("#valor_custo_final_display").text(
        custoInicial.toLocaleString("pt-BR", { style: "currency", currency: "BRL" })
      );
      $("#valor_custo_final_hidden").val(custoInicial.toFixed(2));

      
      $("#quantidade, #valor").on("input", function() {
        const qtd = parseFloat($("#quantidade").val()) || 0;
        const valor = parseFloat($("#valor").val()) || 0;
        const total = qtd * valor;
        const custoTotal = total + custoInicial;

        $("#valor_custo").text(total.toLocaleString("pt-BR", { style: "currency", currency: "BRL" }));
        $("#valor_custo_final_display").text(custoTotal.toLocaleString("pt-BR", { style: "currency", currency: "BRL" }));

        $("#valor_custo_input").val(total.toFixed(2));
        $("#valor_custo_final_hidden").val(custoTotal.toFixed(2));
      });

      
      $("form").on("submit", function() {
        const inputData = $("#data_custo").val();
        if (inputData.includes("/")) {
          const partes = inputData.split("/");
          const dataFormatada = `${partes[2]}-${partes[1]}-${partes[0]}`;
          $("#data_custo").val(dataFormatada);
        }
      });
    },
    error: function(xhr, status, error){
      console.error("Erro ao buscar dados:", error);
    }
  });
}






////////////////////////////////
//abrir tela de visualização////
////////////////////////////////

$(document).on("click", ".view-veiculo", function () {
  $(".container-view").toggleClass("viewed");
  $("body").toggleClass("viewing");
});

$(document).on("keydown", function (e) {
  if (e.key === "Escape") {
    $(".container-view").removeClass("viewed");
    $("body").removeClass("viewing");
  }
});

//////////////////////////////////////
//abrir tela de adicionar custo ao  veiculo////
/////////////////////////////////////

$(document).on("click", ".editar-veiculo", function (){
  $(".container-view-edit").toggleClass("viewed-edit");
  $("body").toggleClass("viewing");
});

$(document).on("keydown", function (e) {
  if (e.key === "Escape") {
    $(".container-view-edit").removeClass("viewed-edit");
    $("body").removeClass("viewing");
  }
});
function editarInline(id) {
  document.getElementById(`info-${id}`).classList.add("d-none");
  document.getElementById(`editar-${id}`).classList.remove("d-none");
}


function cancelarEdicaoInline(id) {
  document.getElementById(`info-${id}`).classList.remove("d-none");
  document.getElementById(`editar-${id}`).classList.add("d-none");
}


function salvarDespesas(idCusto,idVeiculo) {
  const descricao = $("#descricaoATT").val();
  const valor = $("#custoATT").val();
  const qt = $("#qtATT").val();

  

  if (!descricao || !valor || !qt) {
    alert("Preencha todos os campos antes de salvar.");
    return;
  }

  $.ajax({
    url: "PHP/editarDespesa.php",
    method: "POST",
    data: {
      id_veiculo: idVeiculo,
      id_custo: idCusto,
      descricaoATT: descricao, 
      custoATT: valor,        
      qtATT: qt               
    },
    success: function (res) {
      console.log("Resposta do PHP:", res);
      location.reload();
    },
    error: function (xhr, status, error) {
      console.error("Erro ao salvar despesa:", status, error);
    }
  });
}




// Excluir despesa
function excluirDespesa(idCusto,idVeiculo) {
  if (!confirm("Tem certeza que deseja excluir esta despesa?")) return;
  const valor = $("#custoATT").val();

  $.ajax({
    url: "PHP/excluirDespesa.php",
    method: "POST",
    data: { id_custo: idCusto,
      id_veiculo: idVeiculo,
      custoATT: valor
     },
    success: function (res) {
      alert(res);
      location.reload();
    },
    error: function (xhr, status, error) {
      console.error(error);
      alert("Erro ao excluir despesa!");
    }
  });
}