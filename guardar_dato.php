<?php
$servername = "localhost";
$username   = "rubiel";
$password   = "abc123";
$dbname     = "inviza";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$etiqueta     = $_POST['etiqueta'];
$tipo         = $_POST['tipo'];
$requerido    = $_POST['requerido'];
$estado       = $_POST['estado'];
$orden        = $_POST['orden'];
$en_impresion = $_POST['en_impresion'];

$sql = "INSERT INTO configuracion_datos (etiqueta, tipo, requerido, estado, orden, en_impresion)
        VALUES ('$etiqueta','$tipo','$requerido','$estado','$orden','$en_impresion')";

if (mysqli_query($conn, $sql)) {
    header("Location: configuración datos.php");
} else {
    echo "❌ Error al guardar: " . mysqli_error($conn);
}
?>
