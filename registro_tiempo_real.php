<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: inicio_sesion.php");
    exit();
}

// Configuración de la conexión
$servername = "localhost";
$username   = "rubiel";
$password   = "abc123";
$dbname     = "inviza";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die(json_encode(["error" => "Error de conexión: " . $conn->connect_error]));
}

?>


<!DTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro tiempo real</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="CSS/slick-theme.css">
    <link rel="stylesheet" href="CSS/slick.min.css">
    <link rel="stylesheet" href="CSS/templatemo.min.css">
    <link rel="stylesheet" href="CSS/styles_registro_tiempo real.css">
    <script src="JS/rergistro_tiempo real.js"></script>


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
<body>
    <nav class="navbar navbar-expand-lg bg-dark navbar-light" id="templatemo_nav_top">
        <div class="w-100 d-flex justify-content-between">
            <span class="navbar-sa-brand text-light">infoINVIZA</span>
            <span class="text-light">3125843540</span>
            <div>
                <a class="text-light" href="https://fb.com/templatemo" target="_blank" rel="sponsored">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a class="text-light" href="https://www.instagram.com" target="_blank">
                    <i class="fab fa-instagram"></i>
                </a>
                <a class="text-light" href="https://www.twitter.com" target="_blank">
                    <i class="fab fa-twitter"></i>
                </a>
            </div>
        </div>
    </nav>
                   

    <!-- Encabezado principal -->
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
    <h1>Gestión de Visitantes en Tiempo Real</h1>

    <!-- Barra de búsqueda -->
    <div class="search-bar">
        <input type="text" id="search" placeholder="Buscar por número de documento o nombre">
        <button onclick="searchVisitor()">Buscar</button>
    </div>

    <!-- Estadísticas -->
    <div class="stats">
        <p id="total-visitors">Visitantes ingresados hoy: 0</p>
        <p id="pending-exit">Pendientes de días anteriores: 0</p>
    </div>

    <!-- Tabla de visitantes -->
    <table id="tablaVisitantes">
        <thead>
            <tr>
                <th>ID</th>
                <th>Foto</th>
                <th>Tipo Documento</th>
                <th>Número Documento</th>
                <th>Nombres y Apellidos</th>
                <th>Teléfono</th>
                <th>Vehículo</th>
                <th>Placa</th>
                <th>Visita a</th>
                <th>Hora Ingreso</th>
                <th>Hora Salida</th>
                <th>Fecha Ingreso</th>
                <th>Zona</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody id="visitantes-table">
            <!-- Los datos se cargarán aquí dinámicamente -->
        </tbody>
    </table>
</div>
</div>
<script>
  function updateTime() {
    const now = new Date();
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    document.getElementById('currentTime').textContent = `${hours}:${minutes}`;
  }

  setInterval(updateTime, 1000); // Actualiza cada segundo
  updateTime(); // Inicializa al cargar
</script>


</body>
    </div>
    <br> <br><br> <br><br> <br><br> <br><br> <br><br>
    <footer class="bg-dark" id="templatemo_footer">
        <div class="row">
            <div class="col-md-4">
                <h2 class="text-light">INVIZA control de acceso</h2>
                <div class=" text-light contact-info">
                    <p><i class="fas fa-map-marker-alt"></i> Local Principal - Madrid, Colombia</p>
                    <p><i class="fa fa-envelope"></i> contacto</p>
                    <p><i class="fa fa-phone"></i> 3125843540</p>
                </div>
            </div>
        </div>
        <div class="w-100 bg-dark py-3">
            <p class="text-light">
                Copyright &copy; 2024 - ProdArt | Diseñado por: Rubiel Quintero - David Andres Correa
            </p>
        </div>
    </footer>

