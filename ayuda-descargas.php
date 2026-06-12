<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

session_start();

// ✅ Verificación de sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: inicio_sesion.php");
    exit();
}

// ✅ Control de tiempo de inactividad (15 minutos)
$tiempo_inactividad = 900; // 15 minutos en segundos
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

// ✅ Procesar formulario si se envió por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
}

// ✅ Conexión a la base de datos (ejemplo)
$servername = "localhost";
$username   = "rubiel";  
$password   = "abc123";      
$dbname     = "inviza";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("❌ Conexión fallida: " . $conn->connect_error);
}


$conn->close();
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ayuda > Descargas</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="CSS/styles_ayuda_descargas.css">
    <link rel="stylesheet" href="CSS/fontawesome.min.css">
    <link rel="stylesheet" href="CSS/fontawesome.min.css">
<link rel="stylesheet" href="CSS/slick-theme.css">
<link rel="stylesheet" href="CSS/templatemo.css">
<link rel="stylesheet" href="CSS/fontawesome.css">
<link rel="stylesheet" href="CSS/fontawesome.min.css">
<link rel="stylesheet" href="CSS/slick-theme.css">
<link rel="stylesheet" href="CSS/slick.min.css">
<link rel="stylesheet" href="CSS/templatemo.min.css">
    <script src="JS/ayuda.js" defer></script>
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
    <!-- Barra de navegación -->
        <nav class="navbar navbar-expand-lg bg-dark navbar-light" id="templatemo_nav_top">
                   <div class="contact-info text-light">
                <i class="fa fa-envelope mx-2"></i>
                <a class="navbar-sa-brand text-light text-decoration-none" href="publicidad.html">infoINVIZA.com</a>
                <i class="fa fa-phone mx-2"></i>
                <a class="navbar-sa-brand text-light text-decoration-none" href="tel:3125843540">3125843540</a>
            </div>
            <div class="social-icons">
                <a class="text-light mx-2" href="https://fb.com/templatemo" target="_blank" rel="sponsored">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a class="text-light mx-2" href="https://www.instagram.com" target="_blank">
                    <i class="fab fa-instagram"></i>
                </a>
                <a class="text-light mx-2" href="https://www.twitter.com" target="_blank">
                    <i class="fab fa-twitter"></i>
                </a>
            </div>
        </div>
    </nav>

    <!-- Contenido principal -->
    <br><br><br><br><br><br><br>
    <div class="container">
        <h1>Ayuda > Descargas</h1>
        <ul>
            <li><a href="ruta_descarga/windows.exe" download>Windows - Descargar</a></li>
            <li><a href="ruta_descarga/java.exe" download>Java - Descargar</a></li>
            <li><a href="ruta_descarga/rte_huellero.exe" download>RTE Huellero - Descargar</a></li>
            <li><a href="ruta_descarga/rte_update.exe" download>RTE Update - Descargar</a></li>
            <li><a href="/inviza/uploads/Manual_Tecnico_INVIZA.pdf" download>Manual Administrativo - Descargar</a></li>
          <li><a href="/inviza/uploads/Manual_Usuario_INVIZA.pdf" download>Manual Operativo - Descargar</a></li>


        </ul>
        <a href="javascript:history.back()" class="back-btn">Regresar</a>
    </div>

    <!-- Pie de página -->
    <br><br><br><br>
    <footer class=" text-light bg-dark" id="templatemo_footer">
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
    <Footer>            
 <body>
</html>

