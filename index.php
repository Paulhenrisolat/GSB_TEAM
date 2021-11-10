<?php
/**
 * Index du projet GSB
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    RÃ©seau CERTA <contact@reseaucerta.org>
 * @author    JosÃ© GIL <jgil@ac-nice.fr>
 * @copyright 2017 RÃ©seau CERTA
 * @license   RÃ©seau CERTA
 * @version   GIT: <0>
 * @link      http://www.reseaucerta.org Contexte Â« Laboratoire GSB Â»
 */
require_once 'includes/fct.inc.php';
require_once 'includes/class.pdogsb.inc.php';
session_start();
$pdo = PdoGsb::getPdoGsb();
$estConnecte = estConnecte();
require 'vues/v_entete.php';
$uc = filter_input(INPUT_GET, 'uc', FILTER_SANITIZE_STRING);
if ($uc && !$estConnecte) {
    $uc = 'connexion';
} elseif (empty($uc)) {
    $uc = 'accueil';
}
switch ($uc) {
case 'connexion':
    include 'controleurs/c_connexion.php';
    break;
case 'accueil':
    include 'controleurs/c_accueil.php';
    break;
case 'gererFrais':
    if ($_SESSION['statut'] == 'Visiteur') {
        include 'controleurs/c_gererFrais.php';
        break;
    }
    else {
        header('Location: index.php');
        break;
    }
case 'etatFrais':
    if ($_SESSION['statut'] == 'Visiteur') {
        include 'controleurs/c_etatFrais.php';
        break;
    }
    else {
        header('Location: index.php');
        break;
    }
case 'validationFrais':
    if ($_SESSION['statut'] == 'Comptable') {
        include 'controleurs/c_ficheFraisUser.php';
        break;
    }
    else {
        header('Location: index.php');
        break;
    }
case 'suiviFrais':
    if ($_SESSION['statut'] == 'Comptable') {
        include 'controleurs/c_suiviFrais.php';
        break;
    }
    else {
        header('Location: index.php');
        break;
    }
case 'deconnexion':
    include 'controleurs/c_deconnexion.php';
    break;
}
require 'vues/v_pied.php';

function PopUpConnexion(){
    $message='✔️ Validation réussi ! Bonjour : ';
    echo '<script type="text/javascript">window.alert("'. $message . $_SESSION['prenom'] .'");</script>';
}
