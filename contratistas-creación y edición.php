<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: inicio_sesion.php");
    exit();
}$tiempo_inactividad = 900; // 15 minutos en segundos

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
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Módulo > Control de Ingreso</title>
    <link rel="stylesheet" href="CSS/styles_contratistas_creacion_edicion.css">
    <link rel="stylesheet" href="css/styles_registro_tiempo real.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="css/slick-theme.css">
<link rel="stylesheet" href="css/templatemo.css">
<link rel="stylesheet" href="css/fontawesome.css">
<link rel="stylesheet" href="css/fontawesome.min.css">
<link rel="stylesheet" href="css/slick-theme.css">
<link rel="stylesheet" href="css/slick.min.css">
<link rel="stylesheet" href="CSS/templatemo.min.css">
    <script src="JS/contratista-1.js" defer></script>
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
</style>
<nav class="text-light navbar navbar-expand-lg bg-dark navbar-light" id="templatemo_nav_top">
        <div class="w-d-flex justify-content-between">
                <i class="fa fa-envelope mx-2"></i>
                <a class="navbar-sa-brand text-light text-decoration-none" href="publicidad.html">infoINVIZA.com</a>
                <i class="fa fa-phone mx-2"></i>
                <a class="navbar-sa-brand text-light text-decoration-none" href="tel:3125843540">3125843540</a>
            </div>
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
        </div>                                                                                                
        </div>
</nav>
<body>

    <!-- Encabezado de la interfaz -->
     
    <header>
        <div class="logo">
            <img src="IMAGENES/logo_inviza.jpg" alt="Logo de Inviza">
        </div>
        <div class="title">
            Control de Accesos
        </div>
        <div class="actions">
            <div class="time" id="currentTime">
                <!-- La hora actual se insertará aquí con JavaScript -->
            </div>
            <button onclick="window.location.href='pagina principal.php'">Página Principal</button>
        </div>
    </header>
   <body>

     <div class="container">
        <h2>Contratistas > Creación y Edición</h2>

        <div class="table-header">
            <div class="search">
                <input type="text" placeholder="Buscar..." id="searchInput">
                <button onclick="searchFunction()">🔍</button>
            </div>
            <button class="add-button" onclick="window.location.href='contratista.php'">Agregar Nuevo Registro</button>
        </div>

        <table class="contratista-table">
            <thead>
                <tr>
                    <th>id contratista</th>
                    <th>nombre contratista</th>
                    <th>id Empresa</th>
                    <th>Estado</th>
                    <th>Seguridad Social</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="contratista-table">
                <!-- Datos insertados dinámicamente -->
            </tbody>
        </table>

    </div>
</body>
    
    <footer>
        <!--inicio pie pagina-->
        <br><br><br>  
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
                             <a class="navbar-sa-brand text-light text-decoration-none" href="publicidad.html">contacto: INVIZA@gmail.com
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
