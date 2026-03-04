

<!DOCTYPE html>
<html lang="pt-br">
  <head>
      <!-- Meta tags Obrigatórias -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!-- Ligação css -->
     <link rel="stylesheet" href="css/sidebar.css">
     <link rel="stylesheet" href="css/cadastro-veiculo.css">

     <!-- Fontes de texto -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital@0;1&family=Special+Gothic+Expanded+One&display=swap" rel="stylesheet">


    <!-- icones -->
     <script src="https://kit.fontawesome.com/d15c84f3d2.js" crossorigin="anonymous"></script>

    <title>Cadastro de Veículo</title>

    <style>
      body {
        background: #DDDDDB;
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      }
      .card {
        border-radius: 15px;
      }
      .form-label {
        font-weight: 600;
        color: #163970ff;
        font-size: 18px;
      }
     
      input[type="number"],
      input[type="text"] {
        max-width: 100%;
      }
      
      .row > div {
        margin-bottom: 1.2rem;
      }
      #placa{
      text-transform: uppercase;
      }
    </style>
  </head>

  <body>

  <?php
session_start();
if (isset($_SESSION['id_empresa'])) {
  $nome = $_SESSION['nome_fantasia'];
  
}

if (isset($_SESSION['cod_empresa'])) {
  $nome = $_SESSION['nome_funcionario'];
  
}

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
        <i class="fa-solid fa-hand-holding-dollar fa-2x"></i>
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


   <div class="container mt-5 mb-5">
  <div class="card shadow p-4">
    
    <h2 class="mb-4 text-center h2-title font-weight-bold">Cadastro de Veículo</h2>

    <form method="POST" enctype="multipart/form-data" action="PHP/processa_veiculo.php" autocomplete="off">
      <div class="form-row">
        <div class="col-md-3">
          <label for="ano" class="form-label"><i class="fa-solid fa-calendar"></i> Ano</label>
          <input type="number" id="ano" name="ano" class="form-control" placeholder="Ex: 2020" min="1900" max="2099" maxlength="4" required />
        </div>

            <div class="col-md-5">
      <label for="placa" class="form-label"><i class="fa-solid fa-car"></i> Placa</label>
      <input type="text" id="placa" name="placa" class="form-control" placeholder="ABC-1234" required maxlength="8" />
      
      <?php 
        if (isset($_GET['erro']) && $_GET['erro'] == 'placa_duplicada') {
            echo '<small class="text-danger">A placa informada já está cadastrada no sistema.</small>';
        } elseif (isset($_GET['erro'])) {
            echo '<small class="text-danger">Erro: ' . htmlspecialchars($_GET['erro']) . '</small>';
        }
      ?>
    </div>


        <div class="col-md-4">
          <label for="data_compra" class="form-label"><i class="fa-solid fa-calendar-day"></i> Data da Compra</label>
          <input type="text" id="data_compra" name="data_compra" class="form-control" placeholder="dd/mm/aaaa" required maxlength="10" />
        </div>
      </div>

      <div class="form-row">
        <div class="col-md-4">
          <label for="status" class="form-label"><i class="fa-solid fa-info-circle"></i> Status do Veículo</label>
          <select name="status" id="status" class="form-control" required>
            <option value="" disabled selected>Selecione o status</option>
            <option value="Disponível">Disponível</option>
            <option value="Manutenção">Em manutenção</option>
          </select>
        </div>

        <div class="col-md-4">
          <label for="fabricante" class="form-label"><i class="fa-solid fa-industry"></i> Fabricante</label>
          <select name="fabricante" id="fabricante" class="form-control" required onchange="carregarModelos()">
            <option value="" disabled selected>Selecione um fabricante</option>
            <option value="AstonMartin">AstonMartin</option>
            <option value="Audi">Audi</option>
            <option value="BMW">BMW</option>
            <option value="BYD">BYD</option>
            <option value="Cadillac">Cadillac</option>
            <option value="Chery">Chery</option>
            <option value="Chevrolet">Chevrolet</option>
            <option value="Citroen">Citroen</option>
            <option value="Dodge">Dodge</option>
            <option value="Fiat">Fiat</option>
            <option value="Ford">Ford</option>
            <option value="Honda">Honda</option>
            <option value="Hyundai">Hyundai</option>
            <option value="Jeep">Jeep</option>
            <option value="Kia">Kia</option>
            <option value="LandRover">LandRover</option>
            <option value="Mercedes">Mercedes</option>
            <option value="Mitsubishi">Mitsubishi</option>
            <option value="Nissan">Nissan</option>
            <option value="Peugeot">Peugeot</option>
            <option value="Porsche">Porsche</option>
            <option value="Renault">Renault</option>
            <option value="Tesla">Tesla</option>
            <option value="Toyota">Toyota</option>
            <option value="Volkswagen">Volkswagen</option>

          </select>
        </div>

        <div class="col-md-4">
          <label for="modelo" class="form-label"><i class="fa-solid fa-car-side"></i> Modelo</label>
          <select name="modelo" id="modelo" class="form-control" required>
            <option value="" disabled selected>Selecione um modelo</option>
          </select>
        </div>
      </div>

      <div class="form-row">
        <div class="col-md-6">
          <label for="carroceria" class="form-label"><i class="fa-solid fa-car-alt"></i> Tipo de Carroceria</label>
          <select name="carroceria" id="carroceria" class="form-control" required>
            <option value="" disabled selected>Selecione o tipo de carroceria</option>
            <option value="Hatch">Hatch</option>
            <option value="Sedã">Sedã</option>
            <option value="SUV">SUV</option>
            <option value="Picape">Picape</option>
            <option value="Perua">Perua</option>
            <option value="Coupé">Coupé</option>
            <option value="Conversível">Conversível</option>
            <option value="Minivan">Minivan</option>
            <option value="Van">Van</option>
            <option value="Utilitário">Utilitário</option>
          </select>
        </div>

        <div class="col-md-6">
          <label for="cor" class="form-label"><i class="fa-solid fa-palette"></i> Cor do Carro</label>
          <select name="cor" id="cor" class="form-control" required>
            <option value="" disabled selected>Selecione a cor</option>
            <option value="Branco">Branco</option>
            <option value="Preto">Preto</option>
            <option value="Prata">Prata</option>
            <option value="Cinza">Cinza</option>
            <option value="Vermelho">Vermelho</option>
            <option value="Azul">Azul</option>
            <option value="Verde">Verde</option>
            <option value="Amarelo">Amarelo</option>
            <option value="Laranja">Laranja</option>
            <option value="Marrom">Marrom</option>
            <option value="Bege">Bege</option>
            <option value="Dourado">Dourado</option>
            <option value="Roxo">Roxo</option>
            <option value="Rosa">Rosa</option>
            <option value="Outro">Outro</option>
          </select>
        </div>
      </div>

      <div class="form-row">
        <div class="col-md-6">
          <label for="cambio" class="form-label"><i class="fa-solid fa-cogs"></i> Tipo de Câmbio</label>
          <select name="cambio" id="cambio" class="form-control" required>
            <option value="" disabled selected>Selecione o tipo de câmbio</option>
            <option value="Manual">Manual</option>
            <option value="Automático">Automático</option>
            <option value="Automatizado">Automatizado</option>
            <option value="CVT">CVT</option>
            <option value="Dual Clutch">Dual Clutch</option>
            <option value="Outro">Outro</option>
          </select>
        </div>

        <div class="col-md-6">
          <label for="combustivel" class="form-label"><i class="fa-solid fa-gas-pump"></i> Tipo de Combustível</label>
          <select name="combustivel" id="combustivel" class="form-control" required>
            <option value="" disabled selected>Selecione o tipo de combustível</option>
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
        <div class="col-md-4">
          <label for="km" class="form-label"><i class="fa-solid fa-tachometer-alt"></i> Quilometragem</label>
          <input type="text" id="km" name="km" class="form-control" placeholder="Ex: 50000" />
        </div>

        <div class="col-md-4">
          <label for="valor" class="form-label"><i class="fa-solid fa-dollar-sign"></i> Valor da Compra(R$)</label>
          <input type="text"  id="valor" name="valor" class="form-control" placeholder="Ex: 35000.00" />
        </div>

        <div class="col-md-4">
          <label for="custos_extra" class="form-label"><i class="fa-solid fa-coins"></i> Custos Extras (R$)</label>
          <input type="text" id="custos_extra" name="custos_extra" class="form-control" placeholder="Ex: 1500.00" />
        </div>

        <div class="col-md-4">
          <label for="valor_venda" class="form-label"><i class="fa-solid fa-dollar-sign"></i> Valor de Venda(R$)</label>
          <input type="text"  id="valor_venda" name="valor_venda" class="form-control" placeholder="Ex: 40000.00" />
        </div>
      </div>

      <div class="form-group">
        <label for="imagens" class="form-label"><i class="fa-solid fa-camera"></i> Fotos do veículo</label>
        <input type="file" id="imagens" name="imagens[]" class="form-control-file" accept="image/*" multiple required aria-describedby="imagensHelp" />
        <small id="imagensHelp" class="form-text text-muted">Você pode enviar várias imagens ao mesmo tempo.</small>
      </div>

      <button type="submit" class="btn btn-success btn-lg btn-block mt-4">
        <i class="fa-solid fa-check"></i> Cadastrar Veículo
      </button>
    </form>
  </div>
</div>

</div>


    <script>
      const modelosPorFabricante = {
        AstonMartin: ["DBX", "DBX707", "Vantage", "Vantage Roadster", "Vantage F1 Edition", "Vantage V12", "DB11", "DB11 Volante", "DBS", "DBS Volante", "DB12", "Vanquish", "Vanquish Volante", "Valhalla"],
        Audi: ["A3", "A4", "A5", "A6", "A7", "A8", "Q2", "Q3", "Q4 e-tron", "Q5", "Q7", "Q8", "e-tron", "e-tron GT", "RS3", "RS4", "RS5", "RS6", "RS7", "S3", "S4", "S5", "S6", "S7", "S8", "TT", "R8"],
        BMW: ["118i", "M135i", "218i", "M235 xDrive Gran Coupé", "320i GP", "320i Sport GP", "320i M Sport", "330e M Sport", "M340i", "M4 CS", "i4 Gran Coupé", "i4 M50 xDrive Gran Coupé", "Série 4 Cabrio", "530e M Sport", "i5 M60", "X6", "X6 M Competition", "745 LE", "i7 xDrive60 M Sport", "M850", "M8", "X1 sDrive20i GP", "X1 sDrive20i X-Line", "X1 sDrive20i M Sport", "X2", "X3", "X3 M", "X3 M50 xDrive", "X4", "X4 M", "X5", "X5 Plug-in Híbrido", "X6", "X7", "X7 M60i", "X7 M50i", "iX1 xDrive30 M Sport", "iX2 xDrive30 M Sport", "iX3 M Sport", "iX", "iX xDrive40", "iX xDrive50 Sport", "i4", "i4 M50 xDrive Gran Coupé", "i7 xDrive60 M Sport", "M2 Coupé", "M3 Competition", "M4 CS", "M5", "M8", "iX M60"],
        BYD: ["Tang", "Han", "Song Pro", "Song Max", "Yuan Plus", "Atto 3", "F3", "Dolphin", "Qin Plus", "Qin Pro", "Seal"],
        Cadillac: ["CT4", "CT5", "CT5-V Blackwing", "CT6", "Escalade", "Escalade ESV", "XT4", "XT5", "XT6", "Lyriq"],
        Chery: ["Tiggo 2", "Tiggo 3", "Tiggo 5x", "Tiggo 7", "Tiggo 8", "Tiggo 8 Pro", "Arrizo 5", "Arrizo 6", "Arrizo 6 Pro", "Arrizo 8"],
        Chevrolet: ["A20" , "Agile","Astra","Blazer","C10","Camaro","Captiva","Celta","Chevete","Corvette","Cruze","Montana","Onix","Omega","Prisma","S-10","Silverado","Spin","Zafira","Monza"],
        Citroen: ["C3","C4","C5","C6","C8","Picasso"],
        Dodge: ["Challenger","Ram 1500","Durango","Dakota","Magnum"],
        Fiat: ["147","500","Argo","Coupe","Cronos","Fiorino","Idea","Marea","Mobi","Palio","Punto","Uno","Siena","Stilo","Strada","Tempra","Toro"],
        Ford: ["EcoSport","Edge","Escape","Escort","F-100","F-1000","F-150","F-250","F-350","Fiesta","Focus","Fusion","Ka","Maverick","Mustang","Ranger","Pampa"],
        Honda: ["Accord","Civic","New Civic","Fit","Legend","Prelude"],
        Hyundai: ["Atos","Azera","Creta","Elantra","Equus","HB20","Santa Fe","Sonata","Tucson","Veloster","i30","ix35"],
        Jeep: ["Chrokee","Commander","Compass","Grand Cherokee","Renegade","Wrangler"],
        Kia: ["Besta","Cerato","Ceres","Clarus","Mohave","Optima","Picanto","Rio","Sportage"],
        LandRover: ["Defender","Discovery","Discovery Sport","Freelander","Range Rover","Evoque","Sport","Velar"],
        Mercedes: ["Sprinter","Vito","1113"],
        Mitsubishi: ["Eclipse","Cross","Galant","Grandis","Lancer","Pajero"],
        Nissan: ["350Z","Frontier","GT-R","Kicks","Maxima","Sentra","Versa"],
        Peugeot: ["106","2008","205","206","207","208","3008","306","307","308","405","406","407","408","508","605","607"],
        Porsche: ["718","911","Boxster","Cayenne","Cayman","Macan","Panamera"],
        Renault: ["Clio","Espace","Fluence","Laguna","Logan","Master","Megane","Safrane","Scenic","Sandero","Sandero Stepway","Trafic"],
        Tesla: ["Model 3","Model S","Model X","Model Y","CyberTruck"],
        Toyota: ["Corolla","Corona","Etios","Fortuner","Hilux","Landcruiser","Previa","Prius","Tundra"],
        Volkswagen: ["Amarok","Apollo","Atlas","Beetle","Brasilia","CC","CrossFox","Fox","Gol","Golf","Jetta","Kombi","Logus","Parati","Polo","Passat","Santana","Saveiro","T-Cross","Tiguan","UP","Virtus","Voyage"],




      };

      function carregarModelos() {
        const fabricanteSelect = document.getElementById("fabricante");
        const modeloSelect = document.getElementById("modelo");
        const fabricanteSelecionado = fabricanteSelect.value;

        modeloSelect.innerHTML = '<option value="" disabled selected>Selecione um modelo</option>';

        if (fabricanteSelecionado && modelosPorFabricante[fabricanteSelecionado]) {
          modelosPorFabricante[fabricanteSelecionado].forEach((modelo) => {
            const option = document.createElement("option");
            option.value = modelo;
            option.text = modelo;
            modeloSelect.appendChild(option);
          });
        }
      }
    </script>

    

    
    
    <!-- jQuery primeiro, depois Popper.js, depois Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
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
    <script src="js/sidebar.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    <!-- JavaScript (Opcional) -->
    <script src="js/cadastroCarros.js"> </script>
    <script src="js/preview.js"> </script>
    <script src="js/validacaoCarro.js"></script>
      
    
  </body>
</html>
