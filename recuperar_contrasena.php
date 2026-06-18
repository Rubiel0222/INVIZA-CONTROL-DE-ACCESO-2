<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/conexion/conexion.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"]);

    if (!empty($email)) {
        // Validar si el correo existe en la tabla usuarios
        $stmt = $conn->prepare("SELECT id_usuario FROM usuarios WHERE correo = ?");
        if (!$stmt) {
            die("❌ Error en la consulta: " . $conn->error);
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Generar token y expiración
            $token  = bin2hex(random_bytes(32));
            $expira = date("Y-m-d H:i:s", strtotime("+30 minutes"));

            // Guardar token en la BD
            $sql_update = "UPDATE usuarios SET token=?, token_expira=? WHERE correo=?";
            $stmt_update = $conn->prepare($sql_update);
            if (!$stmt_update) {
                die("❌ Error preparando UPDATE: " . $conn->error);
            }
            $stmt_update->bind_param("sss", $token, $expira, $email);

            if ($stmt_update->execute() && $stmt_update->affected_rows > 0) {
                // Crear enlace de recuperación
                $enlace = "http://3.133.88.30/inviza/reset_password.php?token=$token";

                // Configurar PHPMailer
                $mail = new PHPMailer(true);
                try {
                    $mail->isSMTP();
                    $mail->Host       = 'smtp.gmail.com';
                    $mail->SMTPAuth   = true;
                    $mail->Username   = 'rubielquintero0222@gmail.com'; // tu Gmail
                    $mail->Password   = 'fqux gpvr pfcl pmxt'; // clave de 16 caracteres
                    $mail->SMTPSecure = 'tls';
                    $mail->Port       = 587;

                    $mail->setFrom('rubielquintero0222@gmail.com', 'INVIZA');
                    $mail->addAddress($email);

                    $mail->isHTML(true);
                    $mail->Subject = 'Recuperación de contraseña INVIZA';
                    $mail->Body    = "Haz clic en el siguiente enlace para restablecer tu contraseña:<br>
                                      <a href='$enlace'>$enlace</a><br>
                                      ⚠️ Este enlace expira en 30 minutos.";

                    $mail->send();
                    echo "<p style='color:green;'>✅ Se ha enviado un enlace de recuperación a tu correo.</p>";
                } catch (Exception $e) {
                    echo "<p style='color:red;'>⚠️ Error al enviar correo: {$mail->ErrorInfo}</p>";
                }
            } else {
                echo "<p style='color:red;'>❌ Error al guardar token.</p>";
            }
        } else {
            echo "<p style='color:red;'>El correo no está registrado en el sistema.</p>";
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "<p style='color:red;'>Por favor ingresa un correo válido.</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RECUPERAR CONTRASEÑA</title>
    <link rel="icon" href="IMAGENES/favicon.icon" type="image/x-icon">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="CSS/templatemo.css">
<link rel="stylesheet" href="CSS/fontawesome.css">
<link rel="stylesheet" href="CSS/fontawesome.min.css">
<link rel="stylesheet" href="CSS/slick-theme.css">
<link rel="stylesheet" href="CSS/slick.min.css">
<link rel="stylesheet" href="CSS/templatemo.min.css">
<link rel="stylesheet" href="CSS/styles_recuperar_contraseña.css">
    <script src="JS/inicio_sescion.js" defer></script>
</head>
<style>
    body {
font-family: 'Roboto', 'Open Sans', 'Lato', Arial, sans-serif;
margin: 0;
padding: 0;
background: url('IMAGENES/innovacion\ y\ \ seguridad.jpg') no-repeat center center fixed;
background-size: cover;
    }
 
</style>
</header>
<nav class="navbar navbar-expand-lg bg-dark text-light" id="templatemo_nav_top">
    <div class="container d-flex justify-content-between align-items-center">
            <div>
                <i class="fa fa-envelope mx-2"></i>
                <a class="navbar-sa-brand text-light text-decoration-none" href="publicidad.html">infoINVIZA.com</a>
                <i class="fa fa-phone mx-2"></i>
                <a class="navbar-sa-brand text-light text-decoration-none" href="tel:3125843540">3125843540</a>
            </div>
                    <a class="text-light" href="https://fb.com/templatemo" target="_blank" rel="sponsored">
                        <i class="fab fa-facebook-f fa-sm fa-fw me-2"></i>
                    </a>
                    <a class="text-light" href="https://www.instagram.com" target="_blank">
                        <i class="fab fa-instagram fa-sm fa-fw me-2"></i>
                    </a>
                    <a class="text-light" href="https://www.twitter.com" target="_blank">
                        <i class="fab fa-twitter fa-sm fa-fw me-2"></i>
                    </a>
                </div>
              </div>
        </div>
    </div>
</nav>
   </header>
<body>

    <!-- Encabezado -->
    <header>
        <div class="logo">
            <img src="IMAGENES/logo_inviza.jpg" alt="Logo de INVIZA,jpg">
        </div>
        <div class="title">
            INVIZA CONTROL DE ACCESOS
        </div>

        <div class="actions">

            <div class="time" id="currentTime"></div>

        </div>

    </header> 
<br><br><br><br><br><br><br><br><br><br><br><br>
    <div class="container">
        <h2>Recuperar contraseña</h2>
        <form action="recuperar_contrasena.php" method="POST">
            <label for="email">Correo electrónico:</label>
            <input type="email" name="email" required>
            <button type="submit">Recuperar</button>
        </form>
    </div>
</body>

</html>

