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
    $utilisateur = $pdo->getInfosUtilisateur($login);
    if (password_verify($mdp, $pdo->getMotDePasseUtilisateur($login))) {
        $id = $utilisateur['id'];
        $nom = $utilisateur['nom'];
        $prenom = $utilisateur['prenom'];
        $statut = $utilisateur['statut'];
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
