<?php
$servername = "localhost";
$username   = "rubiel";
$password   = "abc123";
$dbname     = "inviza";

// Conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Inicio de sesión
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: inicio_sesion.php");
    exit();
}

// Tiempo máximo de inactividad (15 minutos)
$tiempo_inactividad = 900; // segundos

if (isset($_SESSION['ultimo_acceso'])) {
    $tiempo_transcurrido = time() - $_SESSION['ultimo_acceso'];
    if ($tiempo_transcurrido > $tiempo_inactividad) {
        session_unset();
        session_destroy();
        header("Location: inicio_sesion.php?expirado=1");
        exit();
    }
}

// Actualizar último acceso
$_SESSION['ultimo_acceso'] = time();


// Parámetros de paginación
$rowsPerPage = isset($_GET['rows']) ? (int)$_GET['rows'] : 10; // filas por página
$page        = isset($_GET['page']) ? (int)$_GET['page'] : 1;  // página actual
$offset      = ($page - 1) * $rowsPerPage;

// Consulta con límite (tabla configuracion_datos)
$sql = "SELECT id, etiqueta, tipo, requerido, estado, orden, en_impresion 
        FROM configuracion_datos 
        ORDER BY orden ASC 
        LIMIT $offset, $rowsPerPage";
$result = mysqli_query($conn, $sql);

// Total de registros para calcular páginas
$totalResult = mysqli_query($conn, "SELECT COUNT(*) AS total FROM configuracion_datos");
$totalRows   = mysqli_fetch_assoc($totalResult)['total'];
$totalPages  = ceil($totalRows / $rowsPerPage);


?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Módulo > Control de Ingreso y Configuración de Datos</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="css/slick-theme.css">
<link rel="stylesheet" href="css/templatemo.css">
<link rel="stylesheet" href="css/fontawesome.css">
<link rel="stylesheet" href="css/fontawesome.min.css">
<link rel="stylesheet" href="css/slick-theme.css">
<link rel="stylesheet" href="css/slick.min.css">
<link rel="stylesheet" href="CSS/templatemo.min.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="CSS/styles_configuracion_datos.css">
    <script src="JS/configuracion datos.js" defer></script>
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
    <!-- Encabezado superior -->
</header>
<nav class="text-light navbar navbar-expand-lg bg-dark navbar-light" id="templatemo_nav_top">
     
        <div class="w-1000 d-flex justify-content-between">
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
   </header>  
   <!-- Encabezado de la página -->
<header class="d-flex align-items-center justify-content-between p-3 bg-green-dark text-white">
    <div class="logo">
        <img src="IMAGENES/logo_inviza.jpg" alt="Logo de Inviza" style="width: 80px;">
    </div>
    <h1 class="title text-center flex-grow-1">Control de Accesos</h1>
    <div class="actions d-flex align-items-center">
        <div id="currentTime" class="time px-3"></div>
        <button class="btn btn-light" onclick="window.location.href='pagina principal.php'">pagina principal</button>
    </div>
</header>
<!-- Contenedor principal -->
<br><br><br><br>
<main class="container mt-5">
    <h2 class="text-center mb-4">Configuración > Datos</h2>

    <!-- Botón para agregar un nuevo dato -->
    <div class="text-end mb-3">
        <a href="nuevo_dato.php" class="btn btn-success">Agregar Dato</a>
    </div>
    <!-- Tabla de datos -->
    <table class="table table-striped table-bordered">
        <thead class="bg-success text-light">
            <tr>
                <th>ID</th>
                <th>Etiqueta</th>
                <th>Tipo</th>
                <th>Requerido</th>
                <th>Estado</th>
                <th>Orden</th>
                <th>En Impresión</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['etiqueta']; ?></td>
                <td><?php echo $row['tipo']; ?></td>
                <td><?php echo $row['requerido']; ?></td>
                <td><?php echo $row['estado']; ?></td>
                <td><?php echo $row['orden']; ?></td>
                <td><?php echo $row['en_impresion']; ?></td>
                <td>
                    <a href="editar_dato.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                    <a href="borrar_dato.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Borrar</a>
                </td>
            </tr>
            <?php } ?>

            <?php if (isset($_GET['msg']) && $_GET['msg'] == 'eliminado') { ?>
<div class="alert alert-success text-center">
    ✅ Registro eliminado correctamente
</div>
<?php } ?>

        </tbody>
    </table>

    <!-- Barra de control inferior -->
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mt-3">
        <input type="text" placeholder="Buscar..." class="form-control w-auto">

        <select class="form-select w-auto">
            <option value="5">Mostrar 5 filas</option>
            <option value="10">Mostrar 10 filas</option>
            <option value="20">Mostrar 20 filas</option>
        </select>

        <div>
            Página:
            <select class="form-select d-inline w-auto">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
            </select>
        </div>
    </div>
</main> 
 <footer>
        <!--inicio pie pagina-->
        <br><br><br><br><br>
        <footer class="text-light bg-dark" id="templatemo_footer">
                    <div class="col-md-4 pt-0">       
                    <h2 class="text-light bg-dark pb-3 light-logo">INVIZA control de acceso</h2>
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
                     <p class="text-left text-light"> 
                         Copyright &copy; 2024 - ProdArt | Diseñado por: Rubiel Quintero - David Andres Correa
                     </p>
                 </div>
             </div>
         </div>
     </footer>
   
    <!-- Script para mostrar la hora actual -->
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
</body>
</html>

