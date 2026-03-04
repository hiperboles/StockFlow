<?php

require ("conexao.php");

if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["consulta_id_funcionario"])){
    $id = $_POST['consulta_id_funcionario'] ?? '';

    $sql = "DELETE FROM funcionario WHERE id_funcionario = ?";

    $stmt = $con -> prepare($sql);
    $stmt -> bind_param("i", $id);
    $stmt -> execute();

    if($stmt -> affected_rows > 0){
        echo '<script>console.log("usuario excluido com sucesso")</script>';
         header("Location: ../pagina-funcionario.php");
        exit();
    }else{
        echo '<script>console.log("erro na execução")</script>';
        header("Location: ../pagina-funcionario.php");
        exit();
    }

    $stmt -> close();
    $con -> close();

    

} else {
    echo '<script>console.log("id não recebido")</script>';
    header("Location: ../pagina-funcionario.php");
        exit();
}

