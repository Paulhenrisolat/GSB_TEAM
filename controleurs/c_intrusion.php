<?php

$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
switch ($action) {
case 'afficherIntrusion':
    $lesIntrusions = $pdo->getLesIntrusions();
    include 'vues/v_afficherIntrusions.php';
    break;
}
