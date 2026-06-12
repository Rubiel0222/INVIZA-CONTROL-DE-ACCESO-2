<?php

$servername = "3.133.88.30";
$username   = "rubiel";
$password   = "abc123";
$dbname     = "inviza";

// Activar reporte de errores de mysqli
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname);
    $conn->set_charset("utf8mb4"); // Establecer charset seguro

    echo "✅ Conexión exitosa a la base de datos";
} catch (mysqli_sql_exception $e) {
    // Registrar error en log y mostrar mensaje genérico
    error_log("Error de conexión: " . $e->getMessage());
   }
?>
