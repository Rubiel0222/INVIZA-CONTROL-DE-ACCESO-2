<?php
// Mostrar errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: inicio_sesion.php");
    exit();
}

$tiempo_inactividad = 300;
if (isset($_SESSION['ultimo_acceso'])) {
    $tiempo_transcurrido = time() - $_SESSION['ultimo_acceso'];
    if ($tiempo_transcurrido > $tiempo_inactividad) {
        session_unset();
        session_destroy();
        header("Location: inicio_sesion.php?expirado=1");
        exit();
    }
}
$_SESSION['ultimo_acceso'] = time();

include 'conexion/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipo_documento   = $_POST['tipo_documento'];
    $numero_documento = $_POST['numero_documento'];
    $nombres_apellidos= $_POST['nombres_apellidos'];
    $telefono         = $_POST['telefono'];
    $vehiculo         = $_POST['vehiculo'];
    $placa            = $_POST['placa'];
    $visita_a         = $_POST['visita_a'];
    $id_zona          = $_POST['id_zona'];
    $foto             = isset($_POST['foto']) ? $_POST['foto'] : null;

    $hora_ingreso = date("Y-m-d H:i:s"); // DATETIME completo

    // Preparar consulta segura
    $stmt = $conn->prepare("INSERT INTO visitantes 
        (tipo_documento, numero_documento, nombres_apellidos, telefono, vehiculo, placa, visita_a, foto, hora_ingreso, id_zona) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Vincular parámetros (10 en total)
    $stmt->bind_param(
        "sssssssssi",
        $tipo_documento,
        $numero_documento,
        $nombres_apellidos,
        $telefono,
        $vehiculo,
        $placa,
        $visita_a,
        $foto,
        $hora_ingreso,
        $id_zona
    );

    if ($stmt->execute()) {
        $_SESSION['mensaje_exito'] = "✅ Registro exitoso";
        header("Location: modulo-control de ingreso.php");
        exit();
    } else {
        echo "❌ Error en la consulta: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Módulo > Control de Ingreso</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="CSS/slick-theme.css">
<link rel="stylesheet" href="CSS/templatemo.css">
<link rel="stylesheet" href="CSS/fontawesome.css">
<link rel="stylesheet" href="CSS/fontawesome.min.css">
<link rel="stylesheet" href="CSS/slick.min.css">
<link rel="stylesheet" href="CSS/templatemo.min.css">
<link rel="stylesheet" href="CSS/styles_modulo_control de ingreso.css">
<script src="JS/modulo_control_de_ingreso.js" defer></script>
</head>
<style>
    body {
font-family: 'Roboto', 'Open Sans', 'Lato', Arial, sans-serif;
margin: 0;
padding: 0;
background: url('IMAGENES/innovacion\ y\ \ seguridad.jpg') no-repeat center center fixed;
background-size: cover;
    }
</style>
<body>
    <nav class="navbar navbar-expand-lg bg-dark navbar-light" id="templatemo_nav_top">
        <div class="container text-light">
        <div class="w-d-flex justify-content-between">
                    <i class="fa fa-envelope mx-2"></i>
                    <a class="navbar-sa-brand text-light text-decoration-none" href="publicidad.html">infoINVIZA.com</a>
                    <i class="fa fa-phone mx-2"></i>
                    <a class="navbar-sa-brand text-light text-decoration-none" href="tel:3125843540">3125843540</a>
                    <a class="text-light" href="https://fb.com/templatemo" target="_blank" rel="sponsored">
                            <i class="fab fa-facebook-f fa-sm fa-fw me-2"></i>
                        </a>
                        <a class="text-light" href="https://www.instagram.com" target="_blank">
                            <i class="fab fa-instagram fa-sm fa-fw me-2"></i>
                        </a>
                        <a class="text-light" href="https://www.twitter.com" target="_blank">
                            <i class="fab fa-twitter fa-sm fa-fw me-2"></i>
                        </a>
            </div>                                                                                                    
        </div>
    </nav>                                                                     
    <!-- Encabezado principal con logo, título y acciones -->
    <header>
        <div class="logo">
            <img src="IMAGENES/logo_inviza.jpg" alt="Logo de Inviza">
        </div>
        <div class="title editable">
            INVIZA CONTROL DE ACCESOS
        </div>
        <div class="actions">
        <div class="time" id="currentTime"></div>
            <button onclick="window.location.href='pagina_inicial.php'">Página Inicial</button>
           
        </div>
    </header>
<div class="container">
        <div class="form-container">
            <form action="modulo-control de ingreso.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="documentType">Documento</label>
                    <select id="documentType" name="tipo_documento" required>
                        <option value="cc">Cédula de Ciudadanía</option>
                        <option value="ti">Tarjeta de Identidad</option>
                        <option value="ce">Cédula de Extranjería</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="documentNumber">Número de Documento</label>
                    <input type="text" id="documentNumber" name="numero_documento" placeholder="Ingrese el número de documento" required>
                </div>
                <div class="form-group">
                    <label for="fullName">Nombres y Apellidos</label>
                    <input type="text" id="fullName" name="nombres_apellidos" placeholder="Ingrese los nombres y apellidos" required>
                </div>
                <div class="form-group">
                    <label for="phone">Teléfono</label>
                    <input type="text" id="phone" name="telefono" placeholder="Ingrese el número de teléfono">
                </div>
                <div class="form-group">
                    <label for="vehicle">Vehículo</label>
                    <select id="vehicle" name="vehiculo">
                        <option value="carro">Carro</option>
                        <option value="moto">Moto</option>
                        <option value="bicicleta">Bicicleta</option>
                        <option value="ninguno">Ninguno</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="placa">placa</label>
                   <input type="text" id="placa" name="placa" placeholder="Ingrese la placa">

                </div>
                <div class="form-group">
                    <label for="visita">Visita a</label>
                    <input type="text" id="visita" name="visita_a" placeholder="Ingrese la persona o lugar de visita">

                </div>
                <div class="form-group">
                    <label for="zona">Zona</label>
                    <select id="zona" name="id_zona">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                    </select>
                </div>
                    <div class="form-footer">
                    <button type="submit">Ingresar</button>
                    <button type="reset">Limpiar</button>
                   <button type="button" onclick="window.location.href='registro_tiempo_real.php';">Visitantes</button>
                    <button type="button" onclick="window.location.href='funcionarios.php';">Funcionarios</button>
                    <button type="button" onclick="window.location.href='contratistas-creación y edición.php';">Contratistas</button>
                </div>
            </form>
        </div>
        <div class="photo-container">
            <video id="video" autoplay></video>
            <img id="photoPreview" alt="Foto Capturada" style="display: none;">
            <button type="button" id="captureButton">Tomar Foto</button>
            <input type="hidden" id="photoData" name="foto">
        </div>
    </div>   
<script>
document.addEventListener('DOMContentLoaded', function () {
    // 🕒 Actualizar la Hora Actual
    function updateTime() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const currentTimeElement = document.getElementById('currentTime');
        if (currentTimeElement) {
            currentTimeElement.textContent = `${hours}:${minutes}`;
        }
    }
    setInterval(updateTime, 1000);
    updateTime();

    // 📷 Activar cámara y capturar foto
    const video = document.getElementById('video');
    const photoPreview = document.getElementById('photoPreview');
    const captureButton = document.getElementById('captureButton');
    const photoData = document.getElementById('photoData');

    navigator.mediaDevices.getUserMedia({ video: true })
        .then(stream => {
            video.srcObject = stream;
        })
        .catch(error => {
            console.error("Error al acceder a la cámara:", error);
        });

    captureButton.addEventListener('click', () => {
        const canvas = document.createElement('canvas');
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        canvas.getContext('2d').drawImage(video, 0, 0);

        const imageData = canvas.toDataURL('image/png');
        photoPreview.src = imageData;
        photoPreview.style.display = 'block';
        photoData.value = imageData;
    });
});
</script>



<footer>
    <!--inicio pie pagina-->
    <br>
    <footer class="bg-dark" id="templatemo_footer">
     <div class="container text-light">
         <div class="row">
             <div class="col-md-4 pt-0">       
                 <h2 class="text-light bg-dark pb-3 light-logo">INVIZA control de acceso</h2>
                 <div class="contact-info">
                     <div class="contact-item">
                         <i class="fas fa-map-marker-alt fa-fw"></i>
                         Local Principal - Madrid, Colombia
                     </div>
                     <div class="contact-item">
                         <i class="fa fa-envelope mx-2"></i>
                         <a class="navbar-sa-brand text-light text-decoration-none" href="publicidad.html">contacto: INVIZA@gmail.com</a>
                     </div>
                     <div class="contact-item">
                         <i class="fa fa-phone mx-2"></i>
                         <a class="navbar-sa-brand text-light text-decoration-none" href="tel:3125843540">3125843540</a>
                     </div>
                 </div>
     </div>
     </div>
     </div>
     <div class="w-100 bg-dark py-3"> 
     <div class="row pt-2"> 
    <p class="text-left text-light"> 
                     Copyright &copy; 2024 - ProdArt | Diseñado por: Rubiel Quintero - David Andres Correa
                 </p>
             </div>
         </div>
     </div>
 </footer>      
</body>
</html>
