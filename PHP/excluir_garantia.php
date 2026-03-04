<?php
session_start();
require "conexao.php";

if (isset($_POST['id_venda'])) {
    $id_venda = $_POST['id_venda'];
    
    // Excluir a venda
    $stmt = $con->prepare("DELETE FROM venda WHERE id_venda = ?");
    $stmt->bind_param("i", $id_venda);
    $stmt->execute();
    
    if ($stmt->affected_rows > 0) {
        $_SESSION['msg'] = "Venda excluída com sucesso!";
    } else {
        $_SESSION['msg'] = "Erro ao excluir a venda.";
    }
    $stmt->close();
}

$con->close();
header("Location: ../relatorioTeste.php"); 
exit;
?>
