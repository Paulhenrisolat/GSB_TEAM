<?php
/** Page de vue des admin pour les fiches de frais **/

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
    
<form method="post" action="index.php?uc=validationFrais">
        <p>
            <select name="IdUtilisateur">
                
      <input type="submit" value="Envoyer" />
           </p>
</form>

       <select name="IdMois">
           <?php 
          $i1=0;
          $mois = filter_input(INPUT_POST, 'IdUtilisateur');
    foreach($pdo->getLesMoisDisponibles($mois) as &$value1)
    {
        ?> <option value=<?php$i1?><?php echo $value1;
        $i++;
    }
 
