<?php
require('vendor/setasign/fpdf/fpdf.php');
session_start();
include_once("db_connection.php");

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: loginpage.php");
    exit;
}

$idUsuario = $_SESSION['id']; // ID del usuario logueado

// Obtener las reservaciones del usuario
$query = "SELECT * FROM reservaciones 
        INNER JOIN menu ON reservaciones.codigo_habitacion = menu.codigo
        WHERE id_usuario = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $idUsuario);
$stmt->execute();
$result = $stmt->get_result();
$reservaciones = $result->fetch_all(MYSQLI_ASSOC);

class PDF extends FPDF
{
    function Header()
    {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, iconv('UTF-8', 'ISO-8859-1', 'Mis Reservaciones - Hotel Bitsú'), 0, 1, 'C');
        $this->Ln(10);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10,  iconv('UTF-8', 'ISO-8859-1', 'Recuerde que el pago se realiza el día del check-in en recepción.'), 0, 0, 'C');
    }
}

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);

// Encabezados de tabla
$pdf->SetFillColor(220, 220, 255);
$pdf->Cell(40, 10, 'ID Reserva', 1, 0, 'C', true);
$pdf->Cell(50, 10, 'Habitacion', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Fecha Inicio', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Fecha Fin', 1, 0, 'C', true);
$pdf->Cell(40, 10, 'Estado', 1, 1, 'C', true);

// Contenido de la tabla
$pdf->SetFont('Arial', '', 12);
foreach ($reservaciones as $reservacion) {
    $pdf->Cell(40, 10, $reservacion['id_reservacion'], 1, 0, 'C');
    $pdf->Cell(50, 10, iconv('UTF-8', 'ISO-8859-1', $reservacion['nombre']), 1, 0, 'C');
    $pdf->Cell(30, 10, $reservacion['fecha_inicio'], 1, 0, 'C');
    $pdf->Cell(30, 10, $reservacion['fecha_fin'], 1, 0, 'C');
    $pdf->Cell(40, 10, ucfirst($reservacion['estado']), 1, 1, 'C'); // Estado dentro de la celda
}

$pdf->Output();
?>
