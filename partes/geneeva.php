<?php
include('conexion.php');
require('fpdf/fpdf.php');

// Fecha del día
$fecha = date('d/m/Y');

// Verifica si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $datos = $_POST;

    // Validación mínima
    if (!isset($datos['titulo'], $datos['materia'], $datos['profesor'], $datos['subtitulo'], $datos['actividades'])) {
        die("Faltan datos requeridos.");
    }

    // Crear carpeta para respaldos JSON
    if (!is_dir('datos')) {
        mkdir('datos', 0777, true);
    }

    $nombre_archivo = uniqid("evaluacion_") . ".json";
    file_put_contents("datos/$nombre_archivo", json_encode($datos, JSON_PRETTY_PRINT));

    // SUBIR LOGO
    $logo_path = '';
    if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);
        $logo_path = 'logos/' . uniqid('logo_') . '.' . $ext;

        if (!is_dir('logos')) {
            mkdir('logos', 0777, true);
        }

        move_uploaded_file($_FILES['logo']['tmp_name'], $logo_path);
    }

    // Generar el PDF
    $archivo_pdf = generarPDF($datos, $fecha, $logo_path);

    // Guardar en la base
    $fechaSQL = date('Y-m-d');
    $json = json_encode($datos, JSON_UNESCAPED_UNICODE);
    $profesor = $datos['profesor'];
    $nombreevalu = $datos['titulo'];

    $conexion->query("INSERT INTO `evaluaciones` (`id`, `fecha`, `datos`, `archivo_pdf`, `profesor`) 
    VALUES (NULL, '$fechaSQL', '$json', '$archivo_pdf', '$profesor')");

    echo "<script>alert('Evaluación generada exitosamente.');</script>";
}

function generarPDF($datos, $fecha, $logo_path = '') {
    $pdf = new FPDF();
    $pdf->AddPage();

    // Logo arriba a la derecha
    if ($logo_path && file_exists($logo_path)) {
        $pdf->Image($logo_path, 160, 10, 40); // Ajusta (x, y, width) si querés
    }

    // Título
    $pdf->SetFont('Arial','B',16);
    $pdf->Cell(0,10, utf8_decode($datos['titulo']), 0, 1, 'C');

    // Info
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(0,10, utf8_decode('Fecha: ' . $fecha), 0, 1);
    $pdf->Cell(0,10, utf8_decode('Materia: ' . $datos['materia']), 0, 1);
    $pdf->Cell(0,10, utf8_decode('Profesor: ' . $datos['profesor']), 0, 1);
    $pdf->Cell(0,10, utf8_decode('Temas: ' . $datos['temas']), 0, 1);
    $pdf->Cell(0,10, utf8_decode('Nombre completo del alumno:'), 0, 1);

    // Subtítulo
    $pdf->Ln(10);
    $pdf->SetFont('Arial','B',14);
    $pdf->Cell(0,10, utf8_decode($datos['subtitulo']), 0, 1, 'C');

    // Actividades
    $pdf->SetFont('Arial','',12);
    foreach ($datos['actividades'] as $i => $actividad) {
        $pdf->MultiCell(0,10, utf8_decode(($i+1) . ". " . $actividad));
        $pdf->Ln(2);
    }

    // Guardar PDF
    if (!is_dir('pdfs')) {
        mkdir('pdfs', 0777, true);
    }

    $nombre_pdf = 'pdfs/' . uniqid('evaluacion_'. $datos['titulo'] .'_') . '.pdf';
    $pdf->Output('F', $nombre_pdf);

    return $nombre_pdf;
}
?>
