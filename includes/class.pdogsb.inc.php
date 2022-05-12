<?php

/**
 * Classe d'accès aux données.
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Cheri Bibi - Réseau CERTA <contact@reseaucerta.org>
 * @author    José GIL - CNED <jgil@ac-nice.fr>
 * @copyright 2017 Réseau CERTA
 * @license   Réseau CERTA
 * @version   GIT: <0>
 * @link      http://www.php.net/manual/fr/book.pdo.php PHP Data Objects sur php.net
 */

/**
 * Classe d'accès aux données.
 *
 * Utilise les services de la classe PDO
 * pour l'application GSB
 * Les attributs sont tous statiques,
 * les 4 premiers pour la connexion
 * $monPdo de type PDO
 * $monPdoGsb qui contiendra l'unique instance de la classe
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Cheri Bibi - Réseau CERTA <contact@reseaucerta.org>
 * @author    José GIL <jgil@ac-nice.fr>
 * @copyright 2017 Réseau CERTA
 * @license   Réseau CERTA
 * @version   Release: 1.0
 * @link      http://www.php.net/manual/fr/book.pdo.php PHP Data Objects sur php.net
 */
class PdoGsb {

    private static $serveur = 'mysql:host=localhost';
    private static $bdd = 'dbname=gsb_frais';
    private static $user = 'userGsb';
    private static $mdp = 'secret';
    private static $monPdo;
    private static $monPdoGsb = null;

    /**
     * Constructeur privé, crée l'instance de PDO qui sera sollicitée
     * pour toutes les méthodes de la classe
     */
    private function __construct() {
        PdoGsb::$monPdo = new PDO(
                PdoGsb::$serveur . ';' . PdoGsb::$bdd,
                PdoGsb::$user,
                PdoGsb::$mdp
        );
        PdoGsb::$monPdo->query('SET CHARACTER SET utf8');
    }

    /**
     * Méthode destructeur appelée dès qu'il n'y a plus de référence sur un
     * objet donné, ou dans n'importe quel ordre pendant la séquence d'arrêt.
     */
    public function __destruct() {
        PdoGsb::$monPdo = null;
    }

    /**
     * Fonction statique qui crée l'unique instance de la classe
     * Appel : $instancePdoGsb = PdoGsb::getPdoGsb();
     *
     * @return l'unique objet de la classe PdoGsb
     */
    public static function getPdoGsb() {
        if (PdoGsb::$monPdoGsb == null) {
            PdoGsb::$monPdoGsb = new PdoGsb();
        }
        return PdoGsb::$monPdoGsb;
    }

    /**
     * Retourne les informations d'un visiteur
     *
     * @param String $login Login du visiteur
     * @param String $mdp   Mot de passe du visiteur
     *
     * @return l'id, le nom et le prénom sous la forme d'un tableau associatif
     */
    public function getInfosVisiteur($login) {
        $requetePrepare = PdoGsb::$monPdo->prepare(
                'SELECT utilisateur.id AS id, utilisateur.nom AS nom, '
                . 'utilisateur.prenom AS prenom '
                . 'FROM utilisateur '
                . 'WHERE utilisateur.login = :unLogin AND utilisateur.statut = :leStatut'
        );
        $requetePrepare->bindParam(':unLogin', $login, PDO::PARAM_STR);
        $requetePrepare->bindValue(':leStatut', 'Visiteur', PDO::PARAM_STR);
        $requetePrepare->execute();
        return $requetePrepare->fetch();
    }

    /**
     * Retourne le nom et prénom d'un visiteur
     *
     * @param String $idVisiteur ID du visiteur
     *
     * @return le nom et le prénom sous la forme d'un tableau associatif
     */
    public function getNomPrenomVisiteur($idVisiteur) {
        $requetePrepare = PdoGsb::$monPdo->prepare(
                'SELECT utilisateur.nom AS nom, utilisateur.prenom AS prenom '
                . 'FROM utilisateur '
                . 'WHERE utilisateur.id = :idVisiteur AND utilisateur.statut = :leStatut'
        );
        $requetePrepare->bindParam(':idVisiteur', $idVisiteur, PDO::PARAM_STR);
        $requetePrepare->bindValue(':leStatut', 'Visiteur', PDO::PARAM_STR);
        $requetePrepare->execute();
        return $requetePrepare->fetch();
    }

    /**
     * Retourne les informations d'un utilisateur
     *
     * @param String $login Login de l'utilisateur
     *
     * @return l'id, le nom, le prénom, le statut et l'email sous la forme d'un tableau associatif
     */
    public function getInfosUtilisateur($login) {
        $requetePrepare = PdoGsb::$monPdo->prepare(
                'SELECT utilisateur.id AS id, utilisateur.nom AS nom, '
                . 'utilisateur.prenom AS prenom, utilisateur.statut AS statut, '
                . 'utilisateur.email AS email '
                . 'FROM utilisateur '
                . 'WHERE utilisateur.login = :unLogin'
        );
        $requetePrepare->bindParam(':unLogin', $login, PDO::PARAM_STR);
        $requetePrepare->execute();
        return $requetePrepare->fetch();
    }

    /**
     * Retourne les informations principales d'un visiteur qui a des fiche dans l'état CL
     *
     * @return l'id, le nom, le prénom, le statut et l'email sous la forme d'un tableau associatif
     */
    public function getLesVisiteursCL() {
        $requetePrepare = PdoGsb::$monPdo->prepare(
                'SELECT distinct utilisateur.id AS id, utilisateur.nom AS nom, utilisateur.prenom AS prenom '
                . 'FROM utilisateur inner join fichefrais on utilisateur.id = fichefrais.idvisiteur '
                . 'WHERE utilisateur.statut = :leStatut and fichefrais.idetat = :idEtat '
                . 'ORDER BY utilisateur.nom, utilisateur.prenom'
        );
        $requetePrepare->bindValue(':leStatut', 'Visiteur', PDO::PARAM_STR);
        $requetePrepare->bindValue(':idEtat', 'CL', PDO::PARAM_STR);
        $requetePrepare->execute();
        $lesVisiteurs = array();
        while ($leVisiteur = $requetePrepare->fetch()) {
            $lesVisiteurs[] = array(
                'id' => $leVisiteur['id'],
                'nom' => $leVisiteur['nom'],
                'prenom' => $leVisiteur['prenom']
            );
        }
        return $lesVisiteurs;
    }

    /**
     * Retourne le mot de passe d'un utilisateur
     *
     * @param String $login Login de l'utilisateur
     *
     * @return le mot de passe
     */
    public function getMotDePasseUtilisateur($login) {
        $requetePrepare = PdoGsb::$monPdo->prepare(
                'SELECT utilisateur.mdp AS mdp '
                . 'FROM utilisateur '
                . 'WHERE utilisateur.login = :unLogin'
        );
        $requetePrepare->bindParam(':unLogin', $login, PDO::PARAM_STR);
        $requetePrepare->execute();
        return $requetePrepare->fetch()['mdp'];
    }

    /**
     * Retourne sous la forme d'un tableau associatif tous les véhicules
     * enregistrés dans la base de données.
     * 
     * @return tous les véhicules sous la forme d'un tableau associatif
     */
    public function getLesVehicules()
    {
        $requetePrepare = PdoGsb::$monPdo->prepare(
            'SELECT * FROM vehicules '
            . 'ORDER BY vehicules.prixkm'
        );
        $requetePrepare->execute();
        return $requetePrepare->fetchAll();
    }
    
    /**
     * Retourne sous la forme d'un tableau associatif le véhicule
     * concerné par l'argument.
     * 
     * @return un véhicule sous la forme d'un tableau associatif
     */
    public function getLeVehicule($idVehicule)
    {
        $requetePrepare = PdoGsb::$monPdo->prepare(
            'SELECT vehicules.id as id, vehicules.libelle as libelle, '
            . 'vehicules.prixkm as prixkm '
            . 'FROM vehicules '
            . 'WHERE id = :idVehicule'
        );
        $requetePrepare->bindParam(':idVehicule', $idVehicule, PDO::PARAM_STR);
        $requetePrepare->execute();
        return $requetePrepare->fetch();
    }
    
    /**
     * Retourne sous forme d'un tableau associatif toutes les lignes de frais
     * hors forfait concernées par les deux arguments.
     * La boucle foreach ne peut être utilisée ici car on procède
     * à une modification de la structure itérée - transformation du champ date-
     *
     * @param String $idVisiteur ID du visiteur
     * @param String $mois       Mois sous la forme aaaamm
     *
     * @return tous les champs des lignes de frais hors forfait sous la forme
     * d'un tableau associatif
     */
    public function getLesFraisHorsForfait($idVisiteur, $mois) {
        $requetePrepare = PdoGsb::$monPdo->prepare(
                'SELECT * FROM lignefraishorsforfait '
                . 'WHERE lignefraishorsforfait.idvisiteur = :unIdVisiteur '
                . 'AND lignefraishorsforfait.mois = :unMois'
        );
        $requetePrepare->bindParam(':unIdVisiteur', $idVisiteur, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unMois', $mois, PDO::PARAM_STR);
        $requetePrepare->execute();
        $lesLignes = $requetePrepare->fetchAll();
        for ($i = 0; $i < count($lesLignes); $i++) {
            $date = $lesLignes[$i]['date'];
            $lesLignes[$i]['date'] = dateAnglaisVersFrancais($date);
        }
        return $lesLignes;
    }

    /**
     * Retourne le nombre de justificatif d'un visiteur pour un mois donné
     *
     * @param String $idVisiteur ID du visiteur
     * @param String $mois       Mois sous la forme aaaamm
     *
     * @return le nombre entier de justificatifs
     */
    public function getNbjustificatifs($idVisiteur, $mois) {
        $requetePrepare = PdoGsb::$monPdo->prepare(
                'SELECT fichefrais.nbjustificatifs as nb FROM fichefrais '
                . 'WHERE fichefrais.idvisiteur = :unIdVisiteur '
                . 'AND fichefrais.mois = :unMois'
        );
        $requetePrepare->bindParam(':unIdVisiteur', $idVisiteur, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unMois', $mois, PDO::PARAM_STR);
        $requetePrepare->execute();
        $laLigne = $requetePrepare->fetch();
        return $laLigne['nb'];
    }

    /**
     * Retourne sous forme d'un tableau associatif toutes les lignes de frais
     * au forfait concernées par les deux arguments
     *
     * @param String $idVisiteur ID du visiteur
     * @param String $mois       Mois sous la forme aaaamm
     *
     * @return l'id, le libelle et la quantité sous la forme d'un tableau
     * associatif
     */
    public function getLesFraisForfait($idVisiteur, $mois) {
        $requetePrepare = PdoGSB::$monPdo->prepare(
                'SELECT fraisforfait.id as idfrais, '
                . 'fraisforfait.libelle as libelle, '
                . 'fraisforfait.montant as montantunitaire, '
                . 'lignefraisforfait.quantite as quantite '
                . 'FROM lignefraisforfait '
                . 'INNER JOIN fraisforfait '
                . 'ON fraisforfait.id = lignefraisforfait.idfraisforfait '
                . 'WHERE lignefraisforfait.idvisiteur = :unIdVisiteur '
                . 'AND lignefraisforfait.mois = :unMois '
                . 'ORDER BY lignefraisforfait.idfraisforfait'
        );
        $requetePrepare->bindParam(':unIdVisiteur', $idVisiteur, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unMois', $mois, PDO::PARAM_STR);
        $requetePrepare->execute();
        return $requetePrepare->fetchAll();
    }
    
    public function getLesIntrusions() {
        $requetePrepare = PdoGSB::$monPdo->prepare(
                'SELECT tentativeintrusion.horodatage as horodatage, '
                . 'tentativeintrusion.login as login, '
                . 'tentativeintrusion.pays as pays, '
                . 'tentativeintrusion.navigateur as navigateur, '
                . 'tentativeintrusion.os as os '
                . 'FROM tentativeintrusion '
                . 'ORDER BY tentativeintrusion.horodatage'
        );
        $requetePrepare->execute();
        return $requetePrepare->fetchAll();
    }

    /**
     * Retourne tous les id de la table FraisForfait
     *
     * @return un tableau associatif
     */
    public function getLesIdFrais() {
        $requetePrepare = PdoGsb::$monPdo->prepare(
                'SELECT fraisforfait.id as idfrais '
                . 'FROM fraisforfait ORDER BY fraisforfait.id'
        );
        $requetePrepare->execute();
        return $requetePrepare->fetchAll();
    }

    /**
     * Retourne le code d'authentification à double facteurs d'un utilisateur
     *
     * @param String $id ID de l'utilisateur
     *
     * @return le code A2F
     */
    public function getCodeA2F($id) {
        $requetePrepare = PdoGSB::$monPdo->prepare(
                'SELECT utilisateur.codea2f AS codea2f '
                . 'FROM utilisateur '
                . 'WHERE utilisateur.id = :unId'
        );
        $requetePrepare->bindParam(':unId', $id, PDO::PARAM_STR);
        $requetePrepare->execute();
        return $requetePrepare->fetch()['codea2f'];
    }

    /**
     * Retourne le code d'authentification à double facteurs d'un utilisateur
     *
     * @param Int $codeAuth Code de l'utilisateur
     * @param String $id    ID de l'utilisateur
     *
     * @return null
     */
    public function setCodeA2F($codeAuth, $id) {
        $requetePrepare = PdoGSB::$monPdo->prepare(
                'UPDATE utilisateur '
                . 'SET utilisateur.codea2f = :unCode '
                . 'WHERE utilisateur.id = :unId'
        );
        $requetePrepare->bindParam(':unCode', $codeAuth, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unId', $id, PDO::PARAM_STR);
        $requetePrepare->execute();
    }

    /**
     * Met à jour la table ligneFraisForfait
     * Met à jour la table ligneFraisForfait pour un visiteur et
     * un mois donné en enregistrant les nouveaux montants
     *
     * @param String $idVisiteur ID du visiteur
     * @param String $mois       Mois sous la forme aaaamm
     * @param Array  $lesFrais   tableau associatif de clé idFrais et
     *                           de valeur la quantité pour ce frais
     *
     * @return null
     */
    public function majFraisForfait($idVisiteur, $mois, $lesFrais) {
        $lesCles = array_keys($lesFrais);
        foreach ($lesCles as $unIdFrais) {
            $qte = $lesFrais[$unIdFrais];
            $requetePrepare = PdoGSB::$monPdo->prepare(
                    'UPDATE lignefraisforfait '
                    . 'SET lignefraisforfait.quantite = :uneQte '
                    . 'WHERE lignefraisforfait.idvisiteur = :unIdVisiteur '
                    . 'AND lignefraisforfait.mois = :unMois '
                    . 'AND lignefraisforfait.idfraisforfait = :idFrais'
            );
            $requetePrepare->bindParam(':uneQte', $qte, PDO::PARAM_INT);
            $requetePrepare->bindParam(':unIdVisiteur', $idVisiteur, PDO::PARAM_STR);
            $requetePrepare->bindParam(':unMois', $mois, PDO::PARAM_STR);
            $requetePrepare->bindParam(':idFrais', $unIdFrais, PDO::PARAM_STR);
            $requetePrepare->execute();
        }
    }
    
    public function majFicheVehicule($idVisiteur, $mois, $idVehicule)
    {
        $requetePrepare = PdoGSB::$monPdo->prepare(
                'UPDATE fichefrais '
                . 'SET fichefrais.idvehicule = :idVehicule '
                . 'WHERE fichefrais.idvisiteur = :unIdVisiteur '
                . 'AND fichefrais.mois = :unMois'
            );
        $requetePrepare->bindParam(':unIdVisiteur', $idVisiteur, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unMois', $mois, PDO::PARAM_STR);
        $requetePrepare->bindParam(':idVehicule', $idVehicule, PDO::PARAM_STR);
        $requetePrepare->execute();
    }

    /**
     * Met à jour la table ligneFraisHorsForfait
     * Met à jour la table ligneFraisHorsForfait pour un visiteur,
     * un mois et un id donné en enregistrant les nouveaux montants
     *
     * @param String $idVisiteur    ID du visiteur
     * @param String $mois          Mois sous la forme aaaamm
     * @param Date   $date          Date de la ligne HorsForfait a modifier (Y-M-D)
     * @param String $libelle       Libelle de la ligne HorsForfait a modifier
     * @param Int    $montant       Montant de la ligne HorsForfait a modifier
     * @param String $idHorsForfait Id de la ligneFraisHorsForfait
     * 
     * @return null
     */
    public function majFraisHorsForfait($idVisiteur, $mois, $date, $libelle, $montant, $idHorsForfait) {
        $requetePrepare = PdoGSB::$monPdo->prepare(
                'UPDATE lignefraishorsforfait '
                . 'SET lignefraishorsforfait.montant = :unMontant, lignefraishorsforfait.libelle = :unLibelle, lignefraishorsforfait.date = :uneDate '
                . 'WHERE lignefraishorsforfait.idvisiteur = :unIdVisiteur '
                . 'AND lignefraishorsforfait.mois = :unMois '
                . 'AND lignefraishorsforfait.id = :unId'
        );
        $requetePrepare->bindParam(':unMontant', $montant, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unLibelle', $libelle, PDO::PARAM_STR);
        $requetePrepare->bindParam(':uneDate', $date, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unIdVisiteur', $idVisiteur, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unMois', $mois, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unId', $idHorsForfait, PDO::PARAM_STR);
        $requetePrepare->execute();
    }
    
    /**
     * Met à jour la table ligneFraisHorsForfait
     * Rajoute "REFUSER:" devant le libelle
     *
     * @param String $idVisiteur    ID du visiteur
     * @param String $mois          Mois sous la forme aaaamm
     * @param String $libelle       Libelle de la ligne HorsForfait a modifier
     * @param String $idHorsForfait Id de la ligneFraisHorsForfait
     * 
     * @return null
     */
    public function refuserFraisHorsForfait($idVisiteur, $mois, $libelle, $idHorsForfait){
        if(!preg_match("/^(REFUSER:)/",$libelle)){
            $libelle = "REFUSER:" . $libelle;
        }
        $requetePrepare = PdoGSB::$monPdo->prepare(
                'UPDATE lignefraishorsforfait '
                . 'SET lignefraishorsforfait.libelle = :unLibelle '
                . 'WHERE lignefraishorsforfait.idvisiteur = :unIdVisiteur '
                . 'AND lignefraishorsforfait.mois = :unMois '
                . 'AND lignefraishorsforfait.id = :unId'
        );
        $requetePrepare->bindParam(':unLibelle', $libelle, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unIdVisiteur', $idVisiteur, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unMois', $mois, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unId', $idHorsForfait, PDO::PARAM_STR);
        $requetePrepare->execute();
    }
    
    /**
     * Met à jour la table ligneFraisHorsForfait
     * Enleve "REFUSER:" devant le libelle
     *
     * @param String $idVisiteur    ID du visiteur
     * @param String $mois          Mois sous la forme aaaamm
     * @param String $libelle       Libelle de la ligne HorsForfait a modifier
     * @param String $idHorsForfait Id de la ligneFraisHorsForfait
     * 
     * @return null
     */
    public function annulerFraisHorsForfait($idVisiteur, $mois, $libelle, $idHorsForfait){
        if(preg_match("/^(REFUSER:)/",$libelle)){
            list($refuser, $libelle) = explode(':', $libelle);
        }
        $requetePrepare = PdoGSB::$monPdo->prepare(
                'UPDATE lignefraishorsforfait '
                . 'SET lignefraishorsforfait.libelle = :unLibelle '
                . 'WHERE lignefraishorsforfait.idvisiteur = :unIdVisiteur '
                . 'AND lignefraishorsforfait.mois = :unMois '
                . 'AND lignefraishorsforfait.id = :unId'
        );
        $requetePrepare->bindParam(':unLibelle', $libelle, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unIdVisiteur', $idVisiteur, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unMois', $mois, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unId', $idHorsForfait, PDO::PARAM_STR);
        $requetePrepare->execute();
    }

    /**
     * Met à jour le nombre de justificatifs de la table ficheFrais
     * pour le mois et le visiteur concerné
     *
     * @param String  $idVisiteur      ID du visiteur
     * @param String  $mois            Mois sous la forme aaaamm
     * @param Integer $nbJustificatifs Nombre de justificatifs
     *
     * @return null
     */
    public function majNbJustificatifs($idVisiteur, $mois, $nbJustificatifs) {
        $requetePrepare = PdoGB::$monPdo->prepare(
                'UPDATE fichefrais '
                . 'SET nbjustificatifs = :unNbJustificatifs '
                . 'WHERE fichefrais.idvisiteur = :unIdVisiteur '
                . 'AND fichefrais.mois = :unMois'
        );
        $requetePrepare->bindParam(
                ':unNbJustificatifs',
                $nbJustificatifs,
                PDO::PARAM_INT
        );
        $requetePrepare->bindParam(':unIdVisiteur', $idVisiteur, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unMois', $mois, PDO::PARAM_STR);
        $requetePrepare->execute();
    }

    /**
     * Teste si un visiteur possède une fiche de frais pour le mois passé en argument
     *
     * @param String $idVisiteur ID du visiteur
     * @param String $mois       Mois sous la forme aaaamm
     *
     * @return vrai ou faux
     */
    public function estPremierFraisMois($idVisiteur, $mois) {
        $boolReturn = false;
        $requetePrepare = PdoGsb::$monPdo->prepare(
                'SELECT fichefrais.mois FROM fichefrais '
                . 'WHERE fichefrais.mois = :unMois '
                . 'AND fichefrais.idvisiteur = :unIdVisiteur'
        );
        $requetePrepare->bindParam(':unMois', $mois, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unIdVisiteur', $idVisiteur, PDO::PARAM_STR);
        $requetePrepare->execute();
        if (!$requetePrepare->fetch()) {
            $boolReturn = true;
        }
        return $boolReturn;
    }

    /**
     * Retourne le dernier mois en cours d'un visiteur
     *
     * @param String $idVisiteur ID du visiteur
     *
     * @return le mois sous la forme aaaamm
     */
    public function dernierMoisSaisi($idVisiteur) {
        $requetePrepare = PdoGsb::$monPdo->prepare(
                'SELECT MAX(mois) as dernierMois '
                . 'FROM fichefrais '
                . 'WHERE fichefrais.idvisiteur = :unIdVisiteur'
        );
        $requetePrepare->bindParam(':unIdVisiteur', $idVisiteur, PDO::PARAM_STR);
        $requetePrepare->execute();
        $laLigne = $requetePrepare->fetch();
        $dernierMois = $laLigne['dernierMois'];
        return $dernierMois;
    }

    /**
     * Crée une nouvelle fiche de frais et les lignes de frais au forfait
     * pour un visiteur et un mois donnés
     *
     * Récupère le dernier mois en cours de traitement, met à 'CL' son champs
     * idEtat, crée une nouvelle fiche de frais avec un idEtat à 'CR' et crée
     * les lignes de frais forfait de quantités nulles
     *
     * @param String $idVisiteur ID du visiteur
     * @param String $mois       Mois sous la forme aaaamm
     *
     * @return null
     */
    public function creeNouvellesLignesFrais($idVisiteur, $mois) {
        $dernierMois = $this->dernierMoisSaisi($idVisiteur);
        $laDerniereFiche = $this->getLesInfosFicheFrais($idVisiteur, $dernierMois);
        if ($laDerniereFiche['idEtat'] == 'CR') {
            $this->majEtatFicheFrais($idVisiteur, $dernierMois, 'CL');
        }
        $requetePrepare = PdoGsb::$monPdo->prepare(
                'INSERT INTO fichefrais (idvisiteur,mois,nbjustificatifs,'
                . 'montantvalide,datemodif,idetat,idvehicule) '
                . "VALUES (:unIdVisiteur,:unMois,0,0,now(),'CR','4CV-E')"
        );
        $requetePrepare->bindParam(':unIdVisiteur', $idVisiteur, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unMois', $mois, PDO::PARAM_STR);
        $requetePrepare->execute();
        $lesIdFrais = $this->getLesIdFrais();
        foreach ($lesIdFrais as $unIdFrais) {
            $requetePrepare = PdoGsb::$monPdo->prepare(
                    'INSERT INTO lignefraisforfait (idvisiteur,mois,'
                    . 'idfraisforfait,quantite) '
                    . 'VALUES(:unIdVisiteur, :unMois, :idFrais, 0)'
            );
            $requetePrepare->bindParam(':unIdVisiteur', $idVisiteur, PDO::PARAM_STR);
            $requetePrepare->bindParam(':unMois', $mois, PDO::PARAM_STR);
            $requetePrepare->bindParam(
                    ':idFrais',
                    $unIdFrais['idfrais'],
                    PDO::PARAM_STR
            );
            $requetePrepare->execute();
        }
    }

    /**
     * Crée un nouveau frais hors forfait pour un visiteur un mois donné
     * à partir des informations fournies en paramètre
     *
     * @param String $idVisiteur ID du visiteur
     * @param String $mois       Mois sous la forme aaaamm
     * @param String $libelle    Libellé du frais
     * @param String $date       Date du frais au format français jj//mm/aaaa
     * @param Float  $montant    Montant du frais
     *
     * @return null
     */
    public function creeNouveauFraisHorsForfait(
            $idVisiteur,
            $mois,
            $libelle,
            $date,
            $montant
    ) {
        $dateFr = dateFrancaisVersAnglais($date);
        $requetePrepare = PdoGSB::$monPdo->prepare(
                'INSERT INTO lignefraishorsforfait '
                . 'VALUES (null, :unIdVisiteur,:unMois, :unLibelle, :uneDateFr,'
                . ':unMontant) '
        );
        $requetePrepare->bindParam(':unIdVisiteur', $idVisiteur, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unMois', $mois, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unLibelle', $libelle, PDO::PARAM_STR);
        $requetePrepare->bindParam(':uneDateFr', $dateFr, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unMontant', $montant, PDO::PARAM_INT);
        $requetePrepare->execute();
    }
    
    public function ajouterNouvelleIntrusion(
            $horodatage,
            $login,
            $pays,
            $navigateur,
            $os
    ) {
        $requetePrepare = PdoGSB::$monPdo->prepare(
                'INSERT INTO tentativeintrusion(horodatage, login, pays, navigateur, os) '
                . ' VALUES (:unHorodatage, :unLogin, :unPays, :unNavigateur,:unOS) '
        );
        $requetePrepare->bindParam(':unHorodatage', $horodatage, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unLogin', $login, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unPays', $pays, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unNavigateur', $navigateur, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unOS', $os, PDO::PARAM_STR);
        $requetePrepare->execute();
    }

    /**
     * Supprime le frais hors forfait dont l'id est passé en argument
     *
     * @param String $idFrais ID du frais
     *
     * @return null
     */
    public function supprimerFraisHorsForfait($idFrais) {
        $requetePrepare = PdoGSB::$monPdo->prepare(
                'DELETE FROM lignefraishorsforfait '
                . 'WHERE lignefraishorsforfait.id = :unIdFrais'
        );
        $requetePrepare->bindParam(':unIdFrais', $idFrais, PDO::PARAM_STR);
        $requetePrepare->execute();
    }

    /**
     * Retourne les mois pour lesquels un visiteur a une fiche de frais
     *
     * @param String $idVisiteur ID du visiteur
     *
     * @return un tableau associatif de clé un mois -aaaamm- et de valeurs
     *         l'année et le mois correspondant
     */
    public function getLesMoisDisponibles($idVisiteur) {
        $requetePrepare = PdoGSB::$monPdo->prepare(
                'SELECT fichefrais.mois AS mois FROM fichefrais '
                . 'WHERE fichefrais.idvisiteur = :unIdVisiteur '
                . 'ORDER BY fichefrais.mois desc'
        );
        $requetePrepare->bindParam(':unIdVisiteur', $idVisiteur, PDO::PARAM_STR);
        $requetePrepare->execute();
        $lesMois = array();
        while ($laLigne = $requetePrepare->fetch()) {
            $mois = $laLigne['mois'];
            $numAnnee = substr($mois, 0, 4);
            $numMois = substr($mois, 4, 2);
            $lesMois[] = array(
                'mois' => $mois,
                'numAnnee' => $numAnnee,
                'numMois' => $numMois
            );
        }
        return $lesMois;
    }

    /**
     * Retourne les mois pour lesquels un visiteur a une fiche de frais qui est dans l'état CL
     *
     * @param String $idVisiteur ID du visiteur
     *
     * @return un tableau associatif de clé un mois -aaaamm- et de valeurs
     *         l'année et le mois correspondant
     */
    public function getLesMoisDisponiblesCL($idVisiteur) {
        $requetePrepare = PdoGSB::$monPdo->prepare(
                'SELECT fichefrais.mois AS mois FROM fichefrais '
                . 'WHERE fichefrais.idvisiteur = :unIdVisiteur and fichefrais.idetat = :idEtat '
                . 'ORDER BY fichefrais.mois asc'
        );
        $requetePrepare->bindValue(':unIdVisiteur', $idVisiteur, PDO::PARAM_STR);
        $requetePrepare->bindValue(':idEtat', 'CL', PDO::PARAM_STR);
        $requetePrepare->execute();
        $lesMois = array();
        while ($laLigne = $requetePrepare->fetch()) {
            $mois = $laLigne['mois'];
            $numAnnee = substr($mois, 0, 4);
            $numMois = substr($mois, 4, 2);
            $lesMois[] = array(
                'mois' => $mois,
                'numAnnee' => $numAnnee,
                'numMois' => $numMois
            );
        }
        return $lesMois;
    }

    /**
     * Retourne les fiches à valider et mettre en paiement des visiteurs
     *
     * @return les fiches à valider et mettre en paiement sous la forme d'un tableau
     */
    public function getLesFichesVA() {
        $requetePrepare = PdoGSB::$monPdo->prepare(
                'SELECT utilisateur.id AS idVisiteur, utilisateur.nom AS nom, '
                . 'utilisateur.prenom AS prenom, fichefrais.mois AS mois '
                . 'FROM fichefrais INNER JOIN utilisateur ON fichefrais.idvisiteur = utilisateur.id '
                . 'WHERE fichefrais.idetat = :idEtat and utilisateur.statut = :statutVisiteur '
                . 'ORDER BY fichefrais.mois desc, utilisateur.nom, utilisateur.prenom'
        );
        $requetePrepare->bindValue(':idEtat', 'VA', PDO::PARAM_STR);
        $requetePrepare->bindValue(':statutVisiteur', 'Visiteur', PDO::PARAM_STR);
        $requetePrepare->execute();
        $lesFiches = array();
        while ($laLigne = $requetePrepare->fetch()) {
            $lesFiches[] = array(
                'mois' => $laLigne['mois'],
                'id' => $laLigne['idVisiteur'],
                'nom' => $laLigne['nom'],
                'prenom' => $laLigne['prenom']
            );
        }
        return $lesFiches;
    }
    
    /**
     * Retourne le mois des fiches à valider et mettre en paiement des visiteurs
     *
     * @return les mois des fiches à valider et mettre en paiement sous la forme d'un tableau
     */
    public function getLesMoisFichesVA() {
        $requetePrepare = PdoGSB::$monPdo->prepare(
                'SELECT DISTINCT fichefrais.mois as mois '
                . 'FROM fichefrais '
                . 'WHERE fichefrais.idetat = :idEtat '
                . 'ORDER BY fichefrais.mois desc'
        );
        $requetePrepare->bindValue(':idEtat', 'VA', PDO::PARAM_STR);
        $requetePrepare->execute();
        return $requetePrepare->fetchAll();
    }

    /**
     * Retourne les informations d'une fiche de frais d'un visiteur pour un
     * mois donné
     *
     * @param String $idVisiteur ID du visiteur
     * @param String $mois       Mois sous la forme aaaamm
     *
     * @return un tableau avec des champs de jointure entre une fiche de frais
     *         et la ligne d'état
     */
    public function getLesInfosFicheFrais($idVisiteur, $mois) {
        $requetePrepare = PdoGSB::$monPdo->prepare(
                'SELECT fichefrais.idetat as idEtat, '
                . 'fichefrais.datemodif as dateModif,'
                . 'fichefrais.nbjustificatifs as nbJustificatifs, '
                . 'fichefrais.montantvalide as montantValide, '
                . 'fichefrais.idvehicule as idvehicule, '
                . 'etat.libelle as libEtat '
                . 'FROM fichefrais '
                . 'INNER JOIN etat ON fichefrais.idetat = etat.id '
                . 'WHERE fichefrais.idvisiteur = :unIdVisiteur '
                . 'AND fichefrais.mois = :unMois'
        );
        $requetePrepare->bindParam(':unIdVisiteur', $idVisiteur, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unMois', $mois, PDO::PARAM_STR);
        $requetePrepare->execute();
        $laLigne = $requetePrepare->fetch();
        return $laLigne;
    }
    
    
    /**
     * Modifie l'état et la date de modification d'une fiche de frais.
     * Modifie le champ idEtat et met la date de modif à aujourd'hui.
     *
     * @param String $idVisiteur ID du visiteur
     * @param String $mois       Mois sous la forme aaaamm
     * @param String $etat       Nouvel état de la fiche de frais
     *
     * @return null
     */
    public function majEtatFicheFrais($idVisiteur, $mois, $etat) {
        $requetePrepare = PdoGSB::$monPdo->prepare(
                'UPDATE ficheFrais '
                . 'SET idetat = :unEtat, datemodif = now() '
                . 'WHERE fichefrais.idvisiteur = :unIdVisiteur '
                . 'AND fichefrais.mois = :unMois'
        );
        $requetePrepare->bindParam(':unEtat', $etat, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unIdVisiteur', $idVisiteur, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unMois', $mois, PDO::PARAM_STR);
        $requetePrepare->execute();
    }
    
    /**
     * Modifie l'état et la date de modification d'une fiche de frais.
     * Modifie le champ idEtat et met la date de modif à aujourd'hui.
     *
     * @param String $idVisiteur ID du visiteur
     * @param String $mois       Mois sous la forme aaaamm
     * @param String $etat       Nouvel état de la fiche de frais
     *
     * @return null
     */
    public function majEtatListeFichesFrais($mois, $etat) {
        $requetePrepare = PdoGSB::$monPdo->prepare(
                'UPDATE ficheFrais '
                . 'SET idetat = :unEtat, datemodif = now() '
                . 'WHERE fichefrais.mois = :unMois'
        );
        $requetePrepare->bindParam(':unEtat', $etat, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unMois', $mois, PDO::PARAM_STR);
        $requetePrepare->execute();
    }
    
    /**
     * Met a jour le montant valide pour la fiche d'un visiteur
     *
     * @param String $idVisiteur    ID du visiteur
     * @param String $mois          Mois sous la forme aaaamm
     * @param String $montantValide Nouveau montant valide de la fiche     
     *
     * @return null
     */
    public function majMontantValide($idVisiteur, $mois, $montantValide) {
        $requetePrepare = PdoGSB::$monPdo->prepare(
                'UPDATE ficheFrais '
                . 'SET ficheFrais.montantvalide = :unMontant '
                . 'WHERE fichefrais.idvisiteur = :unIdVisiteur '
                . 'AND fichefrais.mois = :unMois'
        );
        $requetePrepare->bindParam(':unMontant', $montantValide, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unIdVisiteur', $idVisiteur, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unMois', $mois, PDO::PARAM_STR);
        $requetePrepare->execute();
    }

}
