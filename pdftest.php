<?php
require ('vendor/setasign/fpdf/fpdf.php');

$pdf = new Fpdf();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(40, 10, '¡FPDF funcional!');
$pdf->Output();
?>
