<?php ?>

<h2>Fiches de frais des visiteurs</h2>
<div class="row">
    <div class="col-md-4">
        <h3>Sélectionner un mois : </h3>
    </div>
    <div class="col-md-4">
        <form action="index.php?uc=suiviFrais&action=voirSuiviFrais" 
              method="post" role="form">
            <div class="form-group">
                <label for="lstMois" accesskey="n">Mois et visiteur : </label>
                <select id="lstMois" name="lstMois" class="form-control">
                    <?php
                    foreach ($lesFiches as $uneFiche) {
                        $unMois = $uneFiche['mois'];
                        $numAnnee = $unMois['numAnnee'];
                        $numMois = $unMois['numMois'];
                        $cleMois = $unMois['mois'];
                        $nomVisiteur = $uneFiche['nomVisiteur'];
                        $prenomVisiteur = $uneFiche['prenomVisiteur'];
                        if ($cleMois == $moisASelectionner) {
                            ?>
                            <option selected value="<?php echo $cleMois ?>">
                                <?php echo $numMois . '/' . $numAnnee . ' - ' . $nomVisiteur . ' ' . $prenomVisiteur ?> </option>
                                <?php
                        } else {
                            ?>
                            <option value="<?php echo $cleMois ?>">
                                <?php echo $numMois . '/' . $numAnnee . ' - ' . $nomVisiteur . ' ' . $prenomVisiteur ?> </option>
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