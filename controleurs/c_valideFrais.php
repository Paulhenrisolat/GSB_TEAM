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
        include 'vues/v_listeVisiteursValidation.php';
        break;
    case 'chercheMois':
        $idVisiteur = filter_input(INPUT_POST, 'idVisiteur', FILTER_SANITIZE_STRING);
        $lesMois = $pdo->getLesMoisDisponiblesCL($idVisiteur);
        $idASelectionner = $idVisiteur;
        $lesInfosVisiteurs = $pdo->getLesVisiteursCL();
        include 'vues/v_listeVisiteursValidation.php';
        include 'vues/v_listeMoisValidation.php';
        break;
    case 'voirEtatFrais' || 'actualisationFraisForfaitises':
        $infosFiche = filter_input(INPUT_POST, 'infosFicheFrais', FILTER_SANITIZE_STRING);
        list($leMois, $idVisiteur) = explode('-', $infosFiche);
        $idASelectionner = $idVisiteur;
        $moisASelectionner = $leMois;
        $lesInfosVisiteurs = $pdo->getLesVisiteursCL();
        $lesMois = $pdo->getLesMoisDisponiblesCL($idVisiteur);
        include 'vues/v_listeVisiteursValidation.php';
        include 'vues/v_listeMoisValidation.php';
        if ($action == 'voirEtatFrais') {
            $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $leMois);
            $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $leMois);
            $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteur, $leMois);
            $numAnnee = substr($leMois, 0, 4);
            $numMois = substr($leMois, 4, 2);
            $libEtat = $lesInfosFicheFrais['libEtat'];
            $montantValide = $lesInfosFicheFrais['montantValide'];
            $nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
            $dateModif = dateAnglaisVersFrancais($lesInfosFicheFrais['dateModif']);
        } elseif ($action == 'actualisationFraisForfaitises') {
            $listFrais = filter_input(INPUT_POST, 'lesFrais', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
            if (lesQteFraisValides($listFrais)) {
                $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $leMois);
                $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $leMois);
                $i = 0;
                foreach ($listFrais as $unFrais) {
                    $lesFraisForfait[$i]['quantite'] = $unFrais;
                    $i++;
                }
                $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteur, $leMois);
                $numAnnee = substr($leMois, 0, 4);
                $numMois = substr($leMois, 4, 2);
                $libEtat = $lesInfosFicheFrais['libEtat'];
                $montantValide = $lesInfosFicheFrais['montantValide'];
                $nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
                $dateModif = dateAnglaisVersFrancais($lesInfosFicheFrais['dateModif']);
                ajouterMessage('Modification pris en compte');
                include 'vues/v_messages.php';
            } else {
                ajouterErreur('Les valeurs des frais doivent être numériques');
                include 'vues/v_erreurs.php';
            }
        } elseif ($action == 'actualisationFraisHorsForfait') {
            
        } else {
            ajouterErreur('Action non reconnu');
            include 'vues/v_erreurs.php';
        }
        include 'vues/v_valideFrais.php';
        break;

}
   