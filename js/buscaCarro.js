$(document).ready(function () {
  const inputBusca = $('#buscaPlaca');
  const btnBusca = $('#btnBuscar');
  const container = $('#localVeiculos');

  // Função para buscar e renderizar veículos
  function listarVeiculos() {
    $.ajax({
      url: "PHP/listarcarroEmpresa.php",
      method: "GET",
      dataType: "json",
      success: function (data) {
        let conteudo = "";

        data.forEach(function (carro) {
          let imagensHTML = "";
          if (carro.imagens && carro.imagens.length > 0) {
              imagensHTML += `<img src="PHP/${carro.imagens[0]}" class="img-fluid mb-2 rounded" alt="${carro.modelo}">`;
          }

          let custo_atual = Number(carro.valor_compra) + Number(carro.custos_extra);

          conteudo += `
            <div class="col-md-4 mb-4 veiculo-total">
              <div class="card shadow-sm border-0 h-100 veiculo-card">
                <div class="card-img-top p-2">
                  ${imagensHTML}
                </div>
                <div class="card-body">
                  <h5 class="card-title">${carro.fabricante} ${carro.modelo}</h5>
                  <p class="card-text text-muted small">
                    <strong>Placa:</strong> <span class="placa">${carro.placa}</span><br>
                    <strong>Cor:</strong> ${carro.cor}<br>
                    <strong>Ano:</strong> ${carro.ano}<br>
                    <strong>Combustivel:</strong> ${carro.combustivel}<br>
                    <strong>Quilometragem:</strong> ${carro.quilometragem}<strong>KM</strong><br>
                    <strong>Valor de Venda:</strong> <span class="text-success fw-bold">R$ ${carro.valor}</span><br>
                    <strong>Custo Atual:</strong> <span class="fw-bold">R$ ${custo_atual}</span><br>
                    <strong>Data Compra:</strong> <span class="text-success fw-bold">${carro.data_compra}</span>
                  </p>
                </div>
                <div class="card-footer d-flex justify-content-between align-items-center bg-white border-0">
                  <span class="badge bg-${carro.statusveiculo === 'Disponível' ? 'success' : 'secondary'} span-status">
                    ${carro.statusveiculo}
                  </span>

                  <button class="btn btn-sm btn-outline-danger botoes" onclick="exclusaoVeiculo(this, ${carro.id_veiculo})">
                    <i class="fa-solid fa-trash"></i>
                  </button>
                  <button class="btn btn-sm view-veiculo botoes" onclick="visualizar(this, ${carro.id_veiculo})">
                    <i class="fa-solid fa-eye"></i>
                  </button>
                  <button class="btn btn-sm editar-veiculo botoes" onclick="editar(this, ${carro.id_veiculo})">
                    <i class="fa-solid fa-pen"></i>
                  </button>
                   <button class="btn btn-sm adicionar-veiculo botoes" onclick="adicionarCustos(this, ${carro.id_veiculo})">
                    <i class="fa-solid fa-dollar-sign"></i>
                  </button>
                </div>
              </div>
            </div>
          `;
        });

        container.html(conteudo);
      },
      error: function (xhr, status, error) {
        console.error("Erro ao buscar carros:", status, error);
        container.html(`<div class="col-12 text-danger">Erro ao carregar veículos.</div>`);
      }
    });
  }

  // Chama a função para listar veículos ao carregar a página
  listarVeiculos();

  // Função para filtrar veículos pela placa
  function filtrarVeiculos() {
    const placa = inputBusca.val().toLowerCase();

    container.children().each(function() {
      const textoPlaca = $(this).find('.placa').text().toLowerCase();
      if(textoPlaca.includes(placa)) {
        $(this).show();
      } else {
        $(this).hide();
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
    url: "PHP/listarcarroEmpresa.php",
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
          imagensHTML += `<img src="PHP/${img}" class="imagem-carros slide">`;
        });
      }

      if (carro.imagens && carro.imagens.length > 0) {
            imagemHTML += `<img src="PHP/${carro.imagens[0]}" class="img-fluid mb-2 rounded img-principal" alt="${carro.modelo}">`;
        }

         var lucro_atual = Number(carro.valor) -(Number(carro.custos) + Number(carro.valor_compra) + Number(carro.custos_extra));


         lucro_atual = parseFloat(lucro_atual.toFixed(2));

         




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
      <button class="btn btn-outline-danger btn-sm" onclick="excluirDespesa(${CUSTO.id_custo} , ${carro.id_veiculo})">
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

          <label class="label-carro">Valor de Compra</label>
          <p class="p-carro" >R$ ${carro.valor_compra}</p>

          <label class="label-carro">Valor de Venda</label>
          <p class="p-carro" id="valor-carro">R$ ${carro.valor}</p>


        </div>
        <div class="coluna-info">
        <label class="label-carro">Despesas</label>
          <p class="p-carro text-danger">R$ ${carro.custos_extra}</p>
          <label class="label-carro">Data de Compra</label>
          <p class="p-carro">${carro.data_compra}</p>
        </div>
      </div>
      </div>
      <div class="lista-despesas"> 
        <h4 class="h2-despesas">Despesas</h4>

        <div class="porta-despesas" id="porta-despesas">

        </div>
      </div>
      <div class="container-acoes">
     <div class="titulo-carro">
        <h4 class="h2-veiculo">Ações</h4>
      </div>
      
      <div class="acoes">
      <a href="registrar_venda.php?modelo=`+carro.modelo+` && placa=`+carro.placa+`&& fabricante=`+carro.fabricante+` && ano=`+carro.ano+`" class="link-acoes">
       Concluir venda
      </a>
      
      </div>
    </div>
    </div>
    `;

      $("#control").html(conteudo);
      $("#slides").html(imagensHTML);
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

function editar(btn, idVeiculo) {
  $.ajax({
    url: "PHP/listarcarroEmpresa.php",
    method: "GET",
    dataType: "json",
    success: function (data) {
      const carro = data.find(c => c.id_veiculo == idVeiculo);
      if (!carro) return;

      // Renderiza imagens existentes
      let imagensHTML = "";
      if (carro.imagens && carro.imagens.length > 0) {
        carro.imagens.forEach(img => {
          imagensHTML += `<img src="PHP/${img}" class="img-fluid mb-2 rounded imagem-carros">`;
        });
      }

      let conteudo = `
        <div class="conteudo-carros">
          <div class="container-carro-edit mt-5 mb-5">
            <div class="card shadow p-4 form-update-card">
              <h2 class="mb-4 text-center h2-title font-weight-bold edit-h2">Atualização de Veículo</h2>

              ${imagensHTML}

              <form method="POST" action="PHP/atualiza-veiculo.php" enctype="multipart/form-data" autocomplete="off">
                <input type="hidden" id="id" name="id" value="${carro.id_veiculo}">

                <!-- Campos do veículo -->
                <div class="form-row">
                  <div class="col-md-3 mb-3">
                    <label for="ano" class="form-label"><i class="fa-solid fa-calendar"></i> Ano</label>
                    <input type="number" id="ano" name="ano" class="form-control" placeholder="Ex: 2020" min="1900" max="2099" value="${carro.ano}" required/>
                  </div>

                  <div class="col-md-5 mb-3">
                    <label for="placa" class="form-label"><i class="fa-solid fa-car"></i> Placa</label>
                    <input type="text" id="placa" name="placa" class="form-control" placeholder="ABC-1234" maxlength="8" value="${carro.placa}" required/>
                  </div>

                  <div class="col-md-4 mb-3">
                    <label for="data_compra" class="form-label"><i class="fa-solid fa-calendar-check"></i> Data da Compra</label>
                    <input type="text" id="data_compra" name="data_compra" class="form-control" placeholder="dd/mm/aaaa" maxlength="10" value="${carro.data_compra}" required/>
                  </div>
                </div>

                <div class="form-row">
                  <div class="col-md-4 mb-3">
                    <label for="status" class="form-label"><i class="fa-solid fa-info-circle"></i> Status do Veículo</label>
                    <select name="status" id="status" class="form-control" required>
                      <option value="" disabled>Selecione o status</option>
                      <option value="Disponível">Disponível</option>
                      <option value="Manutenção">Em manutenção</option>
                    </select>
                  </div>

                  <div class="col-md-4 mb-3">
                    <label for="fabricante" class="form-label"><i class="fa-solid fa-industry"></i> Fabricante</label>
                    <input type="text" id="fabricante" name="fabricante" class="form-control" placeholder="Ex: Toyota" value="${carro.fabricante}" required/>
                  </div>

                  <div class="col-md-4 mb-3">
                    <label for="modelo" class="form-label"><i class="fa-solid fa-car-side"></i> Modelo</label>
                    <input type="text" id="modelo" name="modelo" class="form-control" placeholder="Ex: Corolla" value="${carro.modelo}" required/>
                  </div>
                </div>

                <div class="form-row">
                  <div class="col-md-6 mb-3">
                    <label for="carroceria" class="form-label"><i class="fa-solid fa-car-alt"></i> Tipo de Carroceria</label>
                    <input type="text" id="carroceria" name="carroceria" class="form-control" value="${carro.carroceria}" required/>
                  </div>

                  <div class="col-md-6 mb-3">
                    <label for="cor" class="form-label"><i class="fa-solid fa-palette"></i> Cor do Carro</label>
                    <input type="text" id="cor" name="cor" class="form-control" value="${carro.cor}" required/>
                  </div>
                </div>

                <div class="form-row">
                  <div class="col-md-6">
                    <label for="cambio" class="form-label"><i class="fa-solid fa-cogs"></i> Tipo de Câmbio</label>
                    <select name="cambio" id="cambio" class="form-control" required>
                      <option value="" disabled>Selecione o tipo de câmbio</option>
                      <option value="Manual">Manual</option>
                      <option value="Automático">Automático</option>
                      <option value="Automatizado">Automatizado</option>
                      <option value="CVT">CVT</option>
                      <option value="Dual Clutch">Dual Clutch</option>
                      <option value="Outro">Outro</option>
                    </select>
                  </div>

                  <div class="col-md-6 mb-3">
                    <label for="combustivel" class="form-label"><i class="fa-solid fa-gas-pump"></i> Tipo de Combustível</label>
                    <select name="combustivel" id="combustivel" class="form-control" required>
                      <option value="" disabled>Selecione o tipo de combustível</option>
                      <option value="Gasolina">Gasolina</option>
                      <option value="Etanol">Etanol</option>
                      <option value="Flex">Flex</option>
                      <option value="Diesel">Diesel</option>
                      <option value="GNV">GNV</option>
                      <option value="Elétrico">Elétrico</option>
                      <option value="Híbrido">Híbrido</option>
                      <option value="Outro">Outro</option>
                    </select>
                  </div>
                </div>

                <div class="form-row">
                  <div class="col-md-4 mb-3">
                    <label for="km" class="form-label"><i class="fa-solid fa-tachometer-alt"></i> Quilometragem</label>
                    <input type="number" id="km" name="km" value="${carro.quilometragem}" class="form-control" placeholder="Ex: 50000"/>
                  </div>

                  <div class="col-md-4 mb-3">
                    <label for="valor" class="form-label"><i class="fa-solid fa-dollar-sign"></i> Valor (R$)</label>
                    <input type="number" step="0.01" id="valor" name="valor" class="form-control" placeholder="Ex: 35000.00" value="${carro.valor}"/>
                  </div>

                  <div class="col-md-4 mb-3">
                    <label for="valor_compra" class="form-label"><i class="fa-solid fa-coins"></i> Valor de Compra (R$)</label>
                    <input type="number" step="0.01" id="valor_compra" name="valor_compra" class="form-control" placeholder="Ex: 1500.00" value="${carro.valor_compra}"/>
                  </div>

                  <div class="col-md-4 mb-3">
                    <label for="custos_extra" class="form-label"><i class="fa-solid fa-coins"></i> Custos Extras (R$)</label>
                    <input type="number" step="0.01" id="custos_extra" name="custos_extra" class="form-control" placeholder="Ex: 1500.00" value="${carro.custos_extra}"/>
                  </div>
                </div>

                <!-- Upload de novas imagens -->
                <div class="form-group mt-3">
                  <label for="imagens" class="form-label"><i class="fa-solid fa-camera"></i> Adicionar novas fotos do veículo</label>
                  <input type="file" id="imagens" name="imagens[]" class="form-control-file" accept="image/*" multiple  aria-describedby="imagensHelp" />
                  <small id="imagensHelp" class="form-text text-muted">Você pode enviar várias imagens adicionais.</small>
                </div>

                <button type="submit" class="btn btn-primary btn-lg btn-block mt-4 botao-edit">
                  <i class="fa-solid fa-save"></i> Atualizar Veículo
                </button>
              </form>
            </div>
          </div>
        </div>
      `;

      $("#control-edit").html(conteudo);

      // Preenche selects com os valores do veículo
      $("#status").val(carro.statusveiculo);
      $("#cambio").val(carro.tipo);
      $("#combustivel").val(carro.combustivel);
    },
    error: function(xhr, status, error) {
      console.error(error);
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
//abrir tela de edição de veiculo////
/////////////////////////////////////

$(document).on("click", ".editar-veiculo", function (){
  $(".container-view-edit").toggleClass("viewed-edit");
  $("body").toggleClass("viewing");
});

$(document).on("keydown", function (e) {
  if (e.key === "Escape") {
    $(".container-view-edit").removeClass("viewed-edit");
    $("body").removeClass("viewing");
    $(".control-imagens").removeClass("viewer-images");
  }
});

//////////////////////////////////////////
//abrir tela de visualização de imagem////
//////////////////////////////////////////

$(document).on("click", ".img-principal", function() {
  $(".control-imagens").addClass("viewer-images");
  const $slides = $(".slides img");
  $slides.removeClass("displaySlide");
  slideIndex = 0;
  if ($slides.length > 0) $slides.eq(slideIndex).addClass("displaySlide");
});

$(document).on("keydown", function(e){
  if(e.key === "s"){
    $(".control-imagens").removeClass("viewer-images");
  }
});

let slideIndex = 0;

$(document).ready(function() {
  comecarSlide();
});

function comecarSlide() {
  const $slides = $(".slides img");
  if ($slides.length > 0) $slides.eq(slideIndex).addClass("displaySlide");
}

function mostrarSlide(index) {
  const $slides = $(".slides img");
  if (index >= $slides.length) slideIndex = 0;
  else if (index < 0) slideIndex = $slides.length - 1;
  $slides.removeClass("displaySlide");
  $slides.eq(slideIndex).addClass("displaySlide");
}

function prevSlide() {
  slideIndex--;
  mostrarSlide(slideIndex);
}

function nextSlide() {
  slideIndex++;
  mostrarSlide(slideIndex);
}


//preview de imagens (peguei o mesmo codigo do preview.js e """traduzi""" pra ajax)

$(document).on('change', '#imagens', function() {
  const $input = $(this);
  const files = this.files;

  let $preview = $input.next('.preview-container');
  if ($preview.length === 0) {
    $preview = $('<div class="preview-container"></div>').css({
      display: 'flex',
      flexWrap: 'wrap',
      gap: '10px',
      marginTop: '10px'
    });
    $input.after($preview);
  }

  $preview.empty();

  $.each(files, function(_, file) {
    if (!file.type.startsWith('image/')) return;

    const reader = new FileReader();
    reader.onload = function(e) {
      const $img = $('<img>').attr('src', e.target.result).css({
        width: '100px',
        height: 'auto',
        borderRadius: '8px',
        boxShadow: '0 0 5px rgba(0,0,0,0.2)'
      });
      $preview.append($img);
    };
    reader.readAsDataURL(file);
  });
});

//////////////////////////////////////////
//////adicionar custo carro(função)///////
/////////////////////////////////////////

function adicionarCustos(btn, idVeiculo){
  $.ajax({
    url: "PHP/listarcarroEmpresa.php",
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

      const valorCustoFormatado = Number(carro.custos_extra).toLocaleString('pt-BR', {
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

              <form method="POST" action="PHP/addcustoAntes_veiculo.php" autocomplete="off">
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

     
      const custoInicial = Number(carro.custos_extra);
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



$(document).on("click", ".adicionar-veiculo", function (){
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
    url: "PHP/editarDespesaAntes.php",
    method: "POST",
    data: {
      id_veiculo: idVeiculo,
      id_custo: idCusto,
      descricaoATT: descricao,
      custoATT: valor,         
      qtATT: qt               
    },
    success: function (res) {
      location.reload();
      console.log("Resposta do PHP:", res);
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
    url: "PHP/excluirDespesaAntes.php",
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