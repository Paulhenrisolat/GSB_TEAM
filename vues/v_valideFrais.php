<hr>
<div class="row"> 
<h2>Validation des fiches de frais</h2>
<h3>Elément forfaitisés</h3>
<div class="col-md-4">
    <form action="index.php?uc=validationFrais&action=actualisationFraisForfaitises" 
          method="post" role="form">
              <?php
              foreach ($lesFraisForfait as $unFraisForfait) {
                  $libelle = $unFraisForfait['libelle'];
                  $idFrais = $unFraisForfait['idfrais'];
                  $quantite = $unFraisForfait['quantite'];
                  ?>
            <p> <?php echo htmlspecialchars($libelle) ?></p>
            <p><input type="number" name="lesFrais[<?php echo $idFrais ?>]" value="<?php echo $quantite ?>" ></p>
            <?php
        }
        ?>  
        <input id="ok" type="submit" value="Corriger" class="btn btn-success" 
               role="button">
        <input type="hidden" value="<?php echo $infosFiche ?>" name="infosFicheFrais">
        <input id="annuler" type="reset" value="Réinitialiser" class="btn btn-danger" 
               role="button">
    </form>
</div>
</div>
<hr>
<div class="row">
    <div class="panel panel-info">
        <div class="panel-heading">Descriptif des éléments hors forfait</div>
        <form action="index.php?uc=validationFrais&action=actualisationFraisHorsForfait" 
              method="post" role="form">
            <table class="table table-bordered table-responsive">
                <tr>
                    <th class="date">Date</th>
                    <th class="libelle">Libellé</th>
                    <th class='montant'>Montant</th>
                    <th/>
                </tr>
                <?php
                foreach ($lesFraisHorsForfait as $unFraisHorsForfait) {
                    $date = $unFraisHorsForfait['date'];
                    $libelle = htmlspecialchars($unFraisHorsForfait['libelle']);
                    $montant = $unFraisHorsForfait['montant'];
                    ?>
                    <tr>
                        <td><input type="char" value="<?php echo $date ?>" name="horsForfait"></td>
                        <td><input type="char" value="<?php echo $libelle ?>" name="horsForfait"></td>
                        <td><input type="char" value="<?php echo $montant ?>" name="horsForfait"></td>
                        <td>
                            <input id="ok" type="submit" value="Corriger" class="btn btn-success" 
                                   role="button">
                            <input type="hidden" value="<?php echo $infosFiche?>" name="infosFicheFrais">
                            <input id="annuler" type="reset" value="Réinitialiser" class="btn btn-danger" 
                                   role="button">
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </form>
    </div>  
</div>
<p> Nombre de justificatifs : <input type="char" value="<?php echo $nbJustificatifs ?>" readonly> </p>
<form action="" method="post" role="form">
    <input id="ok" type="submit" value="Valider" class="btn btn-success" 
           role="button">
    <input id="annuler" type="reset" value="Réinitialiser" class="btn btn-danger" 
           role="button">
</form>
