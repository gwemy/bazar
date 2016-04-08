<?php

include_once 'dao/DAO.class.php';
include_once 'modele/User.class.php';

class UserDAO extends DAO {

	private static $nomTable = "USER";

	/**
	 * @return string
	 */
	static function getNomTable() {
		return self::$nomTable;
	}

	/**
	 * @param $offset
	 * @param $filtre
	 * @return User
	 */
	public static function getObjet($offset, $filtre) {
		global $bdd;
		$nomTable	 = UserDAO::getNomTable();
		$limit		 = 1;

		$req	 = $bdd->prepare('CALL ps_lectureTable(:nom_table, :filtre, :offset, :limit)');
		$req->bindParam(':nom_table', $nomTable, PDO::PARAM_STR);
		$req->bindParam(':filtre', $filtre, PDO::PARAM_STR);
		$req->bindParam(':offset', $offset, PDO::PARAM_INT);
		$req->bindParam(':limit', $limit, PDO::PARAM_INT);
		$req->execute();
		$donnees = $req->fetch();

		$user_id	 = $donnees['user_id'];
		$user_login	 = $donnees['user_login'];
		$user_actif	 = $donnees['user_actif'];
		$user_status = $donnees['user_status'];
		$user_pass	 = $donnees['user_pass'];

		$user = new User($user_id, $user_login, $user_actif, $user_status, $user_pass);

		if ($user_id != null) {
			return $user;
		} else {
			return null;
		}
	}

	/**
	 * @param $objet
	 * @return mixed|void
	 */
	public static function insertObjet($objet) {

	}

	/**
	 * @param User $objet
	 * @return string
	 */
	public static function updateObjet($objet) {
		global $bdd;
		$nomTable			 = UserDAO::$nomTable;
		$valeurs			 = 'user_login = \'' . $objet->getUser_login() . '\', user_actif = ' . $objet->getUser_actif() . ', user_status = \'' . $objet->getUser_status() . '\', user_pass = \'' . $objet->getUser_pass() . '\'';
		$filtre				 = 'user_id = ' . $objet->getUser_id();
		$_SESSION['wat3']	 = $objet;
		$_SESSION['valeurs'] = $valeurs;

		$req = $bdd->prepare('CALL ps_update(:nom_table, :valeurs, :filtre)');
		$req->bindParam(':nom_table', $nomTable, PDO::PARAM_STR);
		$req->bindParam(':valeurs', $valeurs, PDO::PARAM_STR);
		$req->bindParam(':filtre', $filtre, PDO::PARAM_STR);

		return '[Succès : ' . $req->execute() . '] [Lignes mises à jour : ' . $req->rowCount() . ']';
	}

	/**
	 * @param $filtre
	 * @return mixed|void
	 */
	public static function deleteObjet($filtre) {

	}

	/**
	 * Prend en entrée le login de l'utilisateur et renvoie le status de cet utilisateur.
	 * @param string $login Le login de l'utilisateur ('user_login').
	 * @return string Un message de réussite ou d'erreur de l'opération.
	 */
	public static function connexion($login) {
		global $bdd;

		$req = $bdd->prepare('CALL ps_log_in(:login,@retour)');
		$req->bindParam(':login', $login, PDO::PARAM_STR);

		$req->execute();

		$req_retour	 = $bdd->query('SELECT @retour');
		$retour		 = $req_retour->fetch();

		return $retour[0];
	}

	/**
	 * Ajoute une ligne à la table User avec le login et le mot de passe passés en entrée.
	 * @param string $login Le login désiré par l'utilisateur.
	 * @param string $pass Le mot de passe désiré par l'utilisateur. Il sera crypté par la fonction password_hash() avant d'être stocké dans la bdd.
	 * @return string Un message de réussite ou d'erreur de l'opération.
	 */
	public static function inscription($login, $pass) {
		global $bdd;
		$req = $bdd->prepare('CALL ps_ajouter_user(:login, :pass, @retour)');
		$req->bindParam(':login', $login, PDO::PARAM_STR);
		$req->bindParam(':pass', $pass, PDO::PARAM_STR);
		$req->execute();

		$req_retour	 = $bdd->query('SELECT @retour');
		$retour		 = $req_retour->fetch();

		if ($retour[0] == 'success') {
			return 'Succès. Lignes inserées : ' . $req->rowCount();
		} else {
			return 'Erreur. Entrée déjà existante.';
		}
	}

	/**
	 * Prend le login d'un utilisateur ('user_login') en entrée et renvoie la version hashée de son mot de passe ('user_password').
	 * @param string $login Le login d'un utilisateur ('user_login').
	 * @return string La version hashée de son mot de passe ('user_password').
	 */
	public static function sendLoginGetHash($login) {
		global $bdd;
		$req = $bdd->prepare('CALL ps_sendLoginGetHash(:login, @hash)');
		$req->bindParam(':login', $login, PDO::PARAM_STR);
		$req->execute();

		$req_retour	 = $bdd->query('SELECT @hash');
		$hash		 = $req_retour->fetch();

		return $hash[0];
	}

}
