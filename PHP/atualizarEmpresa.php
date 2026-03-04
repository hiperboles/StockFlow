<?php


require "conexao.php";

$id = $_POST["id_empresa"];
$nome_fantasia = trim($_POST['nome_fantasia']);
$telefone = trim($_POST['telefone']);
$cnpj = trim($_POST['cnpj']);
$email = trim($_POST['email']);
$cep = trim($_POST['cep']);
$rua = trim($_POST['endereco']);
$numero = trim($_POST['numero']);
$bairro = trim($_POST['bairro']);
$cidade = trim($_POST['cidade']);
$estado = trim($_POST['estado']);

if (
    empty($id) || empty($nome_fantasia) || empty($telefone) || empty($cnpj) || empty($email) || 
    empty($cep) || empty($rua) || empty($numero) || empty($bairro) || empty($cidade) || empty($estado)
) {
    echo "<script>
            alert('Preencha todos os campos!');
            window.history.back();
          </script>";
    exit;
}

session_start(); 
$verificaEmailEmpresa = $con->prepare("SELECT id_empresa FROM empresa WHERE email = ? AND id_empresa != ?");
$verificaEmailEmpresa->bind_param("si", $email, $id);
$verificaEmailEmpresa->execute();
$verificaEmailEmpresa->store_result();

if ($verificaEmailEmpresa->num_rows > 0) {
    $_SESSION['erro_email'] = "Este e-mail já está em uso por outra empresa.";
    header("Location: ../perfilEmpresa.php");
    exit();
}
$verificaEmailEmpresa->close();


$verificaCnpjEmpresa = $con->prepare("SELECT id_empresa FROM empresa WHERE cnpj = ? AND id_empresa != ?");
$verificaCnpjEmpresa->bind_param("si", $cnpj, $id);
$verificaCnpjEmpresa->execute();
$verificaCnpjEmpresa->store_result();

if ($verificaCnpjEmpresa->num_rows > 0) {
    $_SESSION['erro_cnpj'] = "Este CNPJ já está em uso por outra empresa.";
    header("Location: ../perfilEmpresa.php");
    exit();
}
$verificaCnpjEmpresa->close();


$verificaEmail = $con->prepare("SELECT id_funcionario FROM funcionario WHERE email = ?");
$verificaEmail->bind_param("s", $email);
$verificaEmail->execute();
$verificaEmail->store_result();

if ($verificaEmail->num_rows > 0) {
    $_SESSION['erro_email'] = "Este e-mail já está em uso por outro funcionário.";
    header("Location: ../perfilEmpresa.php");
    exit();
}
$verificaEmail->close();


$sql = "UPDATE empresa 
        SET nome_fantasia = ?, telefone = ?, cnpj = ?, email = ?, cep = ?, 
            endereco = ?, numero = ?, bairro = ?, cidade = ?, estado = ? 
        WHERE id_empresa = ?";

$stmt = $con->prepare($sql);

if (!$stmt) {
    die("Erro no prepare: " . $con->error);
}

$stmt->bind_param(
    "ssssssssssi",
    $nome_fantasia,
    $telefone,
    $cnpj,
    $email,
    $cep,
    $rua,
    $numero,
    $bairro,
    $cidade,
    $estado,
    $id
);

if ($stmt->execute()) {
    // echo "<script>
    //         alert('Alterado com sucesso!');
    //         setTimeout(function(){
    //             window.location.href='../perfilEmpresa.php';
    //         }, 1000);
    //       </script>";
    $tipo = 5;
    header("Location: ../avisos.php?i=$tipo");
} else {
    // echo "<script>
    //         alert('Erro na alteração!');
    //         setTimeout(function(){
    //             window.location.href='../perfilEmpresa.php';
    //         }, 1000);
    //       </script>";
    $tipo = 6;
    header("Location: ../avisos.php?i=$tipo");
}

$stmt->close();
$con->close();
?>
