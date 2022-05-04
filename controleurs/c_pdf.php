<?php

require 'tests/fpdf/fpdf.php';

$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
switch ($action) {
    case 'generatePdf':
        setlocale(LC_TIME, 'fr_FR');
        date_default_timezone_set('Europe/Paris');

        $pdo = PdoGsb::getPdoGsb();

        $infosFichePDF = filter_input(INPUT_POST, 'infosFicheFraisPDF', FILTER_SANITIZE_STRING);
        list($idVisiteur, $leMois) = explode('-', $infosFichePDF);
        $numAnnee = substr($leMois, 0, 4);
        $numMois = substr($leMois, 4, 2);
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

        ob_start();
        $pdf = new FPDF();
        $pdf->AliasNbPages();
        $pdf->AddPage();
        //logo
        $pdf->Image('images/logo.jpg', 90, 6, 30);
        //saut de ligne
        $pdf->Ln(26);
        //colorText
        $pdf->SetTextColor(51, 79, 153);
        //famille de texte
        $pdf->SetFont('Times', 'B', 14);
        //titre
        $pdf->Cell(190, 10, "REMBOURSEMENT DE FRAIS ENGAGES", 1, 0, 'C');
        $pdf->Ln();
        $pdf->SetFont('Arial', '', 12);
        //cellules englobe
        $pdf->Cell(190, 185, "", 1, 0, 'C');
        $pdf->SetTextColor(0, 0, 0);
        //infos visiteur + mois
        $pdf->Cell(-350, 40, 'Visiteur', 0, 0, 'C');
        $pdf->Cell(0, 60, 'Mois ', 0, 0, 'C');
        $pdf->Cell(-200, 60, $numMois . "-" . $numAnnee, 0, 0, 'C');
        $pdf->SetXY(0, -235);
        $pdf->Cell(0, 10, 'NRD/' . strtoupper($idVisiteur), 0, 0, 'C');
        $pdf->Cell(-100, 10, $infosVisiteur['prenom'] . ' ' . strtoupper($infosVisiteur['nom']), 0, 0, 'C');
        //tableau centrale
        $pdf->Ln(40);
        $pdf->SetXY(20, 90);
        $pdf->Cell(170, 54, '', 1, 0, 'C');
        //tableau frais forfaitaires
        $pdf->SetFont('Times', 'BI', 12);
        $pdf->SetTextColor(51, 79, 153);
        $pdf->SetXY(20, 90);
        $pdf->Cell(50, 10, 'Frais Forfaitaires', 0, 0, 'C');
        $pdf->Cell(40, 10, 'Quantité', 0, 0, 'C');
        $pdf->Cell(40, 10, 'Montant unitaire', 0, 0, 'C');
        $pdf->Cell(40, 10, 'Total', 0, 0, 'C');
        //Forfait Etape
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY(20, 100);
        $pdf->Cell(50, 8, 'Forfait Etape', 1, 0, 'B');
        $pdf->Cell(40, 8, $forfaitEtape['quantite'], 1, 0, 'R');
        $pdf->Cell(40, 8, $forfaitEtape['montantunitaire'], 1, 0, 'R');
        $pdf->Cell(40, 8, $forfaitEtape['quantite'] * $forfaitEtape['montantunitaire'], 1, 0, 'R');
        //Frais Kilométrique
        $pdf->SetXY(20, 108);
        $pdf->Cell(50, 8, 'Frais Kilométrique', 1, 0, 'B');
        $pdf->Cell(40, 8, $fraisKilometrique['quantite'], 1, 0, 'R');
        $pdf->Cell(40, 8, $fraisKilometrique['montantunitaire'], 1, 0, 'R');
        $pdf->Cell(40, 8, $fraisKilometrique['quantite'] * $fraisKilometrique['montantunitaire'], 1, 0, 'R');
        //Nuitée Hôtel
        $pdf->SetXY(20, 116);
        $pdf->Cell(50, 8, 'Nuitée Hôtel', 1, 0, 'B');
        $pdf->Cell(40, 8, $nuiteeHotel['quantite'], 1, 0, 'R');
        $pdf->Cell(40, 8, $nuiteeHotel['montantunitaire'], 1, 0, 'R');
        $pdf->Cell(40, 8, $nuiteeHotel['quantite'] * $nuiteeHotel['montantunitaire'], 1, 0, 'R');
        //Repas Restaurant
        $pdf->SetXY(20, 124);
        $pdf->Cell(50, 8, 'Repas Restaurant', 1, 0, 'B');
        $pdf->Cell(40, 8, $repasRestaurant['quantite'], 1, 0, 'R');
        $pdf->Cell(40, 8, $repasRestaurant['montantunitaire'], 1, 0, 'R');
        $pdf->Cell(40, 8, $repasRestaurant['quantite'] * $repasRestaurant['montantunitaire'], 1, 0, 'R');
        //Autres frais
        $pdf->SetFont('Times', 'BI', 12);
        $pdf->SetXY(85, 135);
        $pdf->SetTextColor(51, 79, 153);
        $pdf->Cell(50, 8, 'Autres frais', 0, 0, 'C');
        //englobe entete autres frais
        $pdf->SetXY(20, 144);
        $pdf->Cell(170, 8, '', 1, 0, 'C');
        //header + foreach tableau
        $pdf->SetXY(20, 144);
        $pdf->SetTextColor(51, 79, 153);
        $pdf->SetFont('Times', 'BI', 12);
        $width_cell = array(42, 86, 42);
        $pdf->Cell($width_cell[0], 8, 'Date', 0, 0, 'C');
        $pdf->Cell($width_cell[1], 8, 'Libellé', 0, 0, 'C');
        $pdf->Cell($width_cell[2], 8, 'Montant', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetTextColor(0, 0, 0);
        $stY = 144;
        foreach ($lesFraisHorsForfait as $fraisHf) {
            $stY = $stY + 8;
            $pdf->SetY($stY);
            $pdf->SetX(20);
            $pdf->Cell($width_cell[0], 8, $fraisHf['date'], 1, 0, 'B');
            $pdf->Cell($width_cell[1], 8, $fraisHf['libelle'], 1, 0, 'B');
            $pdf->Cell($width_cell[2], 8, $fraisHf['montant'], 1, 1, 'R');
        }
        //date + total
        $pdf->SetFont('Arial', '', 12);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY(110, 212);
        $pdf->Cell(40, 10, 'TOTAL', 1, 0, 'B');
        $pdf->Cell(40, 10, $montantValide, 1, 0, 'R');
        //Bas de page
        //position Y
        $pdf->SetY(-65);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(290, 20, "Fait à Paris, le " . date('d F Y'), 0, 0, 'C');
        $pdf->Ln(10);
        $pdf->Cell(269, 18, "Vu l'agent comptable", 0, 0, 'C');
        $pdf->Image('images/signatureComptable.jpg', 114, 260, 70);
        //sortie
        $pdfName = 'RemboursementFrais_' . $infosVisiteur['prenom'] . $infosVisiteur['nom'] . '_' . $numMois . '-' . $numAnnee . '.pdf';
        $pdf->Output('D', $pdfName);
        ob_end_flush();
}
