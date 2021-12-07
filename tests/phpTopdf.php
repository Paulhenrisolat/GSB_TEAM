 <?php

require 'fpdpf/fpdf.php';
require_once '../includes/class.pdogsb.inc.php';
require_once '../includes/fct.inc.php';

class PDF extends FPDF {

    //Entete
    function header() {
        
        // BDD
        $pdo = PdoGsb::getPdoGsb();

        $infosFichePDF = filter_input(INPUT_POST, 'infosFicheFraisPDF', FILTER_SANITIZE_STRING);
        list($idVisiteur, $leMois) = explode('-', $infosFichePDF);
        // Nom et prénom du visiteur
        $infosVisiteur = $pdo->getNomPrenomVisiteur($idVisiteur);
        $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $leMois);
        // Frais forfaitisés de la fiche de frais
        $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $leMois);
        $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteur, $leMois);
        
        $forfaitEtape = $lesFraisForfait[0];
        $fraisKilometrique = $lesFraisForfait[1];
        $nuiteeHotel = $lesFraisForfait[2];
        $repasRestaurant = $lesFraisForfait[3];
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
        //cellules
        $this->Cell(190, 155, "", 1, 0, 'C'); //test cellule englobe
        $this->SetTextColor(0, 0, 0);
        $this->Cell(-350, 40, 'Visiteur', 0, 0, 'C');
        $this->Cell(0, 60, 'Mois ', 0, 0, 'C');
        $this->Ln(40);
        $this->SetXY(20, 90);
        $this->Cell(170, 90, 'tableau', 1, 0, 'C');

        //tableInfo
        $test = 'test';
        $this->SetXY(150, 185);
        $this->Cell(40, 10, 'TOTAL '. date('d F Y'), 1, 0, 'C');
        $this->Cell(40, 10, $montantValide, 1, 0, 'C');
        
        //test tableau sql
        $this->SetFont('Arial', 'B', 10);
        $this->SetXY(20, 90);
        $this->Cell(50, 10, 'Frais Forfaitaires', 1, 0, 'C');
        $this->Cell(40, 10, 'Quantite', 1, 0, 'C');
        $this->Cell(40, 10, 'Montant unitaire', 1, 0, 'C');
        $this->Cell(40, 10, 'Total', 1, 0, 'C');
        
        //tableau rempli

    }

    // Simple table
    function headerTable() {
        //$this->Cell(0, 0, 'Mois ', 1, 0, 'C');
        $this->SetY(100);
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(60, 0, 'ID', 1, 0, 'C');
        $this->Cell(40, 10, 'Name', 1, 0, 'C');
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

