<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"]);

    if (!empty($email)) {
        $conn = new mysqli("localhost", "rubiel", "abc123", "inviza");

        if ($conn->connect_error) {
            die("Error de conexión: " . $conn->connect_error);
        }

        // Usamos 'correo' en lugar de 'email'
        $stmt = $conn->prepare("SELECT id_usuario FROM usuarios WHERE correo = ?");
        if (!$stmt) {
            die("Error en la consulta: " . $conn->error);
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            echo "<p style='color:green;'>Se ha enviado un enlace de recuperación a tu correo.</p>";
            // Aquí iría la lógica para enviar el correo con token de recuperación
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

