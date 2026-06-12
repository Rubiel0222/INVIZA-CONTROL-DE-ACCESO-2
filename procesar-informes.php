<?php
$servername = "localhost";
$username   = "rubiel";
$password   = "abc123";
$dbname     = "inviza";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

require __DIR__ . '/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fecha_ingreso = $_POST['fecha_ingreso'] ?? null;
    $fecha_final   = $_POST['fecha_final']   ?? null;
    $cedula        = $_POST['cedula']        ?? null;
    $placa         = $_POST['placa']         ?? null;
    $tabla         = $_POST['tabla']         ?? null;
    $formato       = $_POST['formato']       ?? "excel";

    if (empty($fecha_ingreso) || empty($fecha_final) || empty($tabla)) {
        die("Debes ingresar fechas y seleccionar una tabla.");
    }

    if ($formato === "excel") {
        generarInformeExcel($conn, $fecha_ingreso, $fecha_final, $cedula, $placa, $tabla);
    } elseif ($formato === "pdf") {
        generarInformePDF($conn, $fecha_ingreso, $fecha_final, $cedula, $placa, $tabla);
    }
    $conn->close();
}

function generarConsulta($tabla, $fecha_ingreso, $fecha_final, $cedula, $placa) {
    switch ($tabla) {
        case 'visitantes':
            $query = "SELECT fecha_ingreso, hora_ingreso AS fecha_final, visita_a AS empresa, id_zona AS sucursal, numero_documento, placa 
                      FROM visitantes 
                      WHERE fecha_ingreso >= ? AND fecha_ingreso <= ?";
            $params = [$fecha_ingreso, $fecha_final];
            $types  = "ss";
            if (!empty($cedula)) { $query .= " AND numero_documento = ?"; $params[] = $cedula; $types .= "s"; }
            if (!empty($placa))  { $query .= " AND placa = ?"; $params[] = $placa; $types .= "s"; }
            break;

        case 'funcionarios':
            $query = "SELECT fecha_ingreso, fecha_final, empresa, sucursal, numero_documento, '' AS placa 
                      FROM funcionarios 
                      WHERE fecha_ingreso >= ? AND fecha_final <= ?";
            $params = [$fecha_ingreso, $fecha_final];
            $types  = "ss";
            if (!empty($cedula)) { $query .= " AND numero_documento = ?"; $params[] = $cedula; $types .= "s"; }
            break;

        case 'contratista':
            $query = "SELECT fecha_ingreso, fecha_final, empresa, sucursal, numero_documento, '' AS placa 
                      FROM contratista 
                      WHERE fecha_ingreso >= ? AND fecha_final <= ?";
            $params = [$fecha_ingreso, $fecha_final];
            $types  = "ss";
            if (!empty($cedula)) { $query .= " AND numero_documento = ?"; $params[] = $cedula; $types .= "s"; }
            break;

        case 'lista_negra':
            $query = "SELECT fecha_ingreso, fecha_final, motivo AS empresa, sucursal, numero_documento, '' AS placa 
                      FROM lista_negra 
                      WHERE fecha_ingreso >= ? AND fecha_final <= ?";
            $params = [$fecha_ingreso, $fecha_final];
            $types  = "ss";
            if (!empty($cedula)) { $query .= " AND numero_documento = ?"; $params[] = $cedula; $types .= "s"; }
            break;

        default:
            die("Tabla no válida");
    }

    return [$query, $params, $types];
}

function generarInformeExcel($conn, $fecha_ingreso, $fecha_final, $cedula, $placa, $tabla) {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Encabezados
    $headers = ['Fecha ingreso','Fecha final','Empresa','Sucursal','Documento','Placa'];
    $col = 'A';
    foreach ($headers as $header) {
        $sheet->setCellValue($col.'1', $header);
        $col++;
    }

    // Consulta dinámica
    list($query, $params, $types) = generarConsulta($tabla, $fecha_ingreso, $fecha_final, $cedula, $placa);
    $stmt = $conn->prepare($query);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();

    // Llenar datos
    $rowIndex = 2;
    while ($row = $result->fetch_assoc()) {
        $sheet->setCellValue('A'.$rowIndex, $row['fecha_ingreso']);
        $sheet->setCellValue('B'.$rowIndex, $row['fecha_final']);
        $sheet->setCellValue('C'.$rowIndex, $row['empresa']);
        $sheet->setCellValue('D'.$rowIndex, $row['sucursal']);
        $sheet->setCellValue('E'.$rowIndex, $row['numero_documento']);
        $sheet->setCellValue('F'.$rowIndex, $row['placa']);
        $rowIndex++;
    }

    // Descargar archivo
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="reporte.xlsx"');
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
}

function generarInformePDF($conn, $fecha_ingreso, $fecha_final, $cedula, $placa, $tabla) {
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 12);

    $pdf->Cell(30, 10, 'Ingreso');
    $pdf->Cell(30, 10, 'Final');
    $pdf->Cell(40, 10, 'Empresa');
    $pdf->Cell(30, 10, 'Sucursal');
    $pdf->Cell(40, 10, 'Documento');
    $pdf->Cell(30, 10, 'Placa');
    $pdf->Ln();

    list($query, $params, $types) = generarConsulta($tabla, $fecha_ingreso, $fecha_final, $cedula, $placa);
    $stmt = $conn->prepare($query);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(30, 10, $row['fecha_ingreso']);
        $pdf->Cell(30, 10, $row['fecha_final']);
        $pdf->Cell(40, 10, $row['empresa']);
        $pdf->Cell(30, 10, $row['sucursal']);
        $pdf->Cell(40, 10, $row['numero_documento']);
        $pdf->Cell(30, 10, $row['placa']);
        $pdf->Ln();
    }

    $pdf->Output('D', 'reporte.pdf');
    exit;
}
?>

