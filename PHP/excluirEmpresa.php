<?php
include "conexao.php";


if (!isset($_GET["id"]) || empty($_GET["id"]) || !is_numeric($_GET["id"])) {
    echo "<script>
            alert('ID inválido!');
            window.location.href='../perfil-empresa.php';
          </script>";
    exit;
}

$id_empresa = (int) $_GET["id"];


$sql = "DELETE FROM empresa WHERE id_empresa = ?";
$stmt = $con->prepare($sql);

if ($stmt) {
    $stmt->bind_param("i", $id_empresa);

    if ($stmt->execute()) {
        // echo "<script> 
        //         alert('Excluído com sucesso!'); 
        //         setTimeout(function(){
        //             window.location.href='../pagina-inicial.php';
        //         }, 500);
        //       </script>";
              $tipo = 3;
              header("Location: ../avisos.php?i=$tipo");
    } else {
        // echo "<script> 
        //         alert('Erro ao excluir!'); 
        //         setTimeout(function(){
        //             window.location.href='../perfil-empresa.php';
        //         }, 1000);
        //       </script>";
        
              $tipo = 4;
              header("Location: ../avisos.php?i=$tipo");
    }

    $stmt->close();
}

$con->close();
?>
