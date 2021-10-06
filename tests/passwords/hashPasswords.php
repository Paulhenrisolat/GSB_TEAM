<?php

function getLesUtilisateurs($pdo)
{
    $req = 'SELECT utilisateur.id AS id, utilisateur.mdp AS mdp FROM utilisateur';
    $res = $pdo->query($req);
    $lesLignes = $res->fetchAll();
    return $lesLignes;
}

$pdo = new PDO('mysql:host=localhost;dbname=gsb_frais', 'root', '');
$pdo->query('SET CHARACTER SET utf8');

$lesUtilisateurs = getLesUtilisateurs($pdo);
foreach($lesUtilisateurs as $unUtilisateur)
    {
    $hashMdp = password_hash($unUtilisateur['mdp'], PASSWORD_DEFAULT);
    $req = "UPDATE utilisateur SET mdp='" . $hashMdp . "' WHERE id='" . $unUtilisateur['id'] . "';";
    $pdo->exec($req);
    }