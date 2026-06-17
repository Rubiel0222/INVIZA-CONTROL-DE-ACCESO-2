<?php
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
            echo "<p style='color:green;'>Se ha enviado un enlace de recuperación a tu correo.</p>";
            // Aquí se invoca procesar_recuperacion.php para generar token y enviar correo
            // Ejemplo: include 'procesar_recuperacion.php';
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
    <title>Recuperar contraseña</title>
</head>
<body>
    <h2>Recuperar contraseña</h2>
    <form action="recuperar_contrasena.php" method="POST">
        <label for="email">Correo electrónico:</label>
        <input type="email" name="email" required>
        <button type="submit">Recuperar</button>
    </form>
</body>
</html>

