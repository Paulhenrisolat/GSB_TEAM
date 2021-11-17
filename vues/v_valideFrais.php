<?php
/** Page de vue des admin pour les fiches de frais * */
?>


<!--<h2>Validation des fiches de frais</h2>
<h3>Elément forfaitisés</h3>

<a>Forfait Etape</a>
<p><input type="number" maxlength="25"/></p>
<a>Frais Kilométrique</a>
<p><input type="number" maxlength="25"/></p>
<a>Nuité Hôtel</a>
<p><input type="number" maxlength="25"/></p>
<a>Repas Restaurant</a>
<p><input type="number" maxlength="25"/></p>

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
<div class="panel panel-primary">
    <div class="panel-heading">Fiche de frais du mois 
        <?php echo $numMois . '-' . $numAnnee ?> : </div>
    <div class="panel-body">
        <strong><u>Etat :</u></strong> <?php echo $libEtat ?>
        depuis le <?php echo $dateModif ?> <br> 
        <strong><u>Montant validé :</u></strong> <?php echo $montantValide ?>
    </div>
</div>
<div class="panel panel-info">
    <div class="panel-heading">Eléments forfaitisés</div>
    <table class="table table-bordered table-responsive">
        <tr>
            <?php
            foreach ($lesFraisForfait as $unFraisForfait) {
                $libelle = $unFraisForfait['libelle']; ?>
                <th> <?php echo htmlspecialchars($libelle) ?></th>
                <?php
            }
            ?>
        </tr>
        <tr>
            <?php
            foreach ($lesFraisForfait as $unFraisForfait) {
                $quantite = $unFraisForfait['quantite']; ?>
                <td class="qteForfait"><?php echo $quantite ?> </td>
                <?php
            }
            ?>
        </tr>
    </table>
</div>
<div class="panel panel-info">
    <div class="panel-heading">Descriptif des éléments hors forfait - 
        <?php echo $nbJustificatifs ?> justificatifs reçus</div>
    <table class="table table-bordered table-responsive">
        <tr>
            <th class="date">Date</th>
            <th class="libelle">Libellé</th>
            <th class='montant'>Montant</th>                
        </tr>
        <?php
        foreach ($lesFraisHorsForfait as $unFraisHorsForfait) {
            $date = $unFraisHorsForfait['date'];
            $libelle = htmlspecialchars($unFraisHorsForfait['libelle']);
            $montant = $unFraisHorsForfait['montant']; ?>
            <tr>
                <td><?php echo $date ?></td>
                <td><?php echo $libelle ?></td>
                <td><?php echo $montant ?></td>
            </tr>
            <?php
        }
        ?>
    </table>
</div>  


