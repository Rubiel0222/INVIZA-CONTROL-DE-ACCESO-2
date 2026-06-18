<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '/var/www/html/inviza/vendor/autoload.php';
require '/var/www/html/inviza/conexion/conexion.php';

// Correo de prueba
$email = "rubielquintero0222@gmail.com";

// Generar token y expiración
$token  = bin2hex(random_bytes(32));
$expira = date("Y-m-d H:i:s", strtotime("+30 minutes"));

// Guardar token en la BD
$sql = "UPDATE usuarios SET token=?, token_expira=? WHERE correo=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $token, $expira, $email);

if ($stmt->execute() && $stmt->affected_rows > 0) {
    echo "✅ Token guardado correctamente.<br>";
} else {
    die("❌ Error al guardar token: " . $stmt->error);
}

// Crear enlace de recuperación
$enlace = "http://3.133.88.30/inviza/reset_password.php?token=$token";

// Configurar PHPMailer
$mail = new PHPMailer(true);
try {
    $mail->SMTPDebug  = 2; // Para ver detalles en el log
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'rubielquintero0222@gmail.com'; // tu Gmail
    $mail->Password   = 'fqux gpvr pfcl pmxt'; // contraseña de aplicación
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    $mail->setFrom('tu_correo@gmail.com', 'INVIZA');
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = 'Recuperación de contraseña INVIZA';
    $mail->Body    = "Haz clic en el siguiente enlace para restablecer tu contraseña:<br>
                      <a href='$enlace'>$enlace</a><br>
                      ⚠️ Este enlace expira en 30 minutos.";

    $mail->send();
    echo "📧 Correo enviado correctamente.";
} catch (Exception $e) {
    echo "⚠️ Error al enviar correo: {$mail->ErrorInfo}";
}
?>
