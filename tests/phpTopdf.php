<?php

require 'fpdpf/fpdf.php';

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(40,10,'YEET yeet !',0,0,"C");
$pdf->Output();


