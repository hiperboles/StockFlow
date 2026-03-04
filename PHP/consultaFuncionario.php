<?php
require "conexao.php"; 

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['botaoId'])) {
    $id_funcionario = trim($_POST['botaoId']);
   
    $sql = "SELECT id_funcionario, email, nome, telefone, cpf FROM funcionario WHERE id_funcionario = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $id_funcionario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($funcionario = $result->fetch_assoc()) {
        header('Content-Type: application/json');
        echo json_encode($funcionario);
    } else {
        echo json_encode(["erro" => "Funcionário não encontrado"]);
    }

    $stmt->close();
    $con->close();
} else {
    echo json_encode(["erro" => "ID do botão não recebido"]);
}


