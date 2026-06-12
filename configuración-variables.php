<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
}




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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="css/fontawesome.min.css">
 <link rel="stylesheet" href="css/slick-theme.css">
 <link rel="stylesheet" href="css/templatemo.css">
 <link rel="stylesheet" href="css/fontawesome.css">
 <link rel="stylesheet" href="css/fontawesome.min.css">
 <link rel="stylesheet" href="css/slick-theme.css">
 <link rel="stylesheet" href="css/slick.min.css">
 <link rel="stylesheet" href="CSS/templatemo.min.css">
    <link rel="stylesheet" href="CSS/styles_configuracion_variables.css">
    <script src="JS/configuracion_variable.js" defer></script>
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
              
            <div class="w-d-flex justify-content-between">
                    <i class="fa fa-envelope mx-2"></i>
                    <a class="navbar-sa-brand text-light text-decoration-none" href="publicidad.html">infoINVIZA<a>
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
    
    </nav>
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
            <button onclick="window.location.href='pagina_inicial.php'">Menú Principal</button>
        </div>
    </header>
    <div class="container">
    <h2 class="section-title">Configuración > Variables</h2>
    <p class="note">Nota: cualquier cambio en las variables puede afectar el sistema en su funcionamiento.</p>

    <!-- Formulario de ingreso de datos -->
<form id="dataForm" method="POST" action="actualizar_variables.php" class="p-4 shadow">

    <label for="licencia">Licencia:</label>
    <input type="text" id="licencia" name="licencia" required>

    <label for="rutaOperaciones">Ruta operaciones:</label>
    <input type="text" id="rutaOperaciones" name="rutaOperaciones" required>

    <label for="ingresoFormulario">Ingreso formulario:</label>
    <select id="ingresoFormulario" name="ingresoFormulario">
        <option value="si">Sí</option>
        <option value="no">No</option>
    </select>

    <label for="salidaFacil">Salida fácil de los visitantes:</label>
    <select id="salidaFacil" name="salidaFacil">
        <option value="si">Sí</option>
        <option value="no">No</option>
    </select>

    <label for="userObligatorio">User obligatorio:</label>
    <select id="userObligatorio" name="userObligatorio">
        <option value="si">Sí</option>
        <option value="no">No</option>
    </select>

    <label for="tipoCarnetVisitantes">Tipo carnet visitantes:</label>
    <select id="tipoCarnetVisitantes" name="tipoCarnetVisitantes">
        <option value="vertical">Vertical</option>
        <option value="horizontal">Horizontal</option>
    </select>

    <label for="tipoCarnetInspeccion">Tipo carnet inspección:</label>
    <select id="tipoCarnetInspeccion" name="tipoCarnetInspeccion">
        <option value="vertical">Vertical</option>
        <option value="horizontal">Horizontal</option>
    </select>

    <label for="detalleFuncionario">Detalle funcionario:</label>
    <select id="detalleFuncionario" name="detalleFuncionario">
        <option value="si">Sí</option>
        <option value="no">No</option>
    </select>

    <label for="festivos">Festivos:</label>
    <input type="date" id="festivos" name="festivos" required>

    <label for="horarioDiurno">Horario diurno:</label>
    <input type="text" id="horarioDiurno" name="horarioDiurno" required>

    <label for="minutosHora">Minutos para que se considere una hora:</label>
    <input type="text" id="minutosHora" name="minutosHora" required>

    <label for="maxHorasServicio">Máxima de horas por registro:</label>
    <input type="text" id="maxHorasServicio" name="maxHorasServicio" required>

    <label for="recordarCampoVisita">Recordar campo visita:</label>
    <input type="file" id="recordarCampoVisita" name="recordarCampoVisita">

    <label for="logoAplicativo">Logo aplicativo:</label>
    <select id="logoAplicativo" name="logoAplicativo">
        <option value="activar">Activar</option>
        <option value="desactivar">Desactivar</option>
    </select>

    <div class="buttons mt-3">
        <button type="submit" class="btn btn-success">Guardar Información</button>
        <button type="button" class="btn btn-secondary" onclick="window.location.href='pagina_principal.php'">Regresar</button>
    </div>
</form>
</div>

    <!-- Script para mostrar la hora actual -->
    <script>
        // Función para actualizar la hora actual
        function updateTime() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            document.getElementById('currentTime').textContent = `${hours}:${minutes}`;
        }
        setInterval(updateTime, 1000); // Actualiza cada segundo
        updateTime(); // Llama la función al cargar la página
    </script>
    <!-- Pie de página -->
    <footer>
        <!--inicio pie pagina-->
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
             <div class="container"> 
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

