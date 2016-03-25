<?php

include_once 'dao/DAO.class.php';
include_once 'modele/Article.class.php';

class ArticleDAO extends DAO {

    private static $nomTable    = 'article';
    private static $listeChamps = array('article_id', 'article_nom', 'article_prix', 'article_stock', 'article_dispo', 'article_type', 'fournisseur_nom');

    static function getNomTable() {
        return self::$nomTable;
    }

    public static function getobjet($offset, $filtre) {
        global $bdd;
        $nomTable = ArticleDAO::getNomTable();
        $limit    = 1;

        $req     = $bdd->prepare('CALL ps_lectureTable(:nom_table, :filtre, :offset, :limit)');
        $req->bindParam(':nom_table', $nomTable, PDO::PARAM_STR);
        $req->bindParam(':filtre', $filtre, PDO::PARAM_STR);
        $req->bindParam(':offset', $offset, PDO::PARAM_INT);
        $req->bindParam(':limit', $limit, PDO::PARAM_INT);
        $req->execute();
        $donnees = $req->fetch();

        $article_id      = $donnees['article_id'];
        $article_nom     = $donnees['article_nom'];
        $article_prix    = $donnees['article_prix'];
        $article_stock   = $donnees['article_stock'];
        $article_dispo   = $donnees['article_dispo'];
        $article_type    = $donnees['article_type'];
        $fournisseur_nom = $donnees['fournisseur_nom'];

        $article = new Article($article_id, $article_nom, $article_prix, $article_stock, $article_dispo, $article_type, $fournisseur_nom);

        if ($article_id != null) {
            return $article;
        }
    }

    public static function insertObjet($objet) {
        
    }

    public static function updateObjet($objet) {
        global $bdd;
        $nomTable            = ArticleDAO::$nomTable;
        $valeurs             = 'article_nom = \'' . $objet->getArticle_nom() . '\', article_prix = ' . $objet->getArticle_prix() . ', article_type = \'' . $objet->getArticle_type() . '\', fournisseur_nom = \'' . $objet->getFournisseur_nom() . '\', article_stock = ' . $objet->getArticle_stock() . ', article_dispo = ' . $objet->getArticle_dispo();
        $filtre              = 'article_id = ' . $objet->getArticle_id();
        $_SESSION['wat3']    = $objet;
        $_SESSION['valeurs'] = $valeurs;

        $req = $bdd->prepare('CALL ps_update(:nom_table, :valeurs, :filtre)');
        $req->bindParam(':nom_table', $nomTable, PDO::PARAM_STR);
        $req->bindParam(':valeurs', $valeurs, PDO::PARAM_STR);
        $req->bindParam(':filtre', $filtre, PDO::PARAM_STR);

        return '[Succès : ' . $req->execute() . '] [Lignes mises à jour : ' . $req->rowCount() . ']';
    }

    public static function deleteObjet($filtre) {
        global $bdd;
        $nomTable = ArticleDAO::$nomTable;

        $req = $bdd->prepare('CALL ps_delete(:nom_table, :filtre)');
        $req->bindParam(':nom_table', $nomTable, PDO::PARAM_STR);
        $req->bindParam(':filtre', $filtre, PDO::PARAM_STR);
        return '[Succès : ' . $req->execute() . '] [Lignes effacées : ' . $req->rowCount() . ']';
    }

    public static function concatArticles() {
        global $bdd;

        $req = $bdd->prepare('CALL ps_concat_articles');
        return 'Succès : ' . $req->execute();
    }

    public static function estSousSeuil($id) {
        global $bdd;

        $req = $bdd->prepare('CALL ps_est_sous_seuil(:id, @retour)');
        $req->bindParam(':id', $id, PDO::PARAM_INT);
        $req->execute();

        $req_retour = $bdd->query('SELECT @retour');
        $retour     = $req_retour->fetch();

        return $retour[0];
    }

}
