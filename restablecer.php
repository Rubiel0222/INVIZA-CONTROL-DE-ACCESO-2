<?php
if (isset($_GET["token"])) {
    $token = $_GET["token"];

    $conn = new mysqli("localhost", "rubiel", "abc123", "inviza");
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Validar token en usuarios
    $stmt = $conn->prepare("SELECT id_usuario FROM usuarios WHERE token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $newPass = trim($_POST["password"]);
            if (!empty($newPass)) {
                $hash = password_hash($newPass, PASSWORD_DEFAULT);

                $stmtUpdate = $conn->prepare("UPDATE usuarios SET password = ?, token = NULL WHERE token = ?");
                $stmtUpdate->bind_param("ss", $hash, $token);
                $stmtUpdate->execute();

                echo "<p style='color:green;'>Tu contraseña ha sido restablecida correctamente.</p>";
                $stmtUpdate->close();
            } else {
                echo "<p style='color:red;'>La contraseña no puede estar vacía.</p>";
            }
        }
    } else {
        echo "<p style='color:red;'>El enlace de recuperación no es válido o ya fue usado.</p>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<p style='color:red;'>Token no proporcionado.</p>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Restablecer contraseña</title>
</head>
<body>
    <h2>Restablecer contraseña</h2>
    <form action="" method="POST">
        <label for="password">Nueva contraseña:</label>
        <input type="password" name="password" required>
        <button type="submit">Guardar</button>
    </form>
</body>
</html>
