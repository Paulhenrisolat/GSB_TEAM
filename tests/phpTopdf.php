<?php

require 'fpdpf/fpdf.php';

class PDF extends FPDF {

    //Entete
    function Header() {
        //logo
        $this->Image('logo.jpg', 90, 6, 30);
        //saut de ligne
        $this->Ln(26);
        //colorText
        $this->SetTextColor(51, 79, 153);
        //famille de texte
        $this->SetFont('Arial', 'B', 14);
        //titre
        $this->Cell(190, 10, "REMBOURSEMENT DE FRAIS ENGAGES", 1, 0, 'C');
        $this->Ln();
        $this->SetFont('Arial', '', 12);
        //cellule
        $this->Cell(190, 155, "", 1, 0, 'C');//test cellule englobe
        $this->SetTextColor(0, 0, 0);
        $this->Cell(-350, 40, 'Visiteur ' , 0, 0, 'C');
        $this->Cell(0, 60, 'Mois ', 0, 0, 'C');
        $this->Ln(40);
        $this->SetX(15);
        $this->Cell(180, 100, 'Mois ', 1, 0, 'C');
    }

    // Simple table
    function HeaderTable() {
        $this->Cell(0, 0, 'Mois ', 1, 0, 'C');
        $this->Cell(0, 0, 'Mois ', 1, 0, 'C');
        $this->Cell(0, 0, 'Mois ', 1, 0, 'C');
        $this->Cell(0, 0, 'Mois ', 1, 0, 'C');
        $this->Cell(0, 0, 'Mois ', 1, 0, 'C');
    }

    //Bas de page
    function Footer() {
        //position Y
        $this->SetY(-80);
        $this->Cell(290, 12, "Fait à Paris, le " . date('d F Y'), 0, 0, 'C');
        $this->Ln(10);
        $this->Cell(265, 12, "Vu l'agent comptable", 0, 0, 'C');
        $this->Image('signatureComptable.jpg', 114, 250, 70);
    }

}

//Creation du PDF (utilise le nom de la classe précedente)
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times', '', 12);
$pdf->Output();

