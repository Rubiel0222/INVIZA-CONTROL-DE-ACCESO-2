<?php
// Conexión a la base de datos
$servidor = "3.133.88.30";
$usuario = "rubiel";
$password = "abc123";
$basedatos = "inviza";

$conn = new mysqli($servidor, $usuario, $password, $basedatos);

// Validar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Captura y sanitización de datos del formulario
$nombre_apellido = isset($_POST["nombre_apellido"]) ? htmlspecialchars(trim($_POST["nombre_apellido"]), ENT_QUOTES, 'UTF-8') : null;
$email = isset($_POST["correo"]) ? htmlspecialchars(trim($_POST["correo"]), ENT_QUOTES, 'UTF-8') : null;
$usuario = isset($_POST["usuario"]) ? htmlspecialchars(trim($_POST["usuario"]), ENT_QUOTES, 'UTF-8') : null;
$password = isset($_POST["password"]) ? htmlspecialchars(trim($_POST["password"]), ENT_QUOTES, 'UTF-8') : null;

// Validación de campos obligatorios
if (empty($nombre_apellido) || empty($correo) || empty($usuario) || empty($password)) {
    die("Error: Todos los campos son obligatorios.");
}

// Validación de formato de correo
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Error: El correo electrónico no es válido.");
}

// Encriptar contraseña
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Preparar y ejecutar consulta
$stmt = $conn->prepare("INSERT INTO usuario (nombre_apellido, email, usuario, password) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $nombre_apellido, $correo, $usuario, $hashedPassword);

if ($stmt->execute()) {
    echo "Registro exitoso.";
} else {
    echo "Error al registrar: " . $stmt->error;
}

// Cerrar conexiones
$stmt->close();
$conn->close();
?>

