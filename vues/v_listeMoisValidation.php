<?php

?>
<div class="row">
<form action="index.php?uc=validationFrais&action=voirEtatFrais" 
      method="post" role="form">
    <label for="infosFicheFrais" accesskey="n">Choisir le mois : </label>
    <select id="infosFicheFrais" name="infosFicheFrais">
    <?php
    foreach ($lesMois as $unMois) {
        $mois = $unMois['mois'];
        $numAnnee = $unMois['numAnnee'];
        $numMois = $unMois['numMois'];
        if ($mois == $moisASelectionner) {
            ?>
            <option selected value="<?php echo $mois . '-' . $idVisiteur ?>">
            <?php echo $numMois . '/' . $numAnnee ?> </option>
            <?php
        } else {
            ?>
            <option value="<?php echo $mois . '-' . $idVisiteur ?>">
            <?php echo $numMois . '/' . $numAnnee ?> </option>
            <?php
        }
    }
    ?>    
    </select>
    <input id="ok" type="submit" value="Valider" class="btn btn-success"
           role="button">
</form>
</div>