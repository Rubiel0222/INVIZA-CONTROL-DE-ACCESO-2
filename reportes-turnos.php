<?php


$servername = "localhost";
$username   = "rubiel";
$password   = "abc123";
$database   = "inviza";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
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


// Parámetros de paginación
$rowsPerPage = isset($_GET['rows']) ? (int)$_GET['rows'] : 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $rowsPerPage;

// Consulta con límite
$sql = "SELECT id_turno, turno, operador, ingreso, salida, fecha_inicio, fecha_fin, estado 
        FROM turnos 
        LIMIT $offset, $rowsPerPage";
$result = mysqli_query($conn, $sql);

// Total de registros para calcular páginas
$totalResult = mysqli_query($conn, "SELECT COUNT(*) AS total FROM turnos");
$totalRows = mysqli_fetch_assoc($totalResult)['total'];
$totalPages = ceil($totalRows / $rowsPerPage);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control de Accesos - Reportes > Turnos</title>
   <link rel="stylesheet" href="CSS/styles_reportes_turnos.css">
    <link rel="stylesheet" href="CSS/fontawesome.min.css">
    <link rel="stylesheet" href="CSS/slick-theme.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="CSS/templatemo.css">
<link rel="stylesheet" href="CSS/fontawesome.css">
<link rel="stylesheet" href="CSS/fontawesome.min.css">
<link rel="stylesheet" href="CSS/slick-theme.css">
<link rel="stylesheet" href="CSS/slick.min.css">
<link rel="stylesheet" href="CSS/templatemo.min.css">
    <script src="JS/reportes-turno.js" defer></script>
 <style>
body {
            font-family: 'Roboto', 'Open Sans', 'Lato', Arial, sans-serif;
            margin: 1px;
            padding:1px;
           background: url("IMAGENES/innovacion%20y%20%20seguridad.jpg") no-repeat center center fixed;
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
<body>

    <!-- Encabezado superior -->
    <div class="header">
        <img src="IMAGENES/logo_inviza.jpg" alt="Logo Inviza">
        <h1>Control de Accesos</h1>
        <div class="time">
            <span id="current-time"></span>
            <button onclick="window.location.href='pagina principal.php'">pagina Principal</button>
        </div>
    </div>

    <!-- Contenido principal -->
     <br><br><br><br>
<div class="main">
    <h2>REPORTES > TURNOS</h2>
<body>
        <!-- Contenedor de búsqueda -->
        <div class="search-container">
            <input type="text" id="searchInput" placeholder="Buscar...">
            <button class="add-record" onclick="window.location.href='crear_turno.php';">
                Agregar nuevo registro
            </button>
        </div>

        <!-- Tabla de turnos -->
        <div class="table-container">
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>Turno</th>
                        <th>Operador</th>
                        <th>Ingreso</th>
                        <th>Salida</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Fin</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="turnosTable">
                    <?php while($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?php echo $row['turno']; ?></td>
                            <td><?php echo $row['operador']; ?></td>
                            <td><?php echo $row['ingreso']; ?></td>
                            <td><?php echo $row['salida']; ?></td>
                            <td><?php echo $row['fecha_inicio']; ?></td>
                            <td><?php echo $row['fecha_fin']; ?></td>
                            <td><?php echo $row['estado']; ?></td>
                            <td>
                                <button class="btn-edit" onclick="editarfila(this)">Editar</button>
                                <button class="btn-delete" onclick="eliminarfila(this)">Borrar</button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <div class="pagination-container">
            <form method="GET" action="reportes-turnos.php">
                <label for="rows">Mostrar filas:</label>
                <select name="rows" id="rows">
                    <option value="10" <?php if($rowsPerPage==10) echo "selected"; ?>>10</option>
                    <option value="25" <?php if($rowsPerPage==25) echo "selected"; ?>>25</option>
                    <option value="50" <?php if($rowsPerPage==50) echo "selected"; ?>>50</option>
                </select>

                <label for="page">Página:</label>
                <select name="page" id="page">
                    <?php for($i=1; $i<=$totalPages; $i++) { ?>
                        <option value="<?php echo $i; ?>" <?php if($page==$i) echo "selected"; ?>>
                            <?php echo $i; ?>
                        </option>
                    <?php } ?>
                </select>

                <button class="btn-page" type="submit">Ir a página</button>
            </form>
        </div>
    </div>

    <script>
        // Búsqueda en tiempo real
        document.getElementById('searchInput').addEventListener('input', function() {
            const query = this.value.toLowerCase();
            const rows = document.querySelectorAll('#turnosTable tr');
            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                const rowData = Array.from(cells).map(cell => cell.textContent.toLowerCase());
                const matches = rowData.some(data => data.includes(query));
                row.style.display = matches ? '' : 'none';
            });
        });

        // Funciones de editar/borrar
        function editarfila(button) {
            const row = button.closest('tr');
            const cells = row.querySelectorAll('td:not(:last-child)');
            if (button.textContent === 'Editar') {
                cells.forEach(cell => {
                    const originalText = cell.textContent;
                    cell.innerHTML = `<input type="text" value="${originalText}">`;
                });
                button.textContent = 'Guardar';
            } else {
                cells.forEach(cell => {
                    const input = cell.querySelector('input');
                    cell.textContent = input.value;
                });
                button.textContent = 'Editar';
            }
        }

        function eliminarfila(button) {
            const row = button.closest('tr');
            row.remove();
        }
    </script>
    <footer>
        <!--inicio pie de página-->
        <br><br><br><br><br><br><br><br><br>
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
