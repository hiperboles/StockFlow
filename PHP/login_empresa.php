<?php 
session_start();
include "conexao.php";


if (empty($_POST['email']) || empty($_POST['senha'])) {
    echo "<script>
        alert('Preencha todos os campos!');
        window.location.href = '../pagina-login.php';
    </script>";
    exit();
}

$email = $_POST['email'];
$senha = $_POST['senha'];


$stmt = $con->prepare("SELECT * FROM empresa WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    // Verifica se a senha está correta
    if (password_verify($senha, $user['senha'])) {
        session_unset(); 
        $_SESSION['nome_fantasia'] = $user['nome_fantasia'];
        $_SESSION['id_empresa'] = $user['id_empresa']; // armazenar id correto na sessão
        header('Location: ../inicial-gerente.php'); // login bem-sucedido
        exit();
    }
}

// Se não encontrou ou senha incorreta
$tipo = 1;
// echo "<script>
//     alert('Empresa não encontrada ou senha incorreta!');
//     window.location.href = '../pagina-login.php';
// </script>";
header("Location: ../avisos.php?i=$tipo");
exit();
?>
