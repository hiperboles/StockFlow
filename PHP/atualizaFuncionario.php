<?php
session_start();
include("conexao.php");

$nome = $_POST['consulta_nome'] ?? '';
$email = $_POST['consulta_email'] ?? '';
$telefone = $_POST['consulta_telefone'] ?? '';
$cpf = $_POST['consulta_cpf'] ?? '';
$id = $_POST['consulta_id_funcionario'] ?? '';


$verificaEmail = $con->prepare("SELECT id_funcionario FROM funcionario WHERE email = ? AND id_funcionario != ?");
$verificaEmail->bind_param("si", $email, $id);
$verificaEmail->execute();
$verificaEmail->store_result();

if ($verificaEmail->num_rows > 0) {
    $_SESSION['erro_email'] = "Este e-mail já está em uso por outro funcionário.";
    header("Location: ../pagina-funcionario.php");
    exit();
}
$verificaEmail->close();

$verificaEmailEmpresa = $con->prepare("SELECT id_empresa FROM empresa WHERE email = ?");
$verificaEmailEmpresa->bind_param("s", $email);
$verificaEmailEmpresa->execute();
$verificaEmailEmpresa->store_result();

if ($verificaEmailEmpresa->num_rows > 0) {
    $_SESSION['erro_email'] = "Este e-mail já está em uso por outro usuário Empresa.";
    header("Location: ../pagina-funcionario.php");
    exit();
}
$verificaEmailEmpresa->close();


$verificaCpf = $con->prepare("SELECT id_funcionario FROM funcionario WHERE cpf = ? AND id_funcionario != ?");
$verificaCpf->bind_param("si", $cpf, $id);
$verificaCpf->execute();
$verificaCpf->store_result();

if ($verificaCpf->num_rows > 0) {
    $_SESSION['erro_cpf'] = "Este CPF já está em uso por outro funcionário.";
    header("Location: ../pagina-funcionario.php");
    exit();
}
$verificaCpf->close();


$sql = "UPDATE funcionario SET nome=?, email=?, telefone=?, cpf=? WHERE id_funcionario = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("ssssi", $nome, $email, $telefone, $cpf, $id);
$stmt->execute();

$stmt->close();
$con->close();


header("Location: ../pagina-funcionario.php");
exit();
?>
