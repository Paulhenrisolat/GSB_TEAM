 <?php

require 'fpdpf/fpdf.php';
require_once '../includes/class.pdogsb.inc.php';
require_once '../includes/fct.inc.php';

setlocale(LC_TIME, 'fr_FR');
date_default_timezone_set('Europe/Paris');
class PDF extends FPDF {

    //Entete
    function header() {
        
        //BDD
        $pdo = PdoGsb::getPdoGsb();

        $infosFichePDF = filter_input(INPUT_POST, 'infosFicheFraisPDF', FILTER_SANITIZE_STRING);
        list($idVisiteur, $leMois) = explode('-', $infosFichePDF);
        //Nom et prénom du visiteur
        $infosVisiteur = $pdo->getNomPrenomVisiteur($idVisiteur);
        $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $leMois);
        
        //Frais forfaitisés de la fiche de frais
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
        $this->SetFont('Times', 'B', 14);
        //titre
        $this->Cell(190, 10, "REMBOURSEMENT DE FRAIS ENGAGES", 1, 0, 'C');
        $this->Ln();
        $this->SetFont('Arial', '', 12);
        //cellules englobe
        $this->Cell(190, 185, "", 1, 0, 'C');
        $this->SetTextColor(0, 0, 0);
        
        //infos visiteur + mois
        $this->Cell(-350, 40, 'Visiteur', 0, 0, 'C');
        $this->Cell(0, 60, 'Mois ', 0, 0, 'C');
        $this->Cell(-200, 60, date('F Y'), 0, 0, 'C');
        $this->SetXY(0, -235);
        $this->Cell(0, 10, 'NRD/' . strtoupper($idVisiteur), 0, 0, 'C');
        $this->Cell(-100, 10, $infosVisiteur['prenom'] .' '. strtoupper($infosVisiteur['nom']), 0, 0, 'C');
        
        //tableau centrale
        $this->Ln(40);
        $this->SetXY(20, 90);
        $this->Cell(170, 54, '', 1, 0, 'C');

        //tableau frais forfaitaires
        $this->SetFont('Times','BI', 12);
        $this->SetTextColor(51, 79, 153);
        $this->SetXY(20, 90);
        $this->Cell(50, 10, 'Frais Forfaitaires', 0, 0, 'C');
        $this->Cell(40, 10, 'Quantité', 0, 0, 'C');
        $this->Cell(40, 10, 'Montant unitaire', 0, 0, 'C');
        $this->Cell(40, 10, 'Total', 0, 0, 'C');
        
        //Forfait Etape
        $this->SetFont('Arial', '', 10);
        $this->SetTextColor(0, 0, 0);
        $this->SetXY(20, 100);
        $this->Cell(50, 8, 'Forfait Etape', 1, 0, 'B');
        $this->Cell(40, 8, $forfaitEtape['quantite'], 1, 0, 'R');
        $this->Cell(40, 8, $forfaitEtape['montantunitaire'], 1, 0, 'R');
        $this->Cell(40, 8, $forfaitEtape['quantite'] * $forfaitEtape['montantunitaire'], 1, 0, 'R');
        
        //Frais Kilométrique
        $this->SetXY(20, 108);
        $this->Cell(50, 8, 'Frais Kilométrique', 1, 0, 'B');
        $this->Cell(40, 8, $fraisKilometrique['quantite'], 1, 0, 'R');
        $this->Cell(40, 8, $fraisKilometrique['montantunitaire'], 1, 0, 'R');
        $this->Cell(40, 8, $fraisKilometrique['quantite'] * $fraisKilometrique['montantunitaire'], 1, 0, 'R');
        
        //Nuitée Hôtel
        $this->SetXY(20, 116);
        $this->Cell(50, 8, 'Nuitée Hôtel', 1, 0, 'B');
        $this->Cell(40, 8, $nuiteeHotel['quantite'], 1, 0, 'R');
        $this->Cell(40, 8, $nuiteeHotel['montantunitaire'], 1, 0, 'R');
        $this->Cell(40, 8, $nuiteeHotel['quantite'] * $nuiteeHotel['montantunitaire'], 1, 0, 'R');
        
        //Repas Restaurant
        $this->SetXY(20, 124);
        $this->Cell(50, 8, 'Repas Restaurant', 1, 0, 'B');
        $this->Cell(40, 8, $repasRestaurant['quantite'], 1, 0, 'R');
        $this->Cell(40, 8, $repasRestaurant['montantunitaire'], 1, 0, 'R');
        $this->Cell(40, 8, $repasRestaurant['quantite'] * $repasRestaurant['montantunitaire'], 1, 0, 'R');
        
        //Autres frais
        $this->SetFont('Times','BI',12);
        $this->SetXY(85, 135);
        $this->SetTextColor(51, 79, 153);
        $this->Cell(50, 8, 'Autres frais', 0, 0, 'C');
        
        //englobe entete autres frais
        $this->SetXY(20, 144);
        $this->Cell(170, 8, '', 1, 0, 'C');
        
        //header + foreach tableau
        $this->SetXY(20, 144);
        $this->SetTextColor(51, 79, 153);
        $this->SetFont('Times','BI',12);
        $width_cell=array(42,86,42);
        $this->Cell($width_cell[0],8,'Date',0,0,'C');
        $this->Cell($width_cell[1],8,'Libellé',0,0,'C');
        $this->Cell($width_cell[2],8,'Montant',0,1,'C');
        
        $this->SetFont('Arial', '', 10);
        $this->SetTextColor(0, 0, 0);
        $stY = 144;
        foreach($lesFraisHorsForfait as $fraisHf){
            $stY = $stY + 8;
            $this->SetY($stY);
            $this->SetX(20);
            $this->cell($width_cell[0],8, $fraisHf['date'], 1, 0, 'B');
            $this->cell($width_cell[1],8, $fraisHf['libelle'], 1, 0, 'B');
            $this->cell($width_cell[2],8, $fraisHf['montant'], 1, 1, 'R');
        }
        
        //date + total
        $this->SetFont('Arial', '', 12);
        $this->SetTextColor(0, 0, 0);
        $this->SetXY(110, 212);
        $this->Cell(40, 10, 'TOTAL '. date('d/Y'), 1, 0, 'B');
        $this->Cell(40, 10, $montantValide, 1, 0, 'R');
        
    }

    //Bas de page
    function footer() {
        //position Y
        $this->SetY(-65);
        $this->SetFont('Arial', '', 10);
        $this->Cell(290, 20, "Fait à Paris, le " . date('d F Y'), 0, 0, 'C');
        $this->Ln(10);
        $this->Cell(269, 18, "Vu l'agent comptable", 0, 0, 'C');
        $this->Image('signatureComptable.jpg', 114, 260, 70);
    }

}

//pdf
//Creation du PDF (utilise le nom de la classe précedente)
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

//sortie
$pdf->Output();

