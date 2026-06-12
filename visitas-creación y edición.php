<?php
session_start();

// Verificar sesión activa
if (!isset($_SESSION['usuario'])) {
    header("Location: inicio_sesion.php");
    exit();
}

// Control de inactividad (15 minutos)
$tiempo_inactividad = 900;
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

// Conexión a la base de datos
$conexion = new mysqli("localhost", "rubiel", "abc123", "inviza");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Consultar registros de visitas
$resultado = $conexion->query("SELECT * FROM visitas ORDER BY fecha_ingreso DESC");

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INVIZA Control de Accesos</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
   <link rel="stylesheet" href="CSS/styles_visitas_edicion_1.css">
    <link rel="stylesheet" href="css/fontawesome.min.css">
    <link rel="stylesheet" href="css/slick-theme.css">
    <link rel="stylesheet" href="css/templatemo.css">
    <link rel="stylesheet" href="css/fontawesome.css">
    <link rel="stylesheet" href="css/fontawesome.min.css">
    <link rel="stylesheet" href="css/slick-theme.css">
    <link rel="stylesheet" href="css/slick.min.css">
    <link rel="stylesheet" href="CSS/templatemo.min.css">
   <script src="JS/visitas-creacion y edicion.js" defer></script>
</head>
<body>
   
    <script>
        function updateTime() {
            const now = new Date();
            document.getElementById("current-time").textContent = now.toLocaleTimeString();
        }
        setInterval(updateTime, 1000);
    </script>
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
    <div class="container text-light">        
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
<body> <!-- Encabezado superior --> <div class="header"> <img src="IMAGENES/logo_inviza.jpg" alt="Logo Inviza"> <h1>Control de Accesos</h1> <div class="time"> <span id="current-time"></span> <button onclick="window.location.href='pagina principal.php'">Página Principal</button> </div> </div>

    <!-- Contenido principal -->
    <div class="main">
        <h2>Visitas > Creación y edición</h2>

        <div class="table-container">
            <!-- Búsqueda y paginación -->
            <div class="search-container">
                <input type="text" placeholder="Buscar...">
               
                <select id="page">
                    <option value="1">Página 1</option>
                    <option value="2">Página 2</option>
                    <option value="3">Página 3</option>
                </select>
                <button class="add-record" onclick="window.location.href='visitas-creación y edición-edición.php';">
                    Agregar nuevo registro
                </button>
            </div>

<!-- Tabla dinámica -->
<table>
    <thead>
        <tr>
            <th>Documento</th>
            <th>Nombres</th>
            <th>Apellidos</th>
            <th>Fecha Ingreso</th>
            <th>Fecha Fin</th>
            <th>Estado</th>
            <th>ARL</th>
            <th>Ingresos</th>
            <th>Empresa Origen</th>
            <th>Placa</th>
            <th>ID Zona</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($resultado->num_rows > 0): ?>
            <?php while ($row = $resultado->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['documento'] ?></td>
                    <td><?= $row['nombres'] ?></td>
                    <td><?= $row['apellidos'] ?></td>
                    <td><?= $row['fecha_ingreso'] ?></td>
                    <td><?= $row['fecha_fin'] ?></td>
                    <td><?= $row['estado_visita'] ?></td>
                    <td><?= $row['arl_checkbox'] == 1 ? 'Sí' : 'No' ?></td>
                    <td><?= $row['ingresos'] ?? '—' ?></td>
                    <td><?= $row['empresa_origen'] ?? '—' ?></td>
                    <td><?= $row['placa'] ?? '—' ?></td>
                    <td><?= $row['id_zona'] ?></td>
                    <td>
                        <button class="edit-button">Editar</button>
                        <button class="delete-button">Borrar</button>
                        <button class="movements-button">Movimientos</button>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="12">No hay visitas registradas</td></tr>
        <?php endif; ?>
    </tbody>
</table>


            <!-- Paginación -->
            <div class="pagination-container">
                <div>
                    <label for="rows">Mostrar filas:</label>
                    <select id="rows">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                </div>
                <div>
                    <button onclick="irPagina()">Ir a página</button>
                </div>
            </div>
        </div>
    </div>
<?php $conexion->close(); ?>

    <footer>
        <!--inicio pie de página-->
        <br><br><br><br><br><br><br>
        <footer class="bg-dark" id="templatemo_footer">
            <div class="container text-light">
                <div class="row">
                    <div class="col-md-4 pt-0">
                        <h2 class="text-light bg-dark pb-3 light-logo">INVIZA control de acceso</h2>
                        <p>
                            <i class="fas fa-map-marker-alt fa-fw"></i>
                            Local Principal - Madrid, Colombia
                        </p>
                        <p>
                            <i class="fa fa-envelope mx-2"></i>
                            <a class="navbar-sa-brand text-light text-decoration-none" href="publicidad.html">contacto: INVIZA@gmail.com</a>
                        </p>
                        <p>
                            <i class="fa fa-phone mx-2"></i>
                            <a class="navbar-sa-brand text-light text-decoration-none" href="tel:3125843540">3125843540</a>
                        </p>
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

































































































