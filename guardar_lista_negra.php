<?php
$conexion = new mysqli("localhost", "rubiel", "abc123", "inviza");
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_usuario    = $_POST['id_usuario'] ?? null;
    $documento     = $_POST['documento'] ?? '';
    $nombres       = $_POST['nombres'] ?? '';
    $apellidos     = $_POST['apellidos'] ?? '';
    $tipo          = $_POST['tipo'] ?? '';
    $motivo        = $_POST['observaciones'] ?? ''; // tu formulario usa "observaciones"
    $estado        = $_POST['estado'] ?? '';
    $fecha         = date('Y-m-d H:i:s');

    $query = "INSERT INTO lista_negra 
        (id_usuario, documento, nombres, apellidos, tipo, motivo, fecha_registro, ESTADO) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conexion->prepare($query);
    if (!$stmt) {
        die("Error al preparar la consulta: " . $conexion->error);
    }

    $stmt->bind_param("isssssss", $id_usuario, $documento, $nombres, $apellidos, $tipo, $motivo, $fecha, $estado);

    if ($stmt->execute()) {
        header("Location:lista negra-creacion y edición.php");
        exit();
    } else {
        echo "❌ Error al guardar: " . $stmt->error;
    }

    $stmt->close();
}
$conexion->close();
?>
