<?php
session_start();
include "conexao.php";


$nome_fantasia = $_POST['nomefantasia'];
$telefone = trim($_POST['telefone']);
$cnpj = trim($_POST['cnpj']);
$email = trim($_POST['email']);
$senhaoriginal = trim($_POST['senha']);
$cep = trim($_POST['cep']);
$rua = $_POST['endereco'];
$numero = trim($_POST['numero']);
$bairro = $_POST['bairro'];
$cidade = $_POST['cidade'];
$estado = $_POST['estado'];

$senha = password_hash($senhaoriginal, PASSWORD_DEFAULT);


$sql_check = $con->prepare("SELECT id_empresa FROM empresa WHERE cnpj = ? OR email = ?");
$sql_check->bind_param("ss", $cnpj, $email);
$sql_check->execute();
$result = $sql_check->get_result();

if ($result->num_rows == 0) {
    
    $sql_insert = $con->prepare("INSERT INTO empresa 
        (email, senha,cnpj, nome_fantasia, telefone, cep, endereco, cidade, estado, numero, bairro) 
        VALUES (?, ?,?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $sql_insert->bind_param("sssssssssss", 
        $email, $senha, $cnpj, $nome_fantasia, $telefone, $cep, $rua, $cidade, $estado, $numero, $bairro
    );

    if ($sql_insert->execute()) {
         header('Location: ../pagina-login.php');//tudo certo
         exit();
    } else {
         header('Location: ../pagina-cadastro.php');// erro
         exit();
    }
} else {
    $_SESSION['abrir_modal_empresa_cadastrado'] = true;
    header("Location: ../pagina-cadastro-empresa.php");
    exit;
}

$con->close();
?>
