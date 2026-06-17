<?php
require '/var/www/html/inviza/conexion/conexion.php';

// Correo de prueba
$email = "rubielquintero0222@gmail.com";

// Generar token y expiración
$token  = bin2hex(random_bytes(32));
$expira = date("Y-m-d H:i:s", strtotime("+30 minutes"));

// Ejecutar UPDATE
$sql = "UPDATE usuarios SET token=?, token_expira=? WHERE correo=?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("❌ Error preparando consulta: " . $conn->error);
}

$stmt->bind_param("sss", $token, $expira, $email);

if ($stmt->execute()) {
    echo "✅ Token guardado. Filas afectadas: " . $stmt->affected_rows . "<br>";
    echo "Token: $token<br>";
    echo "Expira: $expira<br>";
} else {
    echo "❌ Error ejecutando UPDATE: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
