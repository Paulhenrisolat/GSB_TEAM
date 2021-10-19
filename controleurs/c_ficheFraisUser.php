<?php

//fiches frais des users

include'vues/v_ficheFraisUser.php';
?>
<form method="post" action="index.php?uc=validationFrais">
   <p>
      <select name="IdUtilisateur">
          <?php 
          $i=0;
    foreach($pdo->GetVisiteur() as &$value)
    {
        ?> <option value="<?php$i?>"><?php echo $value[0], '&nbsp;', $value[1] ;
        $i++;
    }
    
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

 

                

