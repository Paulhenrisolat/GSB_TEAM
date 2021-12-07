<?php

?>
<h2>Valider la fiche de frais</h2>
<form action="index.php?uc=validationFrais&action=chercheMois" 
      method="post" role="form">
    <label for="idVisiteur" accesskey="n">Choisir le visiteur : </label>
    <select id="idVisiteur" name="idVisiteur">
    <?php
    foreach ($lesInfosVisiteurs as & $infosVisiteur) {
        if ($infosVisiteur['id'] == $idASelectionner) {
            ?>
            <option selected value="<?php echo $infosVisiteur['id'] ?>">
            <?php echo $infosVisiteur['nom'] . '&nbsp;' . $infosVisiteur['prenom'] ?> </option>
            <?php
        } else {
            ?>
            <option value="<?php echo $infosVisiteur['id'] ?>">
            <?php echo $infosVisiteur['nom'] . '&nbsp;' . $infosVisiteur['prenom'] ?> </option>
            <?php
        }
    }
    ?>    
    </select>
    <input id="ok" type="submit" value="Valider" class="btn btn-success"
           role="button">
</form>


