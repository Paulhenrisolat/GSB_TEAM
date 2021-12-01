<hr>
<h2>Validation des fiches de frais</h2>
<h3 style="color: #333">Elément forfaitisés</h3>
<div class="col-md-4">
    <form action="index.php?uc=validationFrais&action=button" 
              method="post" role="form">
    <?php
    foreach ($lesFraisForfait as $unFraisForfait) {
        $libelle = $unFraisForfait['libelle'];
        $quantite = $unFraisForfait['quantite'];
        ?>
        <p> <?php echo htmlspecialchars($libelle) ?></p>
        <p><input type="number" value="<?php echo $quantite ?>" ></p>
        <?php
    }
    ?>  
    <input id="ElementF" name="ElementF" type="submit" value="Corriger" class="btn btn-success" 
           role="button">
    <input id="ElementF" name="ElementF" type="submit" value="Reset" class="btn btn-danger" 
           role="button">
    </form>
</div>
<hr>
<div class="row">
    <div class="panel panel-info">
        <div class="panel-heading">Descriptif des éléments hors forfait</div>
        <table class="table table-bordered table-responsive">
            <tr>
                <th class="date">Date</th>
                <th class="libelle">Libellé</th>
                <th class='montant'>Montant</th>
                <th></th>
            </tr>
            <?php
            foreach ($lesFraisHorsForfait as $unFraisHorsForfait) {
                $date = $unFraisHorsForfait['date'];
                $libelle = htmlspecialchars($unFraisHorsForfait['libelle']);
                $montant = $unFraisHorsForfait['montant'];
                ?>
                <tr>
                    <td><input type="char" value="<?php echo $date ?>"></td>
                    <td><input type="char" value="<?php echo $libelle ?>"></td>
                    <td><input type="char" value="<?php echo $montant ?>"></td>
                    <td>
                        <input id="ok" type="submit" value="Corriger" class="btn btn-success" 
                               role="button">
                        <input id="annuler" type="reset" value="Réinitialiser" class="btn btn-danger" 
                               role="button">
                    </td>
                </tr>
                <?php
            }
            ?>
        </table>
    </div>  
</div>
<p> Nombre de justificatifs : <input type="char" value="<?php echo $nbJustificatifs ?>" readonly> </p>
<form action="" method="post" role="form">
    <input id="ok" type="submit" value="Valider" class="btn btn-success" 
           role="button">
    <input id="annuler" type="reset" value="Réinitialiser" class="btn btn-danger" 
           role="button">
</form>
