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
        $lesInfosVisiteurs = $pdo->getLesVisiteurs();
        include 'vues/v_listeVisiteursValidation.php';
        break;
    case 'chercheMois':
        $idVisiteur = filter_input(INPUT_POST, 'idVisiteur', FILTER_SANITIZE_STRING);
        $lesMois = $pdo->getLesMoisDisponibles($idVisiteur);
        $idASelectionner = $idVisiteur;
        $lesInfosVisiteurs = $pdo->getLesVisiteurs();
        include 'vues/v_listeVisiteursValidation.php';
        include 'vues/v_listeMoisValidation.php';
        break;
    case 'voirEtatFrais':
        $infosFiche = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING);
        list($leMois, $idVisiteur) = explode('-', $infosFiche);
        $idASelectionner = $idVisiteur;
        $moisASelectionner = $leMois;
        $lesInfosVisiteurs = $pdo->getLesVisiteurs();
        $lesMois = $pdo->getLesMoisDisponibles($idVisiteur);
        include 'vues/v_listeVisiteursValidation.php';
        include 'vues/v_listeMoisValidation.php';
        $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $leMois);
        $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $leMois);
        $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteur, $leMois);
        $numAnnee = substr($leMois, 0, 4);
        $numMois = substr($leMois, 4, 2);
        $libEtat = $lesInfosFicheFrais['libEtat'];
        $montantValide = $lesInfosFicheFrais['montantValide'];
        $nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
        $dateModif = dateAnglaisVersFrancais($lesInfosFicheFrais['dateModif']);
        include 'vues/v_valideFrais.php';
        break;
    case 'actualisationFraisForfaitises':
        $listFrais = filter_input(INPUT_POST, 'lesFrais', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
        $infosFiche = filter_input(INPUT_POST, 'infosFicheFrais', FILTER_SANITIZE_STRING);
        list($leMois, $idVisiteur) = explode('-', $infosFiche);
        $idASelectionner = $idVisiteur;
        $moisASelectionner = $leMois;
        $lesInfosVisiteurs = $pdo->getLesVisiteurs();
        $lesMois = $pdo->getLesMoisDisponibles($idVisiteur);
        include 'vues/v_listeVisiteursValidation.php';
        include 'vues/v_listeMoisValidation.php';
		if (lesQteFraisValides($listFrais)) {
            $lesFraisForfait = $listFrais;
            $message='Modification pris en compte';
            echo '<script type="text/javascript">window.alert("'.$message.'");</script>';
        } else {
            ajouterErreur('Les valeurs des frais doivent être numériques');
            include 'vues/v_erreurs.php';
        }
        break;
}
   