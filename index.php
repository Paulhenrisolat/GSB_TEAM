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
$uc = filter_input(INPUT_GET, 'uc', FILTER_SANITIZE_STRING);
if ($uc && !$estConnecte) {
    $uc = 'connexion';
} elseif (empty($uc)) {
    $uc = 'accueil';
}
switch ($uc) {
case 'connexion':
    require 'vues/v_entete.php';
    include 'controleurs/c_connexion.php';
    break;
case 'accueil':
    require 'vues/v_entete.php';
    include 'controleurs/c_accueil.php';
    break;
case 'gererFrais':
    require 'vues/v_entete.php';
    if ($_SESSION['statut'] == 'Visiteur') {
        include 'controleurs/c_gererFrais.php';
        break;
    }
    else {
        header('Location: index.php');
        break;
    }
case 'etatFrais':
    require 'vues/v_entete.php';
    if ($_SESSION['statut'] == 'Visiteur') {
        include 'controleurs/c_etatFrais.php';
        break;
    }
    else {
        header('Location: index.php');
        break;
    }
case 'validationFrais':
    require 'vues/v_entete.php';
    if ($_SESSION['statut'] == 'Comptable') {
        include 'controleurs/c_valideFrais.php';
        break;
    }
    else {
        header('Location: index.php');
        break;
    }
case 'suiviFrais':
    require 'vues/v_entete.php';
    if ($_SESSION['statut'] == 'Comptable') {
        include 'controleurs/c_suiviFrais.php';
        break;
    }
    else {
        header('Location: index.php');
        break;
    }
case 'fraisPdf':
    include 'controleurs/c_pdf.php';
    break;
case 'deconnexion':
    require 'vues/v_entete.php';
    include 'controleurs/c_deconnexion.php';
    break;
}
require 'vues/v_pied.php';

function PopUpConnexion(){
    $message='✔️ Validation réussi ! Bonjour : ';
    echo '<script type="text/javascript">window.alert("'. $message . $_SESSION['prenom'] .'");</script>';
}
