<?php
session_start();


// Conexión a la base de datos
$servername = "localhost";
$username = "rubiel";
$password = "abc123";
$database = "inviza";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    $_SESSION['mensaje_error'] = "❌ Error en la conexión: " . $conn->connect_error;
    header("Location: contratistas-creación y edición.php");
    exit();
}

// Validar que se recibió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Captura de datos
    $id_contratista     = $_POST['id_contratista'] ?? '';
    $nombre_contratista = $_POST['nombre_contratista'] ?? '';
    $id_empresa         = $_POST['id_empresa'] ?? '';
    $estado             = $_POST['estado'] ?? '';
    $seguridad_social   = $_POST['seguridad_social'] ?? '';

    // Validación básica
    if (
        empty(trim($id_contratista)) ||
        empty(trim($nombre_contratista)) ||
        empty(trim($id_empresa)) ||
        empty(trim($estado)) ||
        !isset($seguridad_social)
    ) {
        $_SESSION['mensaje_error'] = "❌ Todos los campos son obligatorios.";
        header("Location: contratistas-creación y edición.php");
        exit();
    }

    // Preparar consulta segura
    $sql = "INSERT INTO contratista (id_contratista, nombre_contratista, id_empresa, estado, seguridad_social) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        $_SESSION['mensaje_error'] = "❌ Error en la preparación de la consulta: " . $conn->error;
        header("Location: contratistas-creación y edición.php");
        exit();
    }

    // Vincular parámetros
    $stmt->bind_param("isssi", $id_contratista, $nombre_contratista, $id_empresa, $estado, $seguridad_social);

    // Ejecutar y redirigir
    if ($stmt->execute()) {
        $_SESSION['mensaje_exito'] = "✅ Contratista registrado correctamente.";
    } else {
        $_SESSION['mensaje_error'] = "❌ Error al guardar: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

    // Redirigir a la página de edición
    header("Location: contratistas-creación y edición.php");
    exit();
}
?>
