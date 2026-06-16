<?php
$conn = new mysqli("localhost", "rubiel", "abc123", "inviza");
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

require __DIR__ . '/../vendor/autoload.php';

// Librerías
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Cargar FPDF desde la ruta real
require_once __DIR__ . '/../fpdf/fpdf.php';

if (!class_exists('FPDF')) {
    die("Error: FPDF no está cargado");
}


$data = json_decode(file_get_contents("php://input"), true);
$cedula = $data['cedula'];
$inicio = $data['fecha_inicial'];
$fin = $data['fecha_final'];
$formato = $data['formato'];
$tabla = $data['tabla']; // ahora recibimos la tabla desde el frontend

// Validar tabla permitida para evitar inyecciones SQL
$tablas_validas = ['funcionarios','visitantes','contratista','lista_negra'];
if (!in_array($tabla, $tablas_validas)) {
    echo 'Tabla no permitida';
    exit;
}

// Construir consulta dinámica
$sql = "SELECT documento AS cedula, nombres AS nombre, fecha_inicio, fecha_fin, 
               sucursales AS observaciones, zona AS motivo
        FROM $tabla
        WHERE documento = ? AND fecha_inicio BETWEEN ? AND ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$cedula, $inicio, $fin]);
$registros = $stmt->fetchAll();

// ================== EXCEL ==================
if ($formato === "excel") {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->fromArray(["Cédula","Nombre","Ingreso","Salida","Motivo","Observaciones"], NULL, "A1");

    $fila = 2;
    if (!empty($registros)) {
        foreach ($registros as $r) {
            $sheet->setCellValue("A$fila", $r['cedula']);
            $sheet->setCellValue("B$fila", $r['nombre']);
            $sheet->setCellValue("C$fila", $r['fecha_inicio']);
            $sheet->setCellValue("D$fila", $r['fecha_fin']);
            $sheet->setCellValue("E$fila", $r['motivo']);
            $sheet->setCellValue("F$fila", $r['observaciones']);
            $fila++;
        }
    } else {
        $sheet->setCellValue("A2", "No se encontraron registros para la cédula $cedula en el rango solicitado.");
    }

    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
    header("Content-Disposition: attachment; filename=informe_{$tabla}.xlsx");
    $writer = new Xlsx($spreadsheet);
    $writer->save("php://output");
    exit;
}

// ================== PDF ==================
if ($formato === "pdf") {
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont("Arial","",12);
    $pdf->Cell(190,10,"Informe de Movimientos - Tabla: $tabla",0,1,"C");
    $pdf->Ln(5);

    if (!empty($registros)) {
        foreach ($registros as $r) {
            $pdf->Cell(190,8,"Cédula: {$r['cedula']} | Nombre: {$r['nombre']}",0,1);
            $pdf->Cell(190,8,"Ingreso: {$r['fecha_inicio']} | Salida: {$r['fecha_fin']}",0,1);
            $pdf->Cell(190,8,"Motivo: {$r['motivo']} | Observaciones: {$r['observaciones']}",0,1);
            $pdf->Ln(5);
        }
    } else {
        $pdf->Cell(190,10,"No se encontraron registros para la cédula $cedula en el rango solicitado.",0,1,"C");
    }

    header("Content-Type: application/pdf");
    header("Content-Disposition: attachment; filename=informe_{$tabla}.pdf");

    echo $pdf->Output("S"); // "S" = devuelve el PDF como string binario
    exit;
}

echo 'Formato no válido';
?>



?>

