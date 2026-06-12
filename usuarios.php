<?php
// Encabezado para respuesta JSON
header('Content-Type: application/json');

// Parámetros de conexión
$servername = "localhost";
$username   = "rubiel";
$password   = "abc123";
$dbname     = "inviza";

// Conexión a la base de datos
$conexion = new mysqli($servername, $username, $password, $dbname);
if ($conexion->connect_error) {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => "Conexión fallida: " . $conexion->connect_error
    ]);
    exit;
}

// Captura y sanitización de datos
$documento      = htmlspecialchars($_POST['documento'] ?? '', ENT_QUOTES, 'UTF-8');
$nombre_usuario = htmlspecialchars($_POST['nombre_usuario'] ?? '', ENT_QUOTES, 'UTF-8');
$telefono        = htmlspecialchars($_POST['telefono'] ?? '', ENT_QUOTES, 'UTF-8');
$correo          = htmlspecialchars($_POST['correo'] ?? '', ENT_QUOTES, 'UTF-8');
$rol             = htmlspecialchars($_POST['rol'] ?? '', ENT_QUOTES, 'UTF-8');
$password        = htmlspecialchars($_POST['password'] ?? '', ENT_QUOTES, 'UTF-8');

// Validación de campos obligatorios
if (empty($documento) || empty($nombre_usuario) || empty($correo) || empty($telefono) || empty($rol) || empty($password)) {
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "Todos los campos son obligatorios."
    ]);
    exit;
}

// Validación de formato de correo
if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "Correo electrónico no válido."
    ]);
    exit;
}

// Validación de duplicados
$verificar = $conexion->prepare("SELECT id_usuario FROM usuarios WHERE documento = ? OR correo = ?");
$verificar->bind_param("ss", $documento, $correo);
$verificar->execute();
$verificar->store_result();

if ($verificar->num_rows > 0) {
    http_response_code(409);
    echo json_encode([
        "status" => "error",
        "message" => "El documento o correo ya están registrados."
    ]);
    $verificar->close();
    exit;
}
$verificar->close();

// Encriptación de contraseña
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Inserción en la base de datos
$stmt = $conexion->prepare("INSERT INTO usuarios (nombre_usuario, documento, correo, telefono, rol, password) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $nombre_usuario, $documento, $correo, $telefono, $rol, $hashedPassword);

if ($stmt->execute()) {
    echo json_encode([
        "status" => "success",
        "message" => "Registro exitoso."
    ]);

    // Bitácora opcional
    file_put_contents("registro_log.txt", date("Y-m-d H:i:s") . " - Registro de usuario: $documento\n", FILE_APPEND);

} else {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => "Error al registrar: " . $stmt->error
    ]);
}

$stmt->close();
$conexion->close();
?>

