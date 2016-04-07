<?php

include_once 'dao/DAO.class.php';
include_once 'modele/Commande.class.php';

class CommandeDAO extends DAO {

	private static $nomTable = 'commande';

	/**
	 * @return string
	 */
	static function getNomTable() {
		return self::$nomTable;
	}

	/**
	 *
	 * @global PDO $bdd
	 * @param integer $offset
	 * @param string $filtre
	 * @return \Commande
	 */
	public static function getObjet($offset, $filtre) {
		global $bdd;
		$nomTable	 = CommandeDAO::getNomTable();
		$limit		 = 1;

		$req	 = $bdd->prepare('CALL ps_lectureTable(:nom_table, :filtre, :offset, :limit)');
		$req->bindParam(':nom_table', $nomTable, PDO::PARAM_STR);
		$req->bindParam(':filtre', $filtre, PDO::PARAM_STR);
		$req->bindParam(':offset', $offset, PDO::PARAM_INT);
		$req->bindParam(':limit', $limit, PDO::PARAM_INT);
		$req->execute();
		$donnees = $req->fetch();

		$commande_id		 = $donnees['commande_id'];
		$commande_prix		 = $donnees['commande_prix'];
		$commande_date		 = $donnees['commande_date'];
		$commande_contenu	 = $donnees['commande_contenu'];
		$user_id			 = $donnees['user_id'];

		$commande = new Commande($commande_id, $commande_prix, $commande_date, $commande_contenu, $user_id);

		if ($commande_id != null) {
			return $commande;
		} else {
			return null;
		}
	}

	/**
	 * @param Commande $objet
	 * @return mixed|string
	 */
	public static function insertObjet($objet) {
		global $bdd;
		$nomTable	 = CommandeDAO::$nomTable;
		$colonnes	 = 'commande_prix, commande_contenu, user_id';
		$valeurs	 = $objet->getCommande_prix() . ",'" . $objet->getCommande_contenu() . "'," . $objet->getUser_id();

		$req = $bdd->prepare('CALL ps_insert(:nom_table, :colonnes, :valeurs)');
		$req->bindParam(':nom_table', $nomTable, PDO::PARAM_STR);
		$req->bindParam(':colonnes', $colonnes, PDO::PARAM_STR);
		$req->bindParam(':valeurs', $valeurs, PDO::PARAM_STR);
		return '[Succès : ' . $req->execute() . '] [Lignes inserées : ' . $req->rowCount() . ']';
	}

	/**
	 * @param $objet
	 * @return mixed|void
	 */
	public static function updateObjet($objet) {

	}

	/**
	 * @param $filtre
	 * @return mixed|void
	 */
	public static function deleteObjet($filtre) {

	}

	/**
	 * Retourne la référence ('commande_id') de la dernière Commande créée.
	 * @return integer La référence ('commande_id') de la dernière Commande créée.
	 */
	public static function getLastID() {
		global $bdd;
		$req = $bdd->prepare('CALL ps_get_lastID(@retour)');
		$req->execute();

		$req_retour	 = $bdd->query('SELECT @retour');
		$retour		 = $req_retour->fetch();

		return $retour[0];
	}

	/**
	 * Retourne un array du chiffre d'affaire par jour.
	 * @return array Un array de deux colonnes du chiffre d'affaire par jour.
	 */
	public static function getGainParJour() {
		global $bdd;
		$req	 = $bdd->query('CALL ps_gain_par_jour()');
		$retour	 = $req->fetchAll();

		return $retour;
	}

	/**
	 * Retourne la date du jour au chiffre d'affaire le plus élevé, ainsi que le chiffre d'affaire en question.
	 * @return array La date du jour au chiffre d'affaire le plus élevé, ainsi que le chiffre d'affaire en question.
	 */
	public static function getGainMeilleurJour() {
		global $bdd;
		$req	 = $bdd->query('CALL ps_gain_meilleur_jour()');
		$retour	 = $req->fetch();

		return $retour;
	}

}
