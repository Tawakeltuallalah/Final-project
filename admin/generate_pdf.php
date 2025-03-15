<?php
require('fpdf/fpdf.php');

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(190, 10, "Hello, FPDF!", 1, 1, 'C');
$pdf->Output();
?>
