<?php 
                    $i=0;


   $values = $pdo->GetUtilisateur();
    foreach($values as &$value)
    {
        $_POST?>( <option value= <?php $i ?> > <?php echo $value[0], '&nbsp;', $value[1]);
        $i++;
    }
 

      
 

                

