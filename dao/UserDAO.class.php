<?php

include_once 'dao/DAO.class.php';
include_once 'modele/User.class.php';

class UserDAO extends DAO {

    private static $nomTable    = "user";
    private static $listeChamps = array('user_id', 'user_login', 'user_actif', 'user_status', 'user_pass');

    static function getNomTable() {
        return self::$nomTable;
    }

    public static function getobjet($offset, $filtre) {
        global $bdd;
        $nomTable = UserDAO::getNomTable();
        $limit    = 1;

        $req     = $bdd->prepare('CALL ps_lectureTable(:nom_table, :filtre, :offset, :limit)');
        $req->bindParam(':nom_table', $nomTable, PDO::PARAM_STR);
        $req->bindParam(':filtre', $filtre, PDO::PARAM_STR);
        $req->bindParam(':offset', $offset, PDO::PARAM_INT);
        $req->bindParam(':limit', $limit, PDO::PARAM_INT);
        $req->execute();
        $donnees = $req->fetch();

        $user_id     = $donnees['user_id'];
        $user_login  = $donnees['user_login'];
        $user_actif  = $donnees['user_actif'];
        $user_status = $donnees['user_status'];
        $user_pass   = $donnees['user_pass'];

        $user = new Client($user_id, $user_login, $user_actif, $user_status, $user_pass);

        if ($user_id != null) {
            return $user;
        }
    }

    public static function insertObjet($objet) {
        
    }

    public static function updateObjet($objet) {
        global $bdd;
        $nomTable            = UserDAO::$nomTable;
        $valeurs             = 'user_login = \'' . $objet->getUser_login() . '\', user_actif = ' . $objet->getUser_actif() . ', user_status = \'' . $objet->getUser_status() . '\', user_pass = \'' . $objet->getUser_pass() . '\'';
        //$valeurs             = 'article_nom = \'' . $objet->getArticle_nom() . '\', article_prix = ' . $objet->getArticle_prix() . ', article_type = \'' . $objet->getArticle_type() . '\', fournisseur_nom = \'' . $objet->getFournisseur_nom() . '\', article_stock = ' . $objet->getArticle_stock() . ', article_dispo = ' . $objet->getArticle_dispo();
        $filtre              = 'user_id = ' . $objet->getUser_id();
        $_SESSION['wat3']    = $objet;
        $_SESSION['valeurs'] = $valeurs;

        $req = $bdd->prepare('CALL ps_update(:nom_table, :valeurs, :filtre)');
        $req->bindParam(':nom_table', $nomTable, PDO::PARAM_STR);
        $req->bindParam(':valeurs', $valeurs, PDO::PARAM_STR);
        $req->bindParam(':filtre', $filtre, PDO::PARAM_STR);

        return '[Succès : ' . $req->execute() . '] [Lignes mises à jour : ' . $req->rowCount() . ']';
    }

    public static function deleteObjet($filtre) {
        
    }

    public static function connexion($login) {
        global $bdd;

        $req = $bdd->prepare('CALL ps_log_in(:login,@retour)');
        $req->bindParam(':login', $login, PDO::PARAM_STR);

        $req->execute();

        $req_retour = $bdd->query('SELECT @retour');
        $retour     = $req_retour->fetch();

        return $retour[0];
    }

    public static function inscription($login, $pass) {
        global $bdd;
        $req = $bdd->prepare('CALL ps_ajouter_user(:login, :pass, @retour)');
        $req->bindParam(':login', $login, PDO::PARAM_STR);
        $req->bindParam(':pass', $pass, PDO::PARAM_STR);
        $req->execute();

        $req_retour = $bdd->query('SELECT @retour');
        $retour     = $req_retour->fetch();

        if ($retour[0] == 'success') {
            return 'Succès. Lignes inserées : ' . $req->rowCount();
        } else {
            return 'Erreur. Entrée déjà existante.';
        }
    }

    public static function sendLoginGetHash($login) {
        global $bdd;
        $req = $bdd->prepare('CALL ps_sendLoginGetHash(:login, @hash)');
        $req->bindParam(':login', $login, PDO::PARAM_STR);
        $req->execute();

        $req_retour = $bdd->query('SELECT @hash');
        $hash       = $req_retour->fetch();

        return $hash[0];
    }

}
