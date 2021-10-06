<?php

//fiches frais des users

include'vues/v_ficheFraisUser.php';
?>

<label for="exampleDataList" class="form-label">Liste des utilisateurs</label>
<input class="form-control" list="datalistOptions" id="exampleDataList" placeholder="Utilisateur">
<datalist id="datalistOptions">
    <?php 
    foreach($pdo->GetUtilisateur() as &$value)
    {
        ?> <option value=<?php echo $value[0], '&nbsp;', $value[1] ; ?>> <?php 
    }
    ?>
    
</datalist>