<?php

include_once 'dao/DAO.class.php';
include_once 'dao/ArticleDAO.class.php';
include_once 'dao/UserDAO.class.php';
include_once 'dao/ContenuDAO.class.php';
include_once 'dao/CommandeDAO.class.php';

class Services {

	/**
	 * Crée un array d'objets Article à partir de la bdd en fonction des paramètres de recherche passés en entrée.
	 * S'il n'y a aucun paramètre, l'array contiendra tous les objets de la table Article de la bdd dont la valeur 'article_dispo' est 'true'.
	 * @param string $recherche 'article_nom' des objets Article retournés doit contenir cette chaîne de caractères.
	 * @param string $type 'article_type' des objets Article retournés doit être égal à ce paramètre.
	 * @return Article[] Un array d'objets Article issus de la table Article de la bdd.
	 */
	static function afficherArticles($recherche, $type) {
		if ($recherche == '') {
			$filtreRecherche = 'TRUE';
		} else {
			$filtreRecherche = ' article_nom LIKE \'%' . $recherche . '%\'';
		}

		if ($type == '') {
			$filtreType = 'TRUE';
		} else {
			$filtreType = ' article_type = \'' . $type . '\'';
		}

		$filtre		 = $filtreRecherche . ' AND ' . $filtreType;
		$i			 = 0;
		$articles	 = [];
		while (ArticleDAO::getObjet($i, $filtre) != NULL) {
			if (ArticleDAO::getObjet($i, $filtre)->getArticle_dispo()) {
				array_push($articles, ArticleDAO::getObjet($i, $filtre));
			}
			$i++;
		}

		return $articles;
	}

	/**
	 * Crée un array d'objets Article à partir de la bdd. Renvoie l'intégralité de la table Article.
	 * @return Article[] Un array d'objets Article issus de la table Article de la bdd.
	 */
	static function afficherArticlesAdmin() {
		$filtre		 = 'TRUE';
		$i			 = 0;
		$articles	 = [];
		while (ArticleDAO::getObjet($i, $filtre) != NULL) {
			array_push($articles, ArticleDAO::getObjet($i, $filtre));
			$i++;
		}

		return $articles;
	}

	/**
	 * Crée un array d'objets User à partir de la bdd. Renvoie l'intégralité de la table User.
	 * @return User[] Un array d'objets User issus de la table User de la bdd.
	 */
	static function afficherUsers() {
		$i		 = 0;
		$users	 = [];
		while (UserDAO::getObjet($i, 'TRUE')) {
			array_push($users, UserDAO::getObjet($i, 'TRUE'));
			$i++;
		}
		return $users;
	}

	/**
	 * Détermine si un article a déjà été vendu, c'est-à-dire s'il est présent dans une des commandes. Retourne 'true' si jamais vendu.
	 * @param integer $id La référence de l'article (article_id)
	 * @return boolean 'true' si jamais  vendu, 'false' si déjà vendu au moins une fois
	 */
	static function getInvendu($id) {
		$i		 = 0;
		$filtre	 = 'article_id = ' . $id;
		while (ContenuDAO::getObjet($i, $filtre) != NULL) {
			$i++;
		}
		if ($i > 0) {
			return false;
		} else {
			return true;
		}
	}

	/**
	 * Crée un array avec les objets Commande dont la valeur 'user_id' est passée en entrée.
	 * @param integer $id  La référence du client ('user_id')
	 * @return Commande[] Un array d'objets Commande issus de la table Commande de la bdd.
	 */
	static function afficherCommandesUser($id) {
		$i			 = 0;
		$filtre		 = 'user_id = ' . $id;
		$commandes	 = [];
		while (CommandeDAO::getObjet($i, $filtre) != NULL) {
			array_push($commandes, CommandeDAO::getObjet($i, $filtre));
			$i++;
		}

		return $commandes;
	}

	/**
	 * Crée un array d'objets Commande à partir de la bdd. Renvoie l'intégralité de la table Commande.
	 * @return Commande[] Un array d'objets Commande issus de la table Commande de la bdd.
	 */
	static function afficherCommandesAdmin() {
		$i			 = 0;
		$filtre		 = 'TRUE';
		$commandes	 = [];
		while (CommandeDAO::getObjet($i, $filtre) != NULL) {
			array_push($commandes, CommandeDAO::getObjet($i, $filtre));
			$i++;
		}

		return $commandes;
	}

	/**
	 * Crée un array avec les objets Contenu dont la valeur 'commande_id' est passée en entrée.
	 * @param integer $id La référence de la commande ('commande_id')
	 * @return Contenu[] Un array d'objets Contenu issus de la table Contenu de la bdd.
	 */
	static function afficherContenus($id) {
		$i			 = 0;
		$filtre		 = 'commande_id = ' . $id;
		$contenus	 = [];
		while (ContenuDAO::getObjet($i, $filtre) != NULL) {
			array_push($contenus, ContenuDAO::getObjet($i, $filtre));
			$i++;
		}

		return $contenus;
	}

	/**
	 * Supprime les lignes de la table Contenu dont la quantité ('article_quantite') est nulle et correspondant à la dernière commande passée.
	 * @return string Un message de réussite ou d'erreur de l'opération.
	 */
	static function supprimerContenu() {
		return ContenuDAO::deleteObjet('commande_id = LAST_INSERT_ID() AND article_quantite = 0');
	}

	/**
	 * Supprime une ligne de la table Article dont la référence ('article_id') est passée en entrée.
	 * @param integer $id La référence de l'article à supprimer ('article_id').
	 * @return string Un message de réussite ou d'erreur de l'opération.
	 */
	static function supprimerArticle($id) {
		$filtre = 'article_id = ' . $id;
		return ArticleDAO::deleteObjet($filtre);
	}

	/**
	 * Met à jour les valeurs d'une ligne de la table User. La clé primaire et les nouvelles valeurs sont contenues dans l'objet passé en entrée.
	 * @param User $objet Un objet User contenant la clé primaire de la ligne à modifier et les nouvelles valeurs à modifier.
	 * @return string Un message de réussite ou d'erreur de l'opération.
	 */
	static function updateUser($objet) {
		return UserDAO::updateObjet($objet);
	}

	/**
	 * Prend en entrée le login de l'utilisateur et renvoie le status de cet utilisateur.
	 * @param string $login Le login de l'utilisateur ('user_login').
	 * @return string Un message de réussite ou d'erreur de l'opération.
	 */
	static function connexion($login) {
		$retour = UserDAO::connexion($login);
		return $retour;
	}

	/**
	 * Prend le login de l'utilisateur ('user_login') en entrée et renvoie sa référence ('user_id')
	 * @param string $login Le login de l'utilisateur ('user_login').
	 * @return integer La référence de l'utilisateur ('user_id').
	 */
	static function sendLoginGetID($login) {
		$user	 = (UserDAO::getObjet(0, "user_login = '" . $login . "'"));
		$id		 = $user->getUser_id();
		return $id;
	}

	/**
	 * Prend la référence de l'utilisateur ('user_id') en entrée et renvoie la ligne du tableau correspondante sous forme d'un objet User.
	 * @param integer $id La référence de l'utilisateur ('user_id').
	 * @return User L'objet User dont la référence ('user_id') est passée en entrée.
	 */
	static function sendUserIdGetUser($id) {
		$filtre = 'user_id = ' . $id;
		return UserDAO::getObjet(0, $filtre);
	}

	/**
	 * Prend la référence d'un article ('article_id') en entrée et renvoie son nom ('article_nom').
	 * @param type $id La référence de l'article ('article_id').
	 * @return string Le nom de l'article ('article_nom') dont la référence ('article_id') est passée en entrée.
	 */
	static function sendArticleIdGetArticleNom($id) {
		$filtre	 = 'article_id =' . $id;
		$article = ArticleDAO::getObjet(0, $filtre);
		return $article->getArticle_nom();
	}

	/**
	 * Crée un objet Commande et copie le contenu de 'panier' contenu dans la session dans la table Contenu, puis nettoie les entrées où le stock a été insuffisant.
	 * @return string Un message de réussite ou d'erreur de l'opération.
	 */
	static function finaliserCommande() {
		$erreur = 'Erreur de finalisation de la commande.';
		if (empty($_SESSION['panier'])) {
			$erreur = '⚠ Panier vide.';
		} else {
			$erreur = 'Commande : ' . CommandeDAO::insertObjet(new Commande(0, $_SESSION['total'], null, null, $_SESSION['currentUserID']));
			/** @var Contenu $contenu */
			foreach ($_SESSION['panier'] as $contenu) {
				$commande_id		 = Services::getLastID();
				$article_id			 = $contenu->getArticle_id();
				$article_quantite	 = $contenu->getArticle_quantite();
				$contenu_prix		 = $contenu->getContenu_prix();
				$erreur				 = $erreur . '<br/>' . 'Contenu : ' . ContenuDAO::insertObjet(new Contenu($commande_id, $article_id, $article_quantite, $contenu_prix));
			}
			$erreur	 = $erreur . '<br/>' . 'Nettoyage : ' . Services::supprimerContenu();
			$erreur	 = $erreur . '<br/>' . 'Concaténation : ' . Services::concatArticles();
			Services::viderPanier();
		}
		return $erreur;
	}

	/**
	 * Retourne la référence ('commande_id') de la dernière Commande créée.
	 * @return integer La référence ('commande_id') de la dernière Commande créée.
	 */
	static function getLastID() {
		return CommandeDAO::getLastID();
	}

	/**
	 * Efface le panier de la session.
	 */
	static function viderPanier() {
		unset($_SESSION['panier']);
	}

	/**
	 * Créé une chaîne de caractères correspondant à la liste des articles d'une commande, accompagnés de leur quantité.
	 * @return string Un message de réussite ou d'erreur de l'opération.
	 */
	static function concatArticles() {
		return ArticleDAO::concatArticles();
	}

	/**
	 * Ajoute une ligne à la table User avec le login et le mot de passe passés en entrée.
	 * @param string $login Le login désiré par l'utilisateur.
	 * @param string $pass Le mot de passe désiré par l'utilisateur. Il sera crypté par la fonction password_hash() avant d'être stocké dans la bdd.
	 * @return string Un message de réussite ou d'erreur de l'opération.
	 */
	static function inscription($login, $pass) {
		return UserDAO::inscription($login, $pass);
	}

	/**
	 * 	Prend le login d'un utilisateur ('user_login') en entrée et renvoie la version hashée de son mot de passe ('user_password').
	 * @param string $login Le login d'un utilisateur ('user_login').
	 * @return string La version hashée de son mot de passe ('user_password').
	 */
	static function sendLoginGetHash($login) {
		return UserDAO::sendLoginGetHash($login);
	}

	/**
	 * Détermine si le stock d'un article est en dessous de son seuil d'initialisation divisé par 4.
	 * @param integer $id La référence de l'article ('article_id').
	 * @return boolean 'true' si l'article est sous le seuil
	 */
	static function estSousSeuil($id) {
		return ArticleDAO::estSousSeuil($id);
	}

	/**
	 * Modifie positivement le stock d'un article dont la référence est passée en entrée.
	 * @param integer $id La référence de l'article ('article_id').
	 * @param integer $ajout La quantité à ajouter à l'article.
	 * @return string Un message de réussite ou d'erreur de l'opération.
	 */
	static function majStock($id, $ajout) {
		$filtre	 = 'article_id = ' . $id;
		$article = ArticleDAO::getObjet(0, $filtre);
		$article->setArticle_stock($article->getArticle_stock() + $ajout);
		return ArticleDAO::updateObjet($article);
	}

	/**
	 * Retourne un array du chiffre d'affaire par jour.
	 * @return array Un array de deux colonnes du chiffre d'affaire par jour.
	 */
	static function getGainParJour() {
		return CommandeDAO::getGainParJour();
	}

	/**
	 * Retourne la date du jour au chiffre d'affaire le plus élevé, ainsi que le chiffre d'affaire en question.
	 * @return array La date du jour au chiffre d'affaire le plus élevé, ainsi que le chiffre d'affaire en question.
	 */
	static function getGainMeilleurJour() {
		return CommandeDAO::getGainMeilleurJour();
	}

}
