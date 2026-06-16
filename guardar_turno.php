<?php


$servername = "localhost";
$username   = "rubiel";
$password   = "abc123";
$dbname     = "inviza";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $turno = $_POST['turno'];
    $operador = $_POST['operador'];
    $ingreso = $_POST['ingreso'];
    $salida = $_POST['salida'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];

    $sql = "INSERT INTO turnos (turno, operador, ingreso, salida, fecha_inicio, fecha_fin, estado) 
            VALUES ('$turno', '$operador', '$ingreso', '$salida', '$fecha_inicio', '$fecha_fin', 'activo')";

    if (mysqli_query($conn, $sql)) {
        // ✅ Redirección automática al listado
        header("Location: reportes-turnos.php");
        exit();
    } else {
        echo "❌ Error: " . mysqli_error($conn);
    }

}
?>
