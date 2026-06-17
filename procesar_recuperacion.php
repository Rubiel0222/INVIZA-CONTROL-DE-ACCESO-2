<?php
// Importar PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '/var/www/html/inviza/vendor/autoload.php';
require 'conexion.php'; // archivo de conexión seguro

// Capturar correo del formulario
$email = $_POST['email'] ?? null;
if (!$email) {
    die("❌ Debe ingresar un correo válido.");
}

// Validar si el correo existe en la tabla usuarios
$sql = "SELECT id FROM usuarios WHERE correo = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Generar token único y fecha de expiración
    $token  = bin2hex(random_bytes(32));
    $expira = date("Y-m-d H:i:s", strtotime("+30 minutes"));

    // Actualizar token y expiración en la tabla
    $update = $conn->prepare("UPDATE usuarios SET token=?, token_expira=? WHERE correo=?");
    if ($update === false) {
        die("❌ Error preparando UPDATE: " . $conn->error);
    }
    $update->bind_param("sss", $token, $expira, $email);

    if ($update->execute() && $update->affected_rows > 0) {
        echo "✅ Token generado y guardado correctamente.<br>";
    } else {
        die("❌ No se actualizó ningún registro. Verifica el correo ingresado.");
    }

    // Crear enlace de recuperación
    $enlace = "http://3.133.88.30/inviza/reset_password.php?token=$token";

    // Configurar PHPMailer
    $mail = new PHPMailer(true);
    try {
        $mail->SMTPDebug  = 2;
        $mail->Debugoutput = 'error_log';
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; 
        $mail->SMTPAuth   = true;
        $mail->Username   = 'tu_correo@gmail.com'; 
        $mail->Password   = 'TU_CONTRASEÑA_DE_APLICACIÓN'; 
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // Configuración del correo
        $mail->setFrom('tu_correo@gmail.com', 'INVIZA');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Recuperación de contraseña';
        $mail->Body    = "Haz clic en el siguiente enlace para restablecer tu contraseña:<br>
                          <a href='$enlace'>$enlace</a><br>
                          ⚠️ Este enlace expira en 30 minutos.";

        $mail->send();
        echo "📧 Se envió un enlace de recuperación a su correo.";
    } catch (Exception $e) {
        echo "⚠️ Error al enviar correo: {$mail->ErrorInfo}. Token generado: $token";
    }
} else {
    echo "❌ Correo no registrado en el sistema.";
}
?>

