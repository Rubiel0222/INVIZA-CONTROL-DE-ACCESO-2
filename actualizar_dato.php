<?php

$servername = "localhost";
$username   = "rubiel";
$password   = "abc123";
$dbname     = "inviza";

// Conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST['id']); // seguridad: convertir a número
    $etiqueta = $conn->real_escape_string($_POST['etiqueta']);
    $tipo = $conn->real_escape_string($_POST['tipo']);
    $requerido = $conn->real_escape_string($_POST['requerido']);
    $estado = $conn->real_escape_string($_POST['estado']);
    $orden = intval($_POST['orden']);
    $en_impresion = $conn->real_escape_string($_POST['en_impresion']);

    // Consulta de actualización
    $sql = "UPDATE configuracion_datos 
            SET etiqueta='$etiqueta', tipo='$tipo', requerido='$requerido',
                estado='$estado', orden='$orden', en_impresion='$en_impresion'
            WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        // Redirige al listado para ver los cambios
        header("Location: configuración%20datos.php");
        exit();
    } else {
        echo "Error al actualizar: " . $conn->error;
    }
}

$conn->close();
?>

