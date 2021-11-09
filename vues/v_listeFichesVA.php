<?php

?>
<h2>Les fiches de frais VA</h2>
<div class="row">
    <div class="col-md-4">
        <h3>Sélectionner une fiche : </h3>
    </div>
    <div class="col-md-4">
        <form action="index.php?uc=suiviFrais&action=voirSuiviFrais" 
              method="post" role="form">
            <div class="form-group">
                <label for="lstFiche" accesskey="n">Fiche : </label>
                <select id="lstFiche" name="lstFiche" class="form-control">
                    <?php
                    foreach ($lesFiches as $uneFiche) {
                        $mois = $uneFiche['mois'];
                        $id = $uneFiche['id'];
                        $numMois = $uneFiche['numMois'];
                        $nom = $uneFiche['nom'];
                        $prenom = $uneFiche['prenom'];
                        if ($mois == $ficheASelectionner['mois'] && $id == $ficheASelectionner['id']) {
                            ?>
                            <option selected value="<?php echo $mois ?>">
                                <?php echo $date . ' - ' . $nom . ' ' . $prenom ?> </option>
                            <?php
                        } else {
                            ?>
                            <option value="<?php echo $mois ?>">
                                <?php echo $date . ' - ' . $nom . ' ' . $prenom ?> </option>
                            <?php
                        }
                    }
                    ?>    

                </select>
            </div>
            <input id="ok" type="submit" value="Valider" class="btn btn-success" 
                   role="button">
            <input id="annuler" type="reset" value="Effacer" class="btn btn-danger" 
                   role="button">
        </form>
    </div>
</div>