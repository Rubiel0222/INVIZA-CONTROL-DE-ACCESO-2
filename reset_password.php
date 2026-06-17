<?php
require '/var/www/html/inviza/conexion/conexion.php';

$token = $_GET['token'] ?? null;
if (!$token) {
    die("<p style='color:red;'>❌ Token inválido o no proporcionado.</p>");
}

// Buscar token en la base de datos
$stmt = $conn->prepare("SELECT id_usuario, token_expira FROM usuarios WHERE token=?");
if ($stmt === false) {
    die("❌ Error preparando SELECT: " . $conn->error);
}
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    // Verificar expiración
    if (strtotime($row['token_expira']) < time()) {
        die("<p style='color:red;'>⚠️ El enlace ha expirado.</p>");
    }

    // Procesar nueva contraseña
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $nueva = trim($_POST['nueva'] ?? '');
        if (empty($nueva)) {
            die("<p style='color:red;'>❌ Debe ingresar una nueva contraseña.</p>");
        }

        // Encriptar la nueva contraseña
        $hash = password_hash($nueva, PASSWORD_DEFAULT);

        // Actualizar contraseña e invalidar token
        $sql_update = "UPDATE usuarios SET password=?, token=NULL, token_expira=NULL WHERE id_usuario=?";
        $stmt_update = $conn->prepare($sql_update);
        if ($stmt_update === false) {
            die("❌ Error preparando UPDATE: " . $conn->error);
        }
        $stmt_update->bind_param("si", $hash, $row['id_usuario']);

        if ($stmt_update->execute()) {
            echo "<p style='color:green;'>✅ Contraseña actualizada correctamente.</p>";
        } else {
            echo "<p style='color:red;'>❌ Error al actualizar contraseña: " . $conn->error . "</p>";
        }
    } else {
        // Mostrar formulario
        echo '<form method="POST">
                <label>Nueva contraseña:</label>
                <input type="password" name="nueva" required>
                <button type="submit">Actualizar</button>
              </form>';
    }
} else {
    die("<p style='color:red;'>❌ Token no válido.</p>");
}
?>

