<?php

?>
<h2>Fiches de frais</h2>
<div class="row">
    <div class="col-md-4">
        <h3>Sélectionner un utilisateur : </h3>
    </div>
    <div class="col-md-4">
        <form action="index.php?uc=validationFrais&action=voirEtatFrais" 
              method="post" role="form">
            <div class="form-group">
                <label for="idU" accesskey="n">Utilisateur : </label>
                <select id="idU" name="idU" class="form-control">
                    <?php
                        foreach ($nomprenoms as & $value) { 
                            $id = $value[2];
                            if ($id == $idASelectionne) {
                            ?>
                            <option selected value="<?php echo $value[2] ?>">
                                <?php echo $value[0] . '&nbsp;' . $value[1] ?> </option>
                            <?php
                        } else {
                            ?>
                            <option value="<?php echo $value[2] ?>">
                                <?php echo $value[0] . '&nbsp;' . $value[1] ?> </option>
                            <?php
                        }
                    }
                    ?>    

                </select>
            </div>
            <input id="ok" type="submit" value="Valider" class="btn btn-success" 
                   role="button">
        </form>
    </div>
</div>

