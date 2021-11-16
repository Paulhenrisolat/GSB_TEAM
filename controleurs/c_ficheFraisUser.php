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
//$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
////fiches frais des users
//$noms = array();
//        $nomprenoms = $pdo->getVisiteur();
//        foreach ($pdo->getVisiteur() as $visiteur) {
//            $noms[] = $visiteur['nom'];
//        }
//switch ($action) {
//    case 'chercheNom':
//        
//
//        include'vues/v_ficheFraisUser.php';
//        break;
//
//    case 'chercherMois':
//        $i1 = 0;
//        $nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_STRING);
//        foreach ($pdo->getLesMoisDisponibles($nom) as &$value1) {
//            ? <option value=<?php $i1 ??php
//            echo $value1;
//            $i++;
//        }
//        include'vues/v_ficheFraisUser.php';
//        break;
//    default :
//        include'vues/v_ficheFraisUser.php';
//        break;
//}
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
$action2 = filter_input(INPUT_GET, 'uc', FILTER_SANITIZE_STRING);
switch ($action || $action2) {
case 'validationFrais':
    $nomprenoms = $pdo->getVisiteur();
    // Afin de sélectionner par défaut le dernier mois dans la zone de liste
    // on demande toutes les clés, et on prend la première,
    // les mois étant triés décroissants
    include 'vues/v_listMoisPourComptable.php';
    break;
case 'voirEtatFrais':
    $idUtilisateur = filter_input(INPUT_POST, 'idU', FILTER_SANITIZE_STRING);
    $lesMois = $pdo->getLesMoisDisponibles($idUtilisateur);
    $idASelectionne = $idUtilisateur;
    include 'vues/v_listMoisPourComptable.php';
    $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $leMois);
    $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $leMois);
    $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteur, $leMois);
    $numAnnee = substr($leMois, 0, 4);
    $numMois = substr($leMois, 4, 2);
    $libEtat = $lesInfosFicheFrais['libEtat'];
    $montantValide = $lesInfosFicheFrais['montantValide'];
    $nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
    $dateModif = dateAnglaisVersFrancais($lesInfosFicheFrais['dateModif']);
    include 'vues/v_ficheFraisUser.php';
    break;
case 'topdf':
    include 'tests/phpTopdf.php';
}
   