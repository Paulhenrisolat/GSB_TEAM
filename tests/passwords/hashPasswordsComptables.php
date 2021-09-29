<?php

function getLesComptables($pdo)
{
    $req = 'select comptable.id as id, comptable.mdp as mdp from comptable';
    $res = $pdo->query($req);
    $lesLignes = $res->fetchAll();
    return $lesLignes;
}

$pdo = new PDO('mysql:host=localhost;dbname=gsb_frais', 'root', '');
$pdo->query('SET CHARACTER SET utf8');

$lesComptables = getLesComptables($pdo);
foreach($lesComptables as $unComptable)
    {
    $hashMdp = password_hash($unComptable['mdp'], PASSWORD_DEFAULT);
    $req = "UPDATE comptable SET mdp='" . $hashMdp . "' WHERE id='" . $unComptable['id'] . "';";
    $pdo->exec($req);
    }