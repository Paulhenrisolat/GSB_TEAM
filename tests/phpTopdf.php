<?php

require 'fpdpf/fpdf.php';

// En tout premier on active l'affichage des erreurs PHP
error_reporting ( E_ALL );
ini_set ( 'display_errors', TRUE );
ini_set ( 'display_startup_errors', TRUE );
 
// On démarre la session
session_start();
 
// On initialise les variables
$prenom = !empty ( $_GET['prenom'] ) ? $_GET['prenom'] : NULL;
$nom = !empty ( $_GET['nom'] ) ? $_GET['nom'] : NULL;
$fraisF = !empty ( $_GET['fraisF'] ) ? $_GET['fraisF'] : NULL;
$quantite = !empty ( $_GET['quantite'] ) ? $_GET['quantite'] : NULL;
$montantU = !empty ( $_GET['montantU'] ) ? $_GET['montantU'] : NULL;
$total = !empty ( $_GET['total'] ) ? $_GET['total'] : NULL;



$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(40,10,'YEET yeet !',0,0,"C");
$pdf->Output();


