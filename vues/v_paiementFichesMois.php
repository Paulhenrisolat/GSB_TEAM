<?php

?>

<hr>
<div class="row">
    <div class="col-md-4">
        <h3>Sélectionner un mois dont les fiches seront mises en paiement : </h3>
    </div>
    <div class="col-md-4">
        <form action="index.php?uc=suiviFrais&action=miseEnPaiementFichesMois" 
              method="post" role="form">
            <div class="form-group">
                <label for="moisFiches" accesskey="n">Fiche : </label>
                <select id="moisFiches" name="moisFiches" class="form-control">
                    <?php
                        foreach($lesMois as $unMois) {
                            $mois = $unMois['mois'];
                            $numAnnee = substr($mois, 0, 4);
                            $numMois = substr($mois, 4, 2);
                        ?>
                        <option value="<?php echo $mois ?>">
                            <?php echo $numMois . '/' . $numAnnee ?> </option>
                        <?php
                        }
                        ?>
                </select>
            </div>
            <input id="ok" type="submit" value="Mettre en paiement" class="btn btn-success" 
                   role="button">
        </form>
    </div>
</div>
