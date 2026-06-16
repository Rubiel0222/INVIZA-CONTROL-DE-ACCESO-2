<?php
// Importar PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '/var/www/html/inviza/vendor/autoload.php';

// Conexión a la base de datos
$conn = new mysqli("localhost", "rubiel", "abc123", "inviza");
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Capturar correo del formulario
$email = $_POST['email'] ?? null;
if (!$email) {
    die("Debe ingresar un correo válido.");
}

// Validar si el correo existe en la tabla usuarios
$sql = "SELECT * FROM usuarios WHERE correo = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Generar token único
    $token = bin2hex(random_bytes(50));

    // Actualizar token en la tabla
    $update = $conn->prepare("UPDATE usuarios SET token=? WHERE correo=?");
    if ($update === false) {
        die("Error preparando UPDATE: " . $conn->error);
    }
    $update->bind_param("ss", $token, $email);

    if ($update->execute()) {
        if ($update->affected_rows > 0) {
            echo "✅ Token generado y guardado: $token<br>";
        } else {
            echo "❌ No se actualizó ningún registro. Verifica el correo ingresado.<br>";
        }
    } else {
        die("Error ejecutando UPDATE: " . $update->error);
    }

    // Crear enlace de recuperación
    $enlace = "http://3.133.88.30/inviza/reset_password.php?token=$token";

    // Configurar PHPMailer
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Servidor SMTP
        $mail->SMTPAuth = true;
        $mail->Username = 'tu_correo@gmail.com'; // tu correo
        $mail->Password = 'TU_CONTRASEÑA_DE_APLICACIÓN'; // clave de aplicación
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Configuración del correo
        $mail->setFrom('tu_correo@gmail.com', 'INVIZA');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Recuperación de contraseña';
        $mail->Body    = "Haz clic en el siguiente enlace para restablecer tu contraseña: <a href='$enlace'>$enlace</a>";

        $mail->send();
        echo "📧 Se envió un enlace de recuperación a su correo.";
    } catch (Exception $e) {
        echo "⚠️ Error al enviar correo: {$mail->ErrorInfo}. Token generado: $token";
    }
} else {
    echo "❌ Correo no registrado en el sistema.";
}
?>

