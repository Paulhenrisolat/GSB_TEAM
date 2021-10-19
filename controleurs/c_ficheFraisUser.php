<?php

//fiches frais des users


$nom = '';
foreach ($pdo->getVisiteur() as &$value) {
   $nom .= $value[0]. '&nbsp;'. $value[1]. ';' ;
}
$_SESSION['nomprenom'] = $nom;

include'vues/v_ficheFraisUser.php';


     /*
    ?>
      <input type="submit" value="Envoyer" />
      
           </p>
</form>

       <select name="IdMois">
           <?php 
          $i1=0;
          $mois = filter_input(INPUT_POST, 'IdUtilisateur');
    foreach($pdo->GetMoisUtilisateur($mois) as &$value1)
    {
        ?> <option value=<?php$i1?><?php echo $value1;
        $i++;
    }