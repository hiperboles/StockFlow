<?php

require "../PHP/conexao.php";
require '../vendor/autoload.php'; // Certifique-se de que o Composer foi usado para instalar o PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$email = $_POST['email'] ?? '';

if (!$email) {
    exit("E-mail não fornecido.");
}

// Verifica se o e-mail existe no banco
$stmt = $con->prepare("SELECT * FROM empresa WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    exit("E-mail não encontrado.");
}

// Geração do token e expiração
$token = bin2hex(random_bytes(16));
$expires = date('Y-m-d H:i:s', time() + 3600); // 1 hora


$stmt = $con->prepare("INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $email, $token, $expires);
$stmt->execute();


$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'ymanzineh@gmail.com';
    $mail->Password = 'rkzp xdha usqz ufwk'; 
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('ymanzineh@gmail.com', 'Stock Flow');
    $mail->addAddress($email);
    $mail->isHTML(true);

    $link = "http://localhost/TCC/recuperar-senha/reset_password.php?token=$token";
$mail->Subject = 'Redefina sua senha';
$mail->Body = "
    Olá,

    Recebemos uma solicitação para redefinir a sua senha. Para continuar com o processo, clique no link abaixo:

    <a href='$link'>Redefinir minha senha</a>

    Este link é válido por 1 hora. Caso você não tenha solicitado essa alteração, favor desconsiderar este e-mail.

    Atenciosamente,  
    Equipe [Stock Flow]
";

    $mail->send();
    echo "Verifique seu e-mail para continuar.";
} catch (Exception $e) {
    echo "Erro ao enviar o e-mail: " . $mail->ErrorInfo;
}
?>
