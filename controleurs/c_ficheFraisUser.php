<?php
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
//fiches frais des users

switch ($action) {
    case 'chercheNom':
        $nom = '';
        foreach ($pdo->getVisiteur() as &$value) {
            $nom .= '!' . $value[0] . '&nbsp;' . $value[1];
        }
        $_SESSION['nomprenom'] = $nom;

        include'vues/v_ficheFraisUser.php';
        break;

    case 'chercherMois':
        $i1 = 0;
        $nom = filter_input(INPUT_POST, 'IdUtilisateur');
        foreach ($pdo->getLesMoisDisponibles($nom) as &$value1) {
            ?> <option value=<?php $i1 ?><?php
            echo $value1;
            $i++;
        }
        break;
    default :
        include'vues/v_ficheFraisUser.php';
        break;
}
   