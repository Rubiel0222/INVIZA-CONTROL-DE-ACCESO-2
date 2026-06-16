<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/vendor/autoload.php';

function enviarCorreoRecuperacion($destinatario, $token) {
    $mail = new PHPMailer(true);

    try {
        // Configuración SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Cambia si usas Amazon SES
        $mail->SMTPAuth = true;
        $mail->Username = 'TU_CORREO@gmail.com'; // tu correo
        $mail->Password = 'TU_CONTRASEÑA_APP';   // contraseña de aplicación
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Remitente y destinatario
        $mail->setFrom('TU_CORREO@gmail.com', 'INVIZA');
        $mail->addAddress($destinatario);

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = 'Recuperación de contraseña';
        $enlace = "http://3.133.88.30/inviza/restablecer.php?token=" . $token;
        $mail->Body = "Haz clic en el siguiente enlace para restablecer tu contraseña:<br><a href='$enlace'>$enlace</a>";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
?>
