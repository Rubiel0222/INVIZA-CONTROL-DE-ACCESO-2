<?php
// Conexión a la base de datos
$servername = "localhost";
$username   = "rubiel";
$password   = "abc123";
$dbname     = "inviza";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die(json_encode(["error" => "Error de conexión: " . $conn->connect_error]));
}

// Consultar visitantes
$visitantes = [];
$sql = "SELECT * FROM visitantes ORDER BY hora_ingreso DESC";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $visitantes[] = $row;
    }
}

// Estadísticas
$hoy = date("Y-m-d"); // ejemplo: 2026-02-06

$stmtHoy = $conn->prepare("SELECT COUNT(*) 
                           FROM visitantes 
                           WHERE DATE(fecha_ingreso) = ? 
                           AND hora_salida IS NULL");
$stmtHoy->bind_param("s", $hoy);
$stmtHoy->execute();
$stmtHoy->bind_result($totalHoy);
$stmtHoy->fetch();
$stmtHoy->close();

// Pendientes de días anteriores
$stmtPend = $conn->prepare("SELECT COUNT(*) FROM visitantes WHERE fecha_ingreso < ? AND hora_salida IS NULL");
$stmtPend->bind_param("s", $hoy);
$stmtPend->execute();
$stmtPend->bind_result($totalPend);
$stmtPend->fetch();
$stmtPend->close();

$conn->close();

// Devolver JSON con visitantes y estadísticas
echo json_encode([
    "visitantes" => $visitantes,
    "hoy" => $totalHoy,
    "pendientes" => $totalPend
]);
?>

