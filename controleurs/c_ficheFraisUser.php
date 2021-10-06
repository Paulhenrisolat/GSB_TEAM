<?php

//fiches frais des users

include'vues/v_ficheFraisUser.php';

    $value = $pdo->GetUtilisateur();
    foreach()
    {
        ?> <option value= <?php $i ?> > <?php echo $value[0], '&nbsp;', $value[1] ;
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
    foreach($pdo->getLesMoisDisponibles($mois) as &$value1)
    {
        ?> <option value=<?php$i1?><?php echo $value1;
        $i++;
    }
 

                

