<?php

include_once 'dao/DAO.class.php';
include_once 'modele/Commande.class.php';

class CommandeDAO extends DAO {

    private static $nomTable = 'commande';

    static function getNomTable() {
        return self::$nomTable;
    }

    /**
     * 
     * @global type $bdd
     * @param type $offset
     * @param type $filtre
     * @return \Commande
     */
    public static function getobjet($offset, $filtre) {
        global $bdd;
        $nomTable = CommandeDAO::getNomTable();
        $limit    = 1;

        $req     = $bdd->prepare('CALL ps_lectureTable(:nom_table, :filtre, :offset, :limit)');
        $req->bindParam(':nom_table', $nomTable, PDO::PARAM_STR);
        $req->bindParam(':filtre', $filtre, PDO::PARAM_STR);
        $req->bindParam(':offset', $offset, PDO::PARAM_INT);
        $req->bindParam(':limit', $limit, PDO::PARAM_INT);
        $req->execute();
        $donnees = $req->fetch();

        $commande_id      = $donnees['commande_id'];
        $commande_prix    = $donnees['commande_prix'];
        $commande_date    = $donnees['commande_date'];
        $commande_contenu = $donnees['commande_contenu'];
        $user_id          = $donnees['user_id'];

        $commande = new Commande($commande_id, $commande_prix, $commande_date, $commande_contenu, $user_id);

        if ($commande_id != null) {
            return $commande;
        }
    }

    /**
     * @param Commande $objet
     */
    public static function insertObjet($objet) {
        global $bdd;
        $nomTable = CommandeDAO::$nomTable;
        $colonnes = 'commande_prix, commande_contenu, user_id';
        $valeurs  = $objet->getCommande_prix() . ",'" . $objet->getCommande_contenu() . "'," . $objet->getUser_id();

        $req = $bdd->prepare('CALL ps_insert(:nom_table, :colonnes, :valeurs)');
        $req->bindParam(':nom_table', $nomTable, PDO::PARAM_STR);
        $req->bindParam(':colonnes', $colonnes, PDO::PARAM_STR);
        $req->bindParam(':valeurs', $valeurs, PDO::PARAM_STR);
        return '[Succès : ' . $req->execute() . '] [Lignes inserées : ' . $req->rowCount() . ']';
    }

    public static function updateObjet($objet) {
        
    }

    public static function deleteObjet($filtre) {
        
    }

    public static function getLastID() {
        global $bdd;
        $req = $bdd->prepare('CALL ps_get_lastID(@retour)');
        $req->execute();

        $req_retour = $bdd->query('SELECT @retour');
        $retour     = $req_retour->fetch();

        return $retour[0];
    }

    public static function getGainParJour() {
        global $bdd;
        $req    = $bdd->query('CALL ps_gain_par_jour()');
        $retour = $req->fetchAll();

        return $retour;
    }

    public static function getGainMeilleurJour() {
        global $bdd;
        $req    = $bdd->query('CALL ps_gain_meilleur_jour()');
        $retour = $req->fetch();

        return $retour;
    }

}
