<?php

require 'fpdpf/fpdf.php';

class PDF extends FPDF 
{
    //Load data
    function LoadData($file) 
    {
        $lines = file($file);
        $data = array();
        foreach ($lines as $line) 
        {
            $data[] = explode(';', trim($line));
            return $data;
        }
    }
    //Table
    function Table($header, $data) 
    {
        //header
        foreach ($header as $col) 
        {
            $this->Cell(38, 7, $col, 1);
            $this->Ln();
        }
        //Data
        foreach ($data as $row) 
        {
            foreach ($row as $col) 
            {
                $this->Cell(38, 6, $col, 1);
                $this->Ln();
            }
        }
    }
}

$pdf = new FPDF();
//header
$header = array('Frais Forfaitaires', 'Quantité', 'Montant unitaire', 'Total');
//Data (file)
$data = $pdf->LoadData('vues/v_etatFrais.php');
$pdf->SetFont('Arial', '', 16);
$pdf->AddPage();
$pdf->Table($header, $data);
$pdf->Output();
//$pdf->Cell(40,10,'YEET yeet !',0,0,"C");