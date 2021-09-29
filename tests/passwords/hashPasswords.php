<?php

function getLesVisiteurs($pdo)
{
    $req = 'select visiteur.id as id, visiteur.mdp as mdp from visiteur';
    $res = $pdo->query($req);
    $lesLignes = $res->fetchAll();
    return $lesLignes;
}

$pdo = new PDO('mysql:host=localhost;dbname=gsb_frais', 'root', '');
$pdo->query('SET CHARACTER SET utf8');

$lesVisiteurs = getLesVisiteurs($pdo);
foreach($lesVisiteurs as $unVisiteur)
    {
    $hashMdp = password_hash($unVisiteur['mdp'], PASSWORD_DEFAULT);
    $req = "UPDATE visiteur SET mdp='" . $hashMdp . "' WHERE id='" . $unVisiteur['id'] . "';";
    $pdo->exec($req);
    }