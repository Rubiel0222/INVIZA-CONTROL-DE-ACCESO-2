<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: inicio_sesion.php");
    exit();
}
$tiempo_inactividad = 100; // 5 minutos en segundos

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
    <title>Agregar Nuevo Dato</title>
    <link rel="stylesheet" href="CSS/bootstrap.min.css">
    <link rel="stylesheet" href="CSS/styles_configuracion_datos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="css/slick-theme.css">
    <link rel="stylesheet" href="css/templatemo.css">
    <link rel="stylesheet" href="css/fontawesome.css">
    <link rel="stylesheet" href="css/fontawesome.min.css">
    <link rel="stylesheet" href="css/slick-theme.css">
    <link rel="stylesheet" href="css/slick.min.css">
    <link rel="stylesheet" href="CSS/templatemo.min.css">
    <script src="JS/pagina_principal.js" defer></script>
</head>
<body>
    <style>
  body {
    font-family: 'Roboto', 'Open Sans', 'Lato', Arial, sans-serif;
    margin: 0;
    padding: 0;
    background: url('IMAGENES/innovacion\ y\ \ seguridad.jpg') no-repeat center center fixed;
    background-size: cover;
   
}      
    </style>
<nav class="navbar navbar-expand-lg bg-dark navbar-light" id="templatemo_nav_top">
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
<header>
    <div class="logo editable">
        <img src="IMAGENES/logo_inviza.jpg" alt="Logo de INVIZA">
    </div>
    <div class="title editable">
        INVIZA CONTROL DE ACCESOS
    </div>
    <div class="actions">
           <div class="time" id="currentTime"></div>
        <button onclick="window.location.href='pagina_inicial.php'">Página Inicial</button>
            <button class="save-button" style="display: none;">Guardar</button>
    </div>
</header>
<body>

<div class="container mt-5">
    <h2 class="text-center mb-4">Agregar Nuevo Dato</h2>

    <form method="POST" action="guardar_dato.php" class="p-4 border rounded bg-white">
        <div class="mb-3">
            <label class="form-label">Etiqueta</label>
            <input type="text" name="etiqueta" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Tipo</label>
            <input type="text" name="tipo" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Requerido</label>
            <select name="requerido" class="form-select">
                <option value="Sí">Sí</option>
                <option value="No">No</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Estado</label>
            <select name="estado" class="form-select">
                <option value="Activo">Activo</option>
                <option value="Inactivo">Inactivo</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Orden</label>
            <input type="number" name="orden" class="form-control" min="1">
        </div>

        <div class="mb-3">
            <label class="form-label">En Impresión</label>
            <select name="en_impresion" class="form-select">
                <option value="Sí">Sí</option>
                <option value="No">No</option>
            </select>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-success">Guardar</button>
            <a href="configuracion_datos.php" class="btn btn-secondary">Cancelar</a>
        </div>
<!-- Script para la hora actual -->
<script>
    function updateTime() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        document.getElementById('currentTime').textContent = `${hours}:${minutes}`;
    }

    setInterval(updateTime, 1000);
    updateTime();
</script>
    </form>
</div>
<footer>
   <!--inicio pie pagina-->
   <br>
   <footer class="bg-dark text-light" id="templatemo_footer">
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
</footer>
</body>
</html>
