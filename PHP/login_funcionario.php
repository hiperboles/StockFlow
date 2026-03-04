<?php 
session_start();

include "conexao.php";

$email = $_POST['email'];
$senha = $_POST['senha'];

if (empty($email) || empty($senha)) {
    echo "<script type='text/javascript'>
    alert('Preencha Todos os campos!');
    window.location.href = '../pagina-login.php';
    </script>";
    exit();
}

$stmt = $con->prepare("SELECT * FROM funcionario WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    if ($senha === $user['senha']) {
       
        session_unset(); 

        $_SESSION['nome_funcionario'] = $user['nome'];
        $_SESSION['id_funcionario'] = $user['id_funcionario'];
        $_SESSION['tipo_usuario'] = $user['tipo_usuario'];
        $_SESSION['cod_empresa'] = $user['cod_empresa'];

        header('Location: ../inicial-funcionario.php');
        exit();
    }
}

$tipo = 2;
header("Location: ../avisos.php?i=$tipo");
exit();
?>
