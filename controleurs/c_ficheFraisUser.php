<?php

//fiches frais des users

include'vues/v_ficheFraisUser.php';
?>
<label for="exampleDataList" class="form-label">Liste des utilisateurs</label>
<input class="form-control" list="ListUtilisateur" id="IdUtilisateur" placeholder="Utilisateur">
<datalist id="ListUtilisateur", style="width:535px">
    <?php 
    foreach($pdo->GetUtilisateur() as &$value)
    {
        ?> <option value=<?php echo $value[0], '&nbsp;', $value[1] ; ?>> <?php 
    }
    
    ?>
    
</datalist>
<input name="OK" type="button" value="Ok">
