<?php

include_once 'dao/DAO.class.php';
include_once 'dao/ArticleDAO.class.php';
include_once 'dao/UserDAO.class.php';
include_once 'dao/ContenuDAO.class.php';
include_once 'dao/CommandeDAO.class.php';

class Services {

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
		while (ArticleDAO::getobjet($i, $filtre) != NULL) {
			array_push($articles, ArticleDAO::getobjet($i, $filtre));
			$i++;
		}

		return $articles;
	}

	static function afficherUsers() {
		$i		 = 0;
		$users	 = [];
		while (UserDAO::getobjet($i, 'TRUE')) {
			array_push($users, UserDAO::getobjet($i, 'TRUE'));
			$i++;
		}
		return $users;
	}

	static function getInvendu($id) {
		$i		 = 0;
		$filtre	 = 'article_id = ' . $id;
		while (ContenuDAO::getobjet($i, $filtre) != NULL) {
			$i++;
		}
		if ($i > 0) {
			return false;
		} else {
			return true;
		}
	}

	static function afficherCommandesUser($id) {
		$i			 = 0;
		$filtre		 = 'user_id = ' . $id;
		$commandes	 = [];
		while (CommandeDAO::getobjet($i, $filtre) != NULL) {
			array_push($commandes, CommandeDAO::getobjet($i, $filtre));
			$i++;
		}

		return $commandes;
	}

	static function afficherCommandesAdmin() {
		$i			 = 0;
		$filtre		 = 'TRUE';
		$commandes	 = [];
		while (CommandeDAO::getobjet($i, $filtre) != NULL) {
			array_push($commandes, CommandeDAO::getobjet($i, $filtre));
			$i++;
		}

		return $commandes;
	}

	static function afficherContenus($id) {
		$i			 = 0;
		$filtre		 = 'commande_id = ' . $id;
		$contenus	 = [];
		while (ContenuDAO::getObjet($i, $filtre) != NULL) {
			array_push($contenus, ContenuDAO::getobjet($i, $filtre));
			$i++;
		}

		return $contenus;
	}

	static function supprimerContenu($filtre) {
		return ContenuDAO::deleteObjet($filtre);
	}

	static function supprimerArticle($id) {
		$filtre = 'article_id = ' . $id;
		return ArticleDAO::deleteObjet($filtre);
	}

	static function updateArticle($objet) {
		return ArticleDAO::updateObjet($objet);
	}

	static function updateUser($objet) {
		return UserDAO::updateObjet($objet);
	}

	static function connexion($nom) {
		$retour = UserDAO::connexion($nom);
		return $retour;
	}

	static function sendLoginGetID($login) {
		$user	 = (UserDAO::getObjet(0, "user_login = '" . $login . "'"));
		$id		 = $user->getUser_id();
		return $id;
	}

	static function sendUserIdGetUser($id) {
		$filtre = 'user_id = ' . $id;
		return UserDAO::getobjet(0, $filtre);
	}

	static function sendArticleIdGetArticleNom($id) {
		$filtre	 = 'article_id =' . $id;
		$article = ArticleDAO::getObjet(0, $filtre);
		return $article->getArticle_nom();
	}

	static function finaliserCommande() {
		$erreur = 'Erreur de finalisation de la commande.';
		if (empty($_SESSION['panier'])) {
			$erreur = '⚠ Panier vide.';
		} else {
			$erreur = 'Commande : ' . CommandeDAO::insertObjet(new Commande(0, $_SESSION['total'], null, null, $_SESSION['currentUserID']));
			for ($i = 0; $i < sizeof($_SESSION['panier']); $i++) {
				$commande_id		 = Services::getLastID();
				$article_id			 = $_SESSION['panier'][$i]->getArticle_id();
				$article_quantite	 = $_SESSION['panier'][$i]->getArticle_quantite();
				$contenu_prix		 = $_SESSION['panier'][$i]->getContenu_prix();
				$erreur				 = $erreur . '<br/>' . 'Contenu (' . ($i + 1) . ') : ' . ContenuDAO::insertObjet(new Contenu($commande_id, $article_id, $article_quantite, $contenu_prix));
			}
			$erreur	 = $erreur . '<br/>' . 'Nettoyage : ' . Services::supprimerContenu('commande_id = LAST_INSERT_ID() AND article_quantite = 0');
			$erreur	 = $erreur . '<br/>' . 'Concaténation : ' . Services::concatArticles();
			Services::viderPanier();
		}
		return $erreur;
	}

	static function getLastID() {
		return CommandeDAO::getLastID();
	}

	static function viderPanier() {
		unset($_SESSION['panier']);
	}

	static function concatArticles() {
		return ArticleDAO::concatArticles();
	}

	static function inscription($login, $pass) {
		return UserDAO::inscription($login, $pass);
	}

	static function sendLoginGetHash($login) {
		return UserDAO::sendLoginGetHash($login);
	}

	static function estSousSeuil($id) {
		return ArticleDAO::estSousSeuil($id);
	}

	static function majStock($id, $ajout) {
		$filtre	 = 'article_id = ' . $id;
		$article = ArticleDAO::getobjet(0, $filtre);
		$article->setArticle_stock($article->getArticle_stock() + $ajout);
		return ArticleDAO::updateObjet($article);
	}

	static function getGainParJour() {
		return CommandeDAO::getGainParJour();
	}

	static function getGainMeilleurJour() {
		return CommandeDAO::getGainMeilleurJour();
	}

}
