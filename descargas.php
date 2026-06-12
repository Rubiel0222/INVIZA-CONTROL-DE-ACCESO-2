<?php
// Conexión a la base de datos
$conn = new mysqli("localhost", "rubiel", "abc123", "inviza");
if ($conn->connect_error) {
    die("❌ Conexión fallida: " . $conn->connect_error);
}

// Consulta de archivos
$sql = "SELECT * FROM archivos ORDER BY fecha_subida DESC";
$result = $conn->query($sql);
?>

<div class="container mt-4">
    <h1 class="mb-4">Ayuda > Descargas</h1>
    <div class="row">
        <?php while($row = $result->fetch_assoc()) { 
            $ruta = $row['ruta'];
        ?>
            <div class="col-md-4">
                <div class="card mb-3 shadow-sm">
                    <div class="card-body text-center">
                        <h5 class="card-title"><?php echo $row['nombre']; ?></h5>
                        <?php if (file_exists($ruta)) { ?>
                            <a href="<?php echo $ruta; ?>" download class="btn btn-primary btn-sm">
                                Descargar
                            </a>
                        <?php } else { ?>
                            <span class="text-danger">❌ Archivo no disponible</span>
                        <?php } ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    <a href="javascript:history.back()" class="btn btn-secondary mt-3">Regresar</a>
</div>

