<?php
/**
 * Gestion de la connexion
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
if (!$uc) {
    $uc = 'demandeconnexion';
}

switch ($action) {
case 'demandeConnexion':
    include 'vues/v_connexion.php';
    break;
case 'valideConnexion':
    $login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_STRING);
    $mdp = filter_input(INPUT_POST, 'mdp', FILTER_SANITIZE_STRING);
    $visiteur = $pdo->getInfosVisiteur($login);
    $comptable = $pdo->getInfosComptable($login);
    if (password_verify($mdp, $pdo->getMotDePasseVisiteur($login))) {
        $id = $visiteur['id'];
        $nom = $visiteur['nom'];
        $prenom = $visiteur['prenom'];
        connecter($id, $nom, $prenom);
        header('Location: index.php');
        include'vues/v_verifMail.php';
    }
    elseif (password_verify($mdp, $pdo->getMotDePasseComptable($login))) {
        $id = $comptable['id'];
        $nom = $comptable['nom'];
        $prenom = $comptable['prenom'];
        connecter($id, $nom, $prenom);
        header('Location: index.php');
        include'vues/v_verifMail.php';
    }
    else {
        ajouterErreur('Login ou mot de passe incorrect');
        include 'vues/v_erreurs.php';
        include 'vues/v_connexion.php';
    }
    break;
    
case 'verifmail':
    //code a2f
    $codeRand = rand(0,9999);
    //destinataire
    $to = "Papercut@papercut.com";
    //sujet
    $subject = "A2f GSB";
    //msg
    $message = "Vérification d'identité de ".filter_input(INPUT_POST, 'login', FILTER_SANITIZE_STRING)."\nCode : ".$codeRand; //
    //entete
    $headers =array('From'=> 'GSB@gmail.com');
    mail($to,$subject,$message, $headers);
    include'vues/v_verifMail.php';
    break;

default:
    include 'vues/v_connexion.php';
    break;
}
