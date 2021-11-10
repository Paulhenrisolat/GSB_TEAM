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
//fiches frais des users

switch ($action) {
    case 'chercheNom':
        $noms = array();
        $nomprenoms = getVisiteur();
        foreach ($pdo->getVisiteur() as $visiteur) {
            $noms[] = $visiteur['nom'];
        }

        include'vues/v_ficheFraisUser.php';
        break;

    case 'chercherMois':
        $i1 = 0;
        $nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_STRING);
        foreach ($pdo->getLesMoisDisponibles($nom) as &$value1) {
            ?> <option value=<?php $i1 ?><?php
            echo $value1;
            $i++;
        }
        include'vues/v_ficheFraisUser.php';
        break;
    default :
        include'vues/v_ficheFraisUser.php';
        break;
}
   