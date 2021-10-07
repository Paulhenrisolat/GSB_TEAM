<?php
require 'vues/v_verifMail.php';

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
