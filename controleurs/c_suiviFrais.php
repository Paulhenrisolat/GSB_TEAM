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
    $ficheASelectionner = $lesFiches[0];
    include 'vues/v_listeFichesVA.php';
    break;
case 'voirSuiviFrais':
    $infosFiche = filter_input(INPUT_POST, 'lstFiche', FILTER_SANITIZE_STRING);
    list($idVisiteur, $mois) = explode('-', $infosFiche);
    $infosVisiteur = $pdo->getNomPrenomVisiteur($idVisiteur);
    $lesFiches = $pdo->getLesFichesVA();
    include 'vues/v_listeFichesVA.php';
    $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $mois);
    $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $mois);
    $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteur, $mois);
    $nom = $infosVisiteur['nom'];
    $prenom = $infosVisiteur['prenom'];
    $numAnnee = substr($mois, 0, 4);
    $numMois = substr($mois, 4, 2);
    $libEtat = $lesInfosFicheFrais['libEtat'];
    $montantValide = $lesInfosFicheFrais['montantValide'];
    $nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
    $dateModif = dateAnglaisVersFrancais($lesInfosFicheFrais['dateModif']);
    include 'vues/v_suiviFrais.php';
}