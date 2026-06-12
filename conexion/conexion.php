<?php
$servername = "localhost";
$username   = "rubiel";
$password   = "abc123";
$database   = "inviza";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

?>
