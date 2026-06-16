<?php
// Conexión a la base de datos
$conn = new mysqli("localhost", "rubiel", "abcd123", "inviza");
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Capturar token desde el enlace
$token = $_GET['token'] ?? null;
if (!$token) {
    die("Token inválido o no proporcionado.");
}

// Si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nueva = $_POST['nueva'] ?? null;
    if (!$nueva) {
        die("Debe ingresar una nueva contraseña.");
    }

    // Encriptar la nueva contraseña
    $hash = password_hash($nueva, PASSWORD_DEFAULT);

    // Actualizar contraseña en la base de datos
    $sql = "UPDATE usuarios SET password=?, token=NULL WHERE token=?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }
    $stmt->bind_param("ss", $hash, $token);
    if ($stmt->execute() && $stmt->affected_rows > 0) {
        // Redirigir al login después de éxito
        header("Location: inicio_sesion.php?reset=success");
        exit();
    } else {
        echo "<p style='color:red;'>Error: token inválido o ya utilizado.</p>";
    }
}
?>

<!-- Formulario HTML para ingresar nueva contraseña -->
<form method="POST">
    <label>Nueva contraseña:</label>
    <input type="password" name="nueva" required>
    <button type="submit">Actualizar</button>
</form>

