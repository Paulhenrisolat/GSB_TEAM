<?php

/**
 * Gestion de l'affichage des frais
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

$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
switch ($action) {
case 'chercheNom':
    $lesInfosVisiteurs = $pdo->getLesVisiteursCL();
    if($lesInfosVisiteurs) {
        include 'vues/v_listeVisiteursValidation.php';
    }
    else {
        ajouterMessage("Il n'y a pas de visiteurs dont la fiche est à valider.");
        include 'vues/v_messages.php';
    }
    break;
case 'chercheMois':
    $idVisiteur = filter_input(INPUT_POST, 'idVisiteur', FILTER_SANITIZE_STRING);
    $lesMois = $pdo->getLesMoisDisponiblesCL($idVisiteur);
    $idASelectionner = $idVisiteur;
    $lesInfosVisiteurs = $pdo->getLesVisiteursCL();
    if($lesMois) {
        include 'vues/v_listeVisiteursValidation.php';
        include 'vues/v_listeMoisValidation.php';
    }
    else {
        ajouterMessage("Il n'y a pas de fiches de frais à valider pour ce visiteur.");
        include 'vues/v_messages.php';
        include 'vues/v_listeVisiteursValidation.php';
    }
    break;
case 'voirEtatFrais' || 'actualisationFraisForfaitises' || 'actualisationFraisHorsForfait' || 'valideFiche':
    $infosFiche = filter_input(INPUT_POST, 'infosFicheFrais', FILTER_SANITIZE_STRING);
    list($leMois, $idVisiteur) = explode('-', $infosFiche);
    $idASelectionner = $idVisiteur;
    $moisASelectionner = $leMois;
    $lesInfosVisiteurs = $pdo->getLesVisiteursCL();
    $lesMois = $pdo->getLesMoisDisponiblesCL($idVisiteur);
    
    if ($action == 'actualisationFraisForfaitises') {
        $listFrais = filter_input(INPUT_POST, 'lesFrais', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
        if (lesQteFraisValides($listFrais)) {
            $pdo->majFraisForfait($idVisiteur, $leMois, $listFrais);
            ajouterMessage('Modification pris en compte');
            include 'vues/v_messages.php';
        } else {
            ajouterErreur('Les valeurs des frais doivent être numériques');
            include 'vues/v_erreurs.php';
        }
    } elseif ($action == 'actualisationFraisHorsForfait') {
        $bouton = filter_input(INPUT_POST, 'bouton');
        if($bouton == "Corriger"){
            list($leMois, $idVisiteur, $idHorsForfait) = explode('-', $infosFiche);
            $infosFiche = ($leMois . '-' . $idVisiteur);
            $montant = filter_input(INPUT_POST, 'montant', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $libelle = filter_input(INPUT_POST, 'libelle', FILTER_SANITIZE_STRING);
            $date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING);
            list($jour, $mois, $annee) = explode('/', $date);
            $date = $annee . '-' . $mois . '-' . $jour;
            if (preg_match("^[0-9]{4}-[0-1][0-9]-[0-3][0-9]$^", $date) && estFloatPositif($montant) == true) {
                $pdo->majFraisHorsForfait($idVisiteur, $leMois, $date, $libelle, $montant, $idHorsForfait);
                ajouterMessage('Modification pris en compte');
                include 'vues/v_messages.php';
            } else {
                ajouterErreur('Les valeurs entrées ne sont pas correct');
                include 'vues/v_erreurs.php';
            }
        } elseif($bouton == "Refuser") {
            list($leMois, $idVisiteur, $idHorsForfait) = explode('-', $infosFiche);
            $infosFiche = ($leMois . '-' . $idVisiteur);
            $libelle = filter_input(INPUT_POST, 'libelle', FILTER_SANITIZE_STRING);
            $pdo->refuserFraisHorsForfait($idVisiteur, $leMois, $libelle, $idHorsForfait);
        } elseif($bouton == "Rétablir") {
            list($leMois, $idVisiteur, $idHorsForfait) = explode('-', $infosFiche);
            $infosFiche = ($leMois . '-' . $idVisiteur);
            $libelle = filter_input(INPUT_POST, 'libelle', FILTER_SANITIZE_STRING);
            $pdo->annulerFraisHorsForfait($idVisiteur, $leMois, $libelle, $idHorsForfait);
        }  
    }
    $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $leMois);
    $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $leMois);
    $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteur, $leMois);
    if ($action == 'valideFiche'){
        $leVehicule = $pdo->getLeVehicule($lesInfosFicheFrais['idvehicule']);
        $montantValide = 0;
        foreach($lesFraisForfait as $unFraisForfait){
            if($unFraisForfait['idfrais']!= 'KM'){
                $montantValide += $unFraisForfait['montantunitaire'] * $unFraisForfait['quantite'];
            }
            else {
                $montantValide += $unFraisForfait['quantite'] * $leVehicule['prixkm'];
            }     
        }
        foreach($lesFraisHorsForfait as $unFraisHorsForfait){
            if(!preg_match("/^(REFUSER:)/",$unFraisHorsForfait['libelle'])){
            $montantValide += $unFraisHorsForfait['montant'];
            }
        }
        $pdo->majMontantValide($idVisiteur, $leMois, (string)$montantValide);
        $pdo->majEtatFicheFrais($idVisiteur, $leMois, "VA");
        $lesInfosVisiteurs = $pdo->getLesVisiteursCL();
        ajouterMessage('Fiche validée');
        if($lesInfosVisiteurs) {
            include 'vues/v_listeVisiteursValidation.php';
            include 'vues/v_messages.php';
        }
        else {
             ajouterMessage("Il n'y a plus de visiteur à valider.");
             include 'vues/v_messages.php';
        }
        break;
    }
    include 'vues/v_listeVisiteursValidation.php';
    include 'vues/v_listeMoisValidation.php';
    $numAnnee = substr($leMois, 0, 4);
    $numMois = substr($leMois, 4, 2);
    $libEtat = $lesInfosFicheFrais['libEtat'];
    $nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
    $dateModif = dateAnglaisVersFrancais($lesInfosFicheFrais['dateModif']);
    include 'vues/v_valideFrais.php';
    break;        
}