<?php

/**
 * Description of c_topdf
 *
 * @author paul-henri.solat
 */
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
$idVisiteur = $_SESSION['idUtilisateur'];

switch ($action) {
case 'toPdf':
    $infosFichePDF = filter_input(INPUT_POST, 'infosFicheFraisPDF', FILTER_SANITIZE_STRING);
    list($idVisiteur, $leMois) = explode('-', $infosFichePDF);
    include 'tests/phpTopdf.php';
    break;
}
