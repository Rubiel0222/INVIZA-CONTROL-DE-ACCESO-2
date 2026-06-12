<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: inicio_sesion.php");
    exit();
}

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_contratista     = $_POST['id_contratista'];
    $nombre_contratista = $_POST['nombre_contratista'];
    $id_empresa         = $_POST['id_empresa'];
    $estado             = $_POST['estado'];
    $seguridad_social   = $_POST['seguridad_social']; // ahora es 0 o 1

    // Preparar consulta segura
    $stmt = $conexion->prepare("INSERT INTO contratista 
        (id_contratista, nombre_contratista, id_empresa, estado, seguridad_social) 
        VALUES (?, ?, ?, ?, ?)");

    // Tipos: id_contratista (int), nombre (string), empresa (string), estado (string), seguridad_social (int)
    $stmt->bind_param("isssi",
        $id_contratista,
        $nombre_contratista,
        $id_empresa,
        $estado,
        $seguridad_social
    );

    if ($stmt->execute()) {
        $_SESSION['mensaje_exito'] = "✅ Contratista registrado correctamente";
        header("Location: contratista.php");
        exit();
    } else {
        echo "❌ Error en la consulta: " . $stmt->error;
    }

    $stmt->close();
    $conexion->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INVIZA Control de Accesos</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="CSS/styles_contratista.css">
    <link rel="stylesheet" href="css/fontawesome.min.css">
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
            <button class="save-button" style="display: none;" onclick="window.location.href='contratistas-creación y edición.php'">Guardar</button>

    </div>
</header>

<body>
    <div class="form-container">
        <h2>Registro de Contratistas</h2>
        <form action="guardar_contratista.php" method="post">
            <label for="id_contratista">ID Contratista:</label>
            <input type="text" id="id_contratista" name="id_contratista" required>

            <label for="nombre_contratista">Nombre Contratista:</label>
            <input type="text" id="nombre_contratista" name="nombre_contratista" required>

            <label for="id_empresa">ID Empresa:</label>
            <input type="text" id="id_empresa" name="id_empresa" required>

            <label for="estado">Estado:</label>
            <select id="estado" name="estado">
                <option value="activo">Activo</option>
                <option value="inactivo">Inactivo</option>
            </select>

           <label for="seguridad_social">Seguridad Social:</label>
            <select id="seguridad_social" name="seguridad_social" required>
                <option value="1">Sí</option>
                <option value="0">No</option>
             </select>

            <div class="buttons">
                <button type="submit">Guardar</button>
                <button type="reset">Limpiar</button>
            </div>
        </form>
    </div>
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
