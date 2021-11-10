<?php
/**
 * Vue Accueil
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Réseau CERTA <contact@reseaucerta.org>
 * @author    José GIL <jgil@ac-nice.fr>
 * @copyright 2017 Réseau CERTA
 * @license   Réseau CERTA
 * @version   GIT: <0>
 * @link      http://www.reseaucerta.org Contexte « Laboratoire GSB »
 */



?>
<div id="accueil">
    <h2>
        Gestion des frais<small> -
        <?php echo $_SESSION['statut'] . " : " . $_SESSION['prenom'] . ' ' . $_SESSION['nom']; ?>
        </small>
    </h2>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <span class="glyphicon glyphicon-bookmark"></span>
                    Navigation
                </h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12 col-md-12">
                        <?php if ($_SESSION['statut'] == 'Visiteur') { ?>
                        <!-- Visiteur -->
                        <a href="index.php?uc=gererFrais&action=saisirFrais"
                           class="btn btn-success btn-lg" role="button">
                            <span class="glyphicon glyphicon-pencil"></span>
                            <br>Renseigner la fiche de frais</a>
                        <a href="index.php?uc=etatFrais&action=selectionnerMois"
                           class="btn btn-primary btn-lg" role="button">
                            <span class="glyphicon glyphicon-list-alt"></span>
                            <br>Afficher mes fiches de frais</a>
                        <?php } else { ?>
                        <!-- Comptable -->
                        <a href="index.php?uc=validationFrais"
                           class="btn btn-success btn-lg" role="button">
                            <span class="glyphicon glyphicon-ok-circle"></span>
                            <br>Validation des fiches de frais</a>
                        <a href="index.php?uc=suiviFrais&action=selectionnerFiche"
                           class="btn btn-primary btn-lg" role="button">
                            <span class="glyphicon glyphicon-search"></span>
                            <br>Suivi du paiement des fiches de frais</a>
                        <?php } ?>
<!--                    <a href="index.php?uc=verifMail"
                           class="btn btn-primary btn-lg" role="button">
                            <span class="glyphicon glyphicon-eye-open"></span>
                            <br>[TestVerifMail]</a>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>