<?php
session_start();
include("conexao.php");

$cpf = $_POST['cpf'] ?? '';
$email = $_POST['email'] ?? '';


$sql = "SELECT * FROM funcionario WHERE cpf = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("s", $cpf);
$stmt->execute();
$result = $stmt->get_result();



$sqlEmail = "SELECT * FROM empresa WHERE email = ?";
$stmtEmail = $con->prepare($sqlEmail);
$stmtEmail->bind_param("s", $email);
$stmtEmail->execute();
$resultEmail = $stmtEmail->get_result();

if ($result->num_rows > 0 || $resultEmail->num_rows > 0) {
    $_SESSION['abrir_modal_funcionario_cadastrado'] = true;
    header("Location: ../pagina-funcionario.php");
    exit;
}else{

    
$nome = $_POST['nome'] ?? '';
$telefone = $_POST['telefone'] ?? '';
$senha = $_POST['senha'] ?? '';
$cod_empresa = $_SESSION['id_empresa'] ?? null;

$sqlInsert = "INSERT INTO funcionario (nome, cpf, telefone, email, senha, cod_empresa) VALUES (?, ?, ?, ?, ?, ?)";
$stmtInsert = $con->prepare($sqlInsert);
$stmtInsert->bind_param("sssssi", $nome, $cpf, $telefone, $email, $senha, $cod_empresa);
$stmtInsert->execute();



header("Location: ../pagina-funcionario.php");
exit;

}





$stmtInsert->close();
$stmt->close();
$stmtEmail->close();
$con->close();




?>
