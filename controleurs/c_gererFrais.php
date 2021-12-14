<?php
/**
 * Gestion des frais
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Réseau CERTA <contact@reseaucerta.org>
 * @author    José GIL <jgil@ac-nice.fr>
 * @copyright 2017 Réseau CERTA
 * @license   Réseau CERTA
 * @version   GIT: <0>
 * @link      http://www.reseaucerta.org Contexte « Laboratoire GSB »
 */

$idVisiteur = $_SESSION['idUtilisateur'];
$mois = getMois(date('d/m/Y'));
$numAnnee = substr($mois, 0, 4);
$numMois = substr($mois, 4, 2);
$lesVehicules = $pdo->getLesVehicules();
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
switch ($action) {
case 'saisirFrais':
    if ($pdo->estPremierFraisMois($idVisiteur, $mois)) {
        $pdo->creeNouvellesLignesFrais($idVisiteur, $mois);
        $premierVehicule = $lesVehicules['0'];
        $vehiculeASelectionner = $premierVehicule['id'];
    }
    else {
        $premierVehicule = $pdo->getLesInfosFicheFrais($idVisiteur, $mois);
        $vehiculeASelectionner = $premierVehicule['idvehicule'];
    }
    break;
case 'validerMajFraisForfait':
    $lesFrais = filter_input(INPUT_POST, 'lesFrais', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
    $leVehicule = filter_input(INPUT_POST, 'vehicule', FILTER_SANITIZE_STRING);
    $vehiculeASelectionner = $leVehicule;
    if (lesQteFraisValides($lesFrais)) {
        $pdo->majFraisForfait($idVisiteur, $mois, $lesFrais);
        $pdo->majFicheVehicule($idVisiteur, $mois, $leVehicule);
    } else {
        ajouterErreur('Les valeurs des frais doivent être numériques');
        include 'vues/v_erreurs.php';
    }
    break;
case 'validerCreationFrais':
    $dateFrais = filter_input(INPUT_POST, 'dateFrais', FILTER_SANITIZE_STRING);
    $libelle = filter_input(INPUT_POST, 'libelle', FILTER_SANITIZE_STRING);
    $montant = filter_input(INPUT_POST, 'montant', FILTER_VALIDATE_FLOAT);
    $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteur, $mois);
    $vehiculeASelectionner = $lesInfosFicheFrais['idvehicule'];
    valideInfosFrais($dateFrais, $libelle, $montant);
    if (nbErreurs() != 0) {
        include 'vues/v_erreurs.php';
    } else {
        $pdo->creeNouveauFraisHorsForfait(
            $idVisiteur,
            $mois,
            $libelle,
            $dateFrais,
            $montant
        );
    }
    break;
case 'supprimerFrais':
    $idFrais = filter_input(INPUT_GET, 'idFrais', FILTER_SANITIZE_STRING);
    $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteur, $mois);
    $vehiculeASelectionner = $lesInfosFicheFrais['idvehicule'];
    $pdo->supprimerFraisHorsForfait($idFrais);
    break;
}
$lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $mois);
$lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $mois);
require 'vues/v_listeFraisForfait.php';
require 'vues/v_listeFraisHorsForfait.php';