<?php
$servername = "localhost";
$username   = "rubiel";
$password   = "abc123";
$dbname     = "inviza";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); 

    $sql = "DELETE FROM configuracion_datos WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location:configuración%20datos.php");
        exit();
    } else {
        echo "❌ Error al eliminar: " . $conn->error;
    }
}

$conn->close();
?>

