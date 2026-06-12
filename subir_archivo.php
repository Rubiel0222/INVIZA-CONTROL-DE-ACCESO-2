<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username   = "rubiel";  
$password   = "abc123";      
$dbname     = "inviza";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("❌ Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["archivo"])) {
    $nombre = $_FILES["archivo"]["name"];
    $ruta   = "uploads/" . basename($nombre); // carpeta donde se guardan
    $tipo   = pathinfo($nombre, PATHINFO_EXTENSION);

    // Crear carpeta uploads si no existe
    if (!is_dir("uploads")) {
        mkdir("uploads", 0777, true);
    }

    // mover archivo al servidor
    if (move_uploaded_file($_FILES["archivo"]["tmp_name"], $ruta)) {
        $sql = "INSERT INTO archivos (nombre, ruta, tipo) VALUES ('$nombre', '$ruta', '$tipo')";
        if ($conn->query($sql) === TRUE) {
            // ✅ Redirigir automáticamente a configuracion_general.php
            header("Location: configuracion_general.php");
            exit();
        } else {
            echo "❌ Error al registrar en BD: " . $conn->error;
        }
    } else {
        echo "❌ Error al subir el archivo.";
    }
}
$conn->close();
?>

