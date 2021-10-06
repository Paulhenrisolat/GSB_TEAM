<?php
include'vues/v_verifMail.php';

$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);

switch ($action) {
case'testverifmail':
    $mdprand = filter_input(INPUT_POST, 'mdprand');
    if($mdprand == $codeRand)
    {
        include 'controleurs/c_accueil.php';
    }
    else
    {
        include 'v_erreurs.php';
    }
    break;
}
