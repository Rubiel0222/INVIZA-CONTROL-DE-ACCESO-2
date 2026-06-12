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
    <title>Control de Accesos - Reportes > Movimientos de Vehículos</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="CSS/styles_reportes_movimientos_vehiculos.css">
    <link rel="stylesheet" href="CSS/fontawesome.min.css">
    <link rel="stylesheet" href="CSS/slick-theme.css">
    <link rel="stylesheet" href="CSS/templatemo.css">
    <link rel="stylesheet" href="CSS/fontawesome.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script src="JS/reportes movimientos vehiculos .js" defer></script>
    <style>
        body {
            font-family: 'Roboto', 'Open Sans', 'Lato', Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: url('IMAGENES/innovacion\ y\ \ seguridad.jpg') no-repeat center center fixed;
            background-size: cover;
        }
     
    </style>
</head>
</header>
<nav class="navbar navbar-expand-lg bg-dark navbar-light" id="templatemo_nav_top">
    <div class="container text-light">        
        <div class="w-1000 d-flex justify-content-between">
            <div>
                <i class="fa fa-envelope mx-2"></i>
                <a class="navbar-sa-brand text-light text-decoration-none" href="publicidad.html">infoINVIZA.com</a>
                <i class="fa fa-phone mx-2"></i>
                <a class="navbar-sa-brand text-light text-decoration-none" href="tel:3125843540">3125843540</a>
                <div class="social">
                                   
                    <a href="https://wa.me/3125843540" target="_blank" rel="noopener" aria-label="WhatsApp">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                
                    <a href="https://fb.com/templatemo" target="_blank" rel="noopener" aria-label="Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                
                    <a href="https://www.instagram.com" target="_blank" rel="noopener" aria-label="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                
                    <a href="https://www.twitter.com" target="_blank" rel="noopener" aria-label="Twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                </div>
                
                </div>
              </div>
        </div>
    </div>
</nav>
   </header>
<body>
    <!-- Encabezado superior -->
    <div class="header">
        <img src="IMAGENES/logo_inviza.jpg" alt="Logo Inviza.jpg">
        <h1>Control de Accesos</h1>
        <div class="time">
            <span id="current-time"></span>
            <button onclick="window.location.href='pagina_inicial.php'">Menú Principal</button>
        </div>
    </div>
    <!-- Sección principal -->
<div class="main">
    <div class="form-container">
        <h2>Reportes > Movimientos de Vehículos</h2>

        <form id="form-informe" method="POST" action="procesar-informes.php">

            <!-- Selección de tabla origen -->
            <div class="form-group">
                <label for="tabla">Tabla origen:</label>
                <select id="tabla" name="tabla" required>
                    <option value="">Seleccionar</option>
                    <option value="funcionarios">Funcionarios</option>
                    <option value="visitantes">Visitantes</option>
                    <option value="contratista">Contratistas</option>
                    <option value="lista_negra">Lista Negra</option>
                </select>
            </div>

            <!-- Fechas -->
            <div class="form-group">
                <label for="fecha_ingreso">Fecha ingreso:</label>
                <input type="datetime-local" id="fecha_ingreso" name="fecha_ingreso" required>
            </div>
            <div class="form-group">
                <label for="fecha_final">Fecha final:</label>
                <input type="datetime-local" id="fecha_final" name="fecha_final" required>
            </div>

            <!-- Placa -->
            <div class="form-group">
                <label for="placa">Placa:</label>
                <input type="text" id="placa" name="placa" placeholder="Placa del vehículo">
            </div>

            <!-- Formato de informe -->
            <div class="form-group">
                <label for="formato">Formato de Informe:</label>
                <select id="formato" name="formato" required>
                    <option value="">Seleccionar</option>
                    <option value="excel">Excel</option>
                    <option value="pdf">PDF</option>
                </select>
            </div>

            <!-- Botón -->
            <div class="button-group">
                <button type="submit">Generar Informe</button>
            </div>
        </form>
    </div>
</div>


    <!-- Pie de página -->
    <footer class="bg-dark" id="templatemo_footer" style="margin-top: 30px;">
        <div class="container text-light">
            <div class="row">
                <div class="col-md-4 pt-0">
                    <h2 class="text-light bg-dark pb-3 light-logo">INVIZA Control de Acceso</h2>
                    <div class="contact-info">
                        <div class="contact-item">
                            <i class="fas fa-map-marker-alt fa-fw"></i> Local Principal - Madrid, Colombia
                        </div>
                        <div class="contact-item">
                            <i class="fa fa-envelope mx-2"></i>
                            <a class="navbar-sa-brand text-light text-decoration-none" href="mailto:INVIZA@gmail.com">
                                contacto: INVIZA@gmail.com
                            </a>
                        </div>
                        <div class="contact-item">
                            <i class="fa fa-phone mx-2"></i>
                            <a class="navbar-sa-brand text-light text-decoration-none" href="tel:3125843540">
                                3125843540
                            </a>
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
