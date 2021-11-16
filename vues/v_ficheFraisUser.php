<?php
/** Page de vue des admin pour les fiches de frais * */
?>


<h2>Validation des fiches de frais</h2>
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
          action="index.php?uc=validationFrais&action=chercherMois">
        <fieldset>
            <div class="form-group">
                <div class="input-group">
                    </span>
                    <label for="nom" accesskey="n">Mois : </label>
                    <select id="nom" name="nom" class="form-control">
                        <?php
                        foreach ($nomprenoms as &$value) { ?>
                            <option value= ><?php echo $value[0] . '&nbsp;' . $value[1]?> </option>
                        
                        
                    </select>
                </div>
            </div>
            <input id="valide" type="submit" value="Entrée" role="button">
        </fieldset>
    </form>
</div>
<!--<select name="IdMois">-->


