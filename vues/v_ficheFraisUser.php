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

<?php
$nom = $_SESSION['nomprenom'];
$info = explode("!", $nom);
?>
    <div class="panel-body">
        <form role="form" method="post" 
              action="index.php?uc=validationFrais&action=chercherMois">
            <fieldset>
                <div class="form-group">
                    <div class="input-group">
                        </span>
                        <select name="IdUtilisateur">
                            <?php
                            $i = 1;
                            while ($i != count($info)) {
                                $texte = $info[$i];
                                ?>
                                <option value= <?php $i ?> > <?php print($texte) ?> </option>
                                <?php
                                $i += 1;
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <input type="submit" value="Entrée">
            </fieldset>
        </form>
    </div>
<select name="IdMois">


