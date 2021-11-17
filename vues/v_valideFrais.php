<?php
/** Page de vue des admin pour les fiches de frais * */
?>


<!--<h2>Validation des fiches de frais</h2>
<h3>Elément forfaitisés</h3>

<a>Forfait Etape</a>
<p><input type="number" maxlength="250"/></p>
<a>Frais Kilométrique</a>
<p><input type="number" maxlength="250"/></p>
<a>Nuité Hôtel</a>
<p><input type="number" maxlength="250"/></p>
<a>Repas Restaurant</a>
<p><input type="number" maxlength="250"/></p>

<button class="btn btn-success" type="submit">Corriger</button>
<button class="btn btn-danger" type="reset">Réinitialiser</button>
<hr>
<p>Nombre de justificatifs : <input type="number"/></p>

<button class="btn btn-success" type="submit">Valider</button>
<button class="btn btn-danger" type="reset">Réinitialiser</button>

<div class="panel-body">
    <form role="form" method="post" 
          action="index.php?uc=validationFrais&action=voirEtatFrais">
        <fieldset>
            <div class="form-group">
                <div class="input-group">
                    </span>
                    <label for="nom" accesskey="n">List des utilisateur : </label>
                    <select id="nom" name="nom" class="form-control">
                        
                        
                    </select>
                </div>
            </div>
            <input id="valide" type="submit" value="Entrée" role="button">
        </fieldset>
    </form>
</div>-->
<hr>
<h2>Validation des fiches de frais</h2>
<h3 style="color: #333">Elément forfaitisés</h3>
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
<input id="ok" type="submit" value="Valider" class="btn btn-success" 
       role="button">
<input id="annuler" type="reset" value="Effacer" class="btn btn-danger" 
       role="button">
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
                <td><input id="ok" type="submit" value="Valider" class="btn btn-success" 
                           role="button">
                    <input id="annuler" type="reset" value="Effacer" class="btn btn-danger" 
                           role="button"></td>
            </tr>
            <?php
        }
        ?>
    </table>
</div>  


