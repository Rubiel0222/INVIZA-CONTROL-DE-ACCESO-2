<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

echo "<pre>";
print_r($_POST);
echo "</pre>";
exit();


$servername = "localhost";
$username   = "rubiel";   // tu usuario de MySQL
$password   = "abc123";   // tu contraseña
$dbname     = "inviza";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("❌ Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $licencia = $conn->real_escape_string($_POST['licencia']);
    $rutaOperaciones = $conn->real_escape_string($_POST['rutaOperaciones']);
    $ingresoFormulario = $conn->real_escape_string($_POST['ingresoFormulario']);
    $salidaFacil = $conn->real_escape_string($_POST['salidaFacil']);
    $userObligatorio = $conn->real_escape_string($_POST['userObligatorio']);
    $tipoCarnetVisitantes = $conn->real_escape_string($_POST['tipoCarnetVisitantes']);
    $tipoCarnetInspeccion = $conn->real_escape_string($_POST['tipoCarnetInspeccion']);
    $detalleFuncionario = $conn->real_escape_string($_POST['detalleFuncionario']);
    $festivos = $conn->real_escape_string($_POST['festivos']);
    $horarioDiurno = $conn->real_escape_string($_POST['horarioDiurno']);
    $minutosHora = intval($_POST['minutosHora']);
    $maxHorasServicio = intval($_POST['maxHorasServicio']);
    $recordarCampoVisita = $conn->real_escape_string($_POST['recordarCampoVisita']); 
    $logoAplicativo = $conn->real_escape_string($_POST['logoAplicativo']);

    $sql = "UPDATE configuracion_variables 
            SET licencia='$licencia',
                rutaOperaciones='$rutaOperaciones',
                ingresoFormulario='$ingresoFormulario',
                salidaFacil='$salidaFacil',
                userObligatorio='$userObligatorio',
                tipoCarnetVisitantes='$tipoCarnetVisitantes',
                tipoCarnetInspeccion='$tipoCarnetInspeccion',
                detalleFuncionario='$detalleFuncionario',
                festivos='$festivos',
                horarioDiurno='$horarioDiurno',
                minutosHora='$minutosHora',
                maxHorasServicio='$maxHorasServicio',
                recordarCampoVisita='$recordarCampoVisita',
                logoAplicativo='$logoAplicativo'
            WHERE id=1"; // suponiendo que solo hay un registro
}

    if ($conn->query($sql) === TRUE) {
        header("Location: configuración-variables.php");
        exit();
    } else {
        echo "❌ Error al actualizar: " . $conn->error;
    }
}

$conn->close();
?>

