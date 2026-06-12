<?php
header('Content-Type: application/json');
http_response_code(200);
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// Conexión a la base de datos
$conexion = new mysqli('localhost', 'rubiel', 'abc123', 'inviza');
if ($conexion->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Conexión fallida']);
    exit;
}

// Captura de datos JSON
$input = json_decode(file_get_contents("php://input"), true);
$usuario = htmlspecialchars(trim($input['nombre_usuario'] ?? ''), ENT_QUOTES, 'UTF-8');
$contrasena = htmlspecialchars(trim($input['password'] ?? ''), ENT_QUOTES, 'UTF-8');

// Validación básica
if (empty($usuario) || empty($contrasena)) {
    echo json_encode(['status' => 'error', 'message' => 'Usuario y contraseña son obligatorios.']);
    exit;
}

// Consulta en base de datos
$sql = "SELECT * FROM usuarios WHERE nombre_usuario = ? AND password = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("ss", $usuario, $contrasena);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 1) {
    $_SESSION['usuario'] = $usuario;
    echo json_encode(['status' => 'success', 'message' => 'Inicio de sesión exitoso']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Credenciales incorrectas']);
}
?>
