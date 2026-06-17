<?php
// Datos de conexión
$servername = "localhost";
$username   = "rubiel";
$password   = "abc123";
$database   = "inviza";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("❌ Conexión fallida: " . $conn->connect_error);
}

// Configurar charset para evitar problemas con acentos y caracteres especiales
$conn->set_charset("utf8mb4");
?>

