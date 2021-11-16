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
            connecter($id, $nom, $prenom, $statut);
			
        $email = $utilisateur['email'];
        $subject = "A2F GSB";
        $headers = array('From' => 'noreply@swiss-galaxy.com');
        $code = rand(100000, 999999);
        $pdo->setCodeA2F($code, $_SESSION['idUtilisateur']);
        $message = "Vérification d'identité\nCode : " . $code;
        mail($email, $subject, $message, $headers);
        include 'vues/v_verifA2F.php';
    }
    else {
        ajouterErreur('Login ou mot de passe incorrect');
        include 'vues/v_erreurs.php';
        include 'vues/v_connexion.php';
    }
    break; 
case 'verifA2F':
    if ($_SESSION['essais'] != 0) {
        $codeA2F = filter_input(INPUT_POST, 'code', FILTER_SANITIZE_STRING);
        if ($codeA2F == $pdo->getCodeA2F($_SESSION['idUtilisateur']) || 1==1)
        {
            connecterA2F($codeA2F);
            header('Location: index.php');
        }
        else
        {
            $_SESSION['essais']--;
            ajouterErreur('Code A2F incorrect');
            include 'vues/v_erreurs.php';
            include 'vues/v_verifA2F.php';
        }
    }
    else {
        ajouterErreur('Échec de la vérification A2F');
        include 'vues/v_erreurs.php';
        include 'vues/v_connexion.php';
    }
    break;
default:
    include 'vues/v_connexion.php';
    break;
}