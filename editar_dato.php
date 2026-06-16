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

$id = $_GET['id']; // recibe el id desde el listado
 $sql = "SELECT * FROM configuracion_datos WHERE id=$id";
 $result = $conn->query($sql); $row = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Dato</title>
    <link rel="stylesheet" href="CSS/bootstrap.min.css">
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
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center mb-4">Editar Dato</h2>

    <form method="POST" action="actualizar_dato.php" class="p-4 border rounded bg-light">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

        <div class="mb-3">
            <label class="form-label">Etiqueta</label>
            <input type="text" name="etiqueta" class="form-control" value="<?php echo $row['etiqueta']; ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Tipo</label>
            <input type="text" name="tipo" class="form-control" value="<?php echo $row['tipo']; ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Requerido</label>
            <select name="requerido" class="form-select">
                <option value="Sí" <?php if($row['requerido']=="Sí") echo "selected"; ?>>Sí</option>
                <option value="No" <?php if($row['requerido']=="No") echo "selected"; ?>>No</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Estado</label>
            <select name="estado" class="form-select">
                <option value="Activo" <?php if($row['estado']=="Activo") echo "selected"; ?>>Activo</option>
                <option value="Inactivo" <?php if($row['estado']=="Inactivo") echo "selected"; ?>>Inactivo</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Orden</label>
            <input type="number" name="orden" class="form-control" value="<?php echo $row['orden']; ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">En Impresión</label>
            <select name="en_impresion" class="form-select">
                <option value="Sí" <?php if($row['en_impresion']=="Sí") echo "selected"; ?>>Sí</option>
                <option value="No" <?php if($row['en_impresion']=="No") echo "selected"; ?>>No</option>
            </select>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="configuracion_datos.php" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
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
</body>
</html>
