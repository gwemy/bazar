<?php

include_once 'dao/DAO.class.php';
include_once 'modele/Contenu.class.php';

class ContenuDAO extends DAO {

    private static $nomTable = 'contenu';

    static function getNomTable() {
        return self::$nomTable;
    }

    /**
     * 
     * @global type $bdd
     * @param type $offset
     * @param type $filtre
     * @return \Contenu
     */
    public static function getobjet($offset, $filtre) {
        global $bdd;
        $nomTable = ContenuDAO::getNomTable();
        $limit    = 1;

        $req     = $bdd->prepare('CALL ps_lectureTable(:nom_table, :filtre, :offset, :limit)');
        $req->bindParam(':nom_table', $nomTable, PDO::PARAM_STR);
        $req->bindParam(':filtre', $filtre, PDO::PARAM_STR);
        $req->bindParam(':offset', $offset, PDO::PARAM_INT);
        $req->bindParam(':limit', $limit, PDO::PARAM_INT);
        $req->execute();
        $donnees = $req->fetch();

        $commande_id      = $donnees['commande_id'];
        $article_id       = $donnees['article_id'];
        $article_quantite = $donnees['article_quantite'];
        $contenu_prix     = $donnees['contenu_prix'];

        $contenu = new Contenu($commande_id, $article_id, $article_quantite, $contenu_prix);

        if ($commande_id != null) {
            return $contenu;
        }
    }

    /**
     * @param Contenu $objet
     */
    public static function insertObjet($objet) {
        global $bdd;
        $nomTable = ContenuDAO::$nomTable;
        $colonnes = 'commande_id, article_id, article_quantite, contenu_prix';
        $valeurs  = $objet->getCommande_id() . "," . $objet->getArticle_id() . "," . $objet->getArticle_quantite() . "," . $objet->getContenu_prix();

        $req = $bdd->prepare('CALL ps_insert(:nom_table, :colonnes, :valeurs)');
        $req->bindParam(':nom_table', $nomTable, PDO::PARAM_STR);
        $req->bindParam(':colonnes', $colonnes, PDO::PARAM_STR);
        $req->bindParam(':valeurs', $valeurs, PDO::PARAM_STR);
        return '[Succès : ' . $req->execute() . '] [Lignes inserées : ' . $req->rowCount() . ']';
    }

    public static function updateObjet($objet) {
        
    }

    public static function deleteObjet($filtre) {
        global $bdd;
        $nomTable = ContenuDAO::$nomTable;

        $req = $bdd->prepare('CALL ps_delete(:nom_table, :filtre)');
        $req->bindParam(':nom_table', $nomTable, PDO::PARAM_STR);
        $req->bindParam(':filtre', $filtre, PDO::PARAM_STR);
        return '[Succès : ' . $req->execute() . '] [Lignes effacées : ' . $req->rowCount() . ']';
    }

}
