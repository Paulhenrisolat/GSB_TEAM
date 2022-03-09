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
case 'selectionnerFiche':
    $lesFiches = $pdo->getLesFichesVA();
    $lesMois = $pdo->getLesMoisFichesVA();
    if($lesMois) {
        include 'vues/v_listeFichesVA.php';
        include 'vues/v_paiementFichesMois.php';
    }
    else {
        ajouterMessage("Il n'y a pas de visiteurs dont la fiche est à mettre en paiement.");
        include 'vues/v_messages.php';
    }
    break;
case 'voirSuiviFrais':
    $infosFiche = filter_input(INPUT_POST, 'lstFiche', FILTER_SANITIZE_STRING);
    list($idVisiteur, $leMois) = explode('-', $infosFiche);
    $infosVisiteur = $pdo->getNomPrenomVisiteur($idVisiteur);
    $lesFiches = $pdo->getLesFichesVA();
    include 'vues/v_listeFichesVA.php';
    $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $leMois);
    $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $leMois);
    $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteur, $leMois);
    $leVehicule = $pdo->getLeVehicule($lesInfosFicheFrais['idvehicule']);
    $nom = $infosVisiteur['nom'];
    $prenom = $infosVisiteur['prenom'];
    $numAnnee = substr($leMois, 0, 4);
    $numMois = substr($leMois, 4, 2);
    $libEtat = $lesInfosFicheFrais['libEtat'];
    $montantValide = $lesInfosFicheFrais['montantValide'];
    $nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
    $dateModif = dateAnglaisVersFrancais($lesInfosFicheFrais['dateModif']);
    include 'vues/v_suiviFrais.php';
    break;
case 'miseEnPaiement':
    $infosFiche = filter_input(INPUT_POST, 'infosFicheFrais', FILTER_SANITIZE_STRING);
    list($idVisiteur, $leMois) = explode('-', $infosFiche);
    $pdo->majEtatFicheFrais($idVisiteur, $leMois, 'RB');
    $lesFiches = $pdo->getLesFichesVA();
    $lesMois = $pdo->getLesMoisFichesVA();
    ajouterMessage('La fiche a bien été mise en paiement.');
    include 'vues/v_messages.php';
    if($lesMois) {
        include 'vues/v_listeFichesVA.php';
        include 'vues/v_paiementFichesMois.php';
    }
    else {
        ajouterMessage("Il n'y a pas de visiteurs dont la fiche est à mettre en paiement.");
        include 'vues/v_messages.php';
    }
    break;
case 'miseEnPaiementFichesMois':
    $leMois = filter_input(INPUT_POST, 'moisFiches', FILTER_SANITIZE_STRING);
    $pdo->majEtatListeFichesFrais($leMois, 'RB');
    $lesFiches = $pdo->getLesFichesVA();
    $lesMois = $pdo->getLesMoisFichesVA();
    ajouterMessage('Les fiches de ce mois ont bien été mises en paiement.');
    include 'vues/v_messages.php';
    if($lesMois) {
        include 'vues/v_listeFichesVA.php';
        include 'vues/v_paiementFichesMois.php';
    }
    else {
        ajouterMessage("Il n'y a pas de visiteurs dont la fiche est à mettre en paiement.");
        include 'vues/v_messages.php';
    }
    break;
}