 <?php

require 'fpdpf/fpdf.php';
require_once '../includes/class.pdogsb.inc.php';
require_once '../includes/fct.inc.php';

//modification de fpdf pour utf8 ligne 626
class PDF extends FPDF {

    //Entete
    function header() {
        
        //bdd
        $pdo = PdoGsb::getPdoGsb();

        $infosFichePDF = filter_input(INPUT_POST, 'infosFicheFraisPDF', FILTER_SANITIZE_STRING);
        list($idVisiteur, $leMois) = explode('-', $infosFichePDF);
        
        $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $leMois);
        $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $leMois);
        $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteur, $leMois);
        $infosVisiteur=$pdo->getNomPrenomVisiteur($idVisiteur);
        
        $montantValide = $lesInfosFicheFrais['montantValide'];
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
        //cellules englobe
        $this->Cell(190, 155, "", 1, 0, 'C');
        $this->SetTextColor(0, 0, 0);
        //
        $this->Cell(-350, 40, 'Visiteur', 0, 0, 'C');
        $this->Cell(0, 60, 'Mois ', 0, 0, 'C');
        //visiteur + mois
        $this->Cell(-200, 60, date('F Y'), 0, 0, 'C');
        $this->SetXY(0, -235);
        $this->Cell(0, 10, 'id ', 0, 0, 'C');
        $this->Cell(-100, 10, 'Nom ', 0, 0, 'C');
        
        //tableau centrale
        $this->Ln(40);
        $this->SetXY(20, 90);
        $this->Cell(170, 90, '', 1, 0, 'C');

        //date + total
        $this->SetTextColor(0, 0, 0);
        $this->SetXY(100, 185);
        $this->Cell(40, 10, 'TOTAL '. date('d/Y'), 1, 0, 'C');
        $this->Cell(40, 10, $montantValide, 1, 0, 'C');
        
        //tableau frais forfaitaires
        $this->SetFont('Arial', 'B', 10);
        $this->SetTextColor(51, 79, 153);
        $this->SetXY(20, 90);
        $this->Cell(50, 10, 'Frais Forfaitaires', 1, 0, 'C');
        $this->Cell(40, 10, 'Quantite', 1, 0, 'C');
        $this->Cell(40, 10, 'Montant unitaire', 1, 0, 'C');
        $this->Cell(40, 10, 'Total', 1, 0, 'C');
        
        //
        $this->SetTextColor(0, 0, 0);
        $this->SetXY(20, 100);
        $this->Cell(50, 8, 'Forfait Etape', 1, 0, 'C');
        $this->Cell(40, 8, '', 1, 0, 'C');
        $this->Cell(40, 8, '', 1, 0, 'C');
        $this->Cell(40, 8, '', 1, 0, 'C');
        
        //
        $this->SetXY(20, 108);
        $this->Cell(50, 8, 'Frais Kilométrique', 1, 0, 'C');
        $this->Cell(40, 8, '', 1, 0, 'C');
        $this->Cell(40, 8, '', 1, 0, 'C');
        $this->Cell(40, 8, '', 1, 0, 'C');
        
        //
        $this->SetXY(20, 116);
        $this->Cell(50, 8, 'Nuitée Hôtel', 1, 0, 'C');
        $this->Cell(40, 8, '', 1, 0, 'C');
        $this->Cell(40, 8, '', 1, 0, 'C');
        $this->Cell(40, 8, '', 1, 0, 'C');
        
        //
        $this->SetXY(20, 124);
        $this->Cell(50, 8, 'Repas Restaurant', 1, 0, 'C');
        $this->Cell(40, 8, '', 1, 0, 'C');
        $this->Cell(40, 8, '', 1, 0, 'C');
        $this->Cell(40, 8, '', 1, 0, 'C');
    }

    //Bas de page
    function footer() {
        //position Y
        $this->SetY(-80);
        $this->Cell(290, 12, "Fait à Paris, le " . date('d F Y'), 0, 0, 'C');
        $this->Ln(10);
        $this->Cell(265, 12, "Vu l'agent comptable", 0, 0, 'C');
        $this->Image('signatureComptable.jpg', 114, 250, 70);
    }

}

//pdf
//Creation du PDF (utilise le nom de la classe précedente)
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times', '', 12);
//sortie
$pdf->Output();

