<?php
require "conexao.php";
session_start();
$id_funcionario = $_SESSION['id_funcionario'] ?? null;

if (isset($_SESSION['id_empresa'])) {
    $cod_empresa = $_SESSION['id_empresa'];
} elseif (isset($_SESSION['id_funcionario'])) {
    $cod_empresa = $_SESSION['cod_empresa'];
} else {
    $cod_empresa = null;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = intval($_POST['id'] ?? 0);
    $custos_extra = $_POST['valor_custo'];
    $descricao = $_POST['descricao_custo'];
    $quantidade = $_POST['quantidade'];
    $data_custo = $_POST['data_custo'];
    if (!empty($data_custo)) {
        if (strpos($data_custo, '/') !== false) {
           $dataObj = DateTime::createFromFormat('d/m/Y', $data_custo);
        } else {
          $dataObj = DateTime::createFromFormat('Y-m-d', $data_custo);
        }

        if ($dataObj) {
            $data_custo = $dataObj->format('Y-m-d');
        } else {
            die("Data de compra inválida. Use o formato dd/mm/yyyy ou yyyy-mm-dd.");
        }
    } else {
        $data_custo = null;
    }
    

    
    

    
    $sql = "INSERT INTO custos_garantia( 
             custos , descricao_custo,cod_veiculo,data_custo,quantidade) values(?,?,?,?,?)";

    $stmt = $con->prepare($sql);
    if (!$stmt) {
        die("Erro ao preparar a query: " . $con->error);
    }

    
    $stmt->bind_param(
        "dsisi",
        $custos_extra,$descricao,$id,$data_custo,$quantidade
    );

   $addCustoVenda = "SELECT custos FROM venda WHERE cod_veiculo = ?";
    $ADD = $con->prepare($addCustoVenda); 
    $ADD->bind_param("i", $id);
    $ADD->execute();
    $resultADD = $ADD->get_result();

    if ($row = $resultADD->fetch_assoc()) {
        $custos_extraTB = $row['custos'];
        $custo_extra_att = $custos_extraTB + $custos_extra;

         $sql2 = "UPDATE venda 
            SET custos = ?
            WHERE cod_veiculo = ?";

         $stmt2 = $con->prepare($sql2);
         $stmt2->bind_param("si",$custo_extra_att,$id);
         $stmt2->execute();
    }




    if ($stmt->execute()) {
        
        if ($id_funcionario === null) {
            header("Location: ../inicial-gerente.php");
        } else {
            header("Location: ../inicial-funcionario.php");
        }
        exit;
    } else {
        die("Erro ao atualizar o veículo: " . $stmt->error);
    }

    $stmt->close();
    $con->close();
}
?>
