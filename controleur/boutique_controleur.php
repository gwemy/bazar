<?php

$articles = Services::afficherArticles('', '');
switch (filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING)) {
	case 'connecter':
		$login	 = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_STRING);
		$pass	 = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_STRING);
		$hash	 = Services::sendLoginGetHash($login);
		if ($hash == 'inexistant') {
			$_SESSION['message'] = 'Cet utilisateur n\'existe pas.';
		} else {
			if (password_verify($pass, $hash)) {
				$resultat = Services::connexion($login);
				switch ($resultat) {
					case 'client':
						$_SESSION['statusConnexion'] = 'client';
						$_SESSION['currentUserID']	 = Services::sendLoginGetID($login);
						$_SESSION['message']		 = 'Connexion réussie.';
						break;
					case 'administrateur':
						$_SESSION['statusConnexion'] = 'administrateur';
						$_SESSION['currentUserID']	 = Services::sendLoginGetID($login);
						$_SESSION['message']		 = 'Bienvenue, administrateur.';
						break;
					case 'magasinier' :
						$_SESSION['statusConnexion'] = 'magasinier';
						$_SESSION['currentUserID']	 = Services::sendLoginGetID($login);
						$_SESSION['message']		 = 'Bienvenue, magasinier.';
						break;
					case 'désactivé':
						$_SESSION['message']		 = 'Vous ne pouvez pas vous connecter : votre compte a été désactivé.';
						break;
					default:
						$_SESSION['message']		 = 'Erreur : ' . $resultat;
				}
			} else {
				$_SESSION['message'] = 'Mot de passe incorrect.';
			}
		}
		include_once 'vue/boutique/main.php';
		break;
	case 'deconnecter':
		session_unset();
		include_once 'vue/boutique/main.php';
		break;
	case 'panier':
		include_once 'vue/boutique/panier.php';
		break;
	case 'ajout':
		//vérifier si l'array 'panier' existe
		if (!isset($_SESSION['panier'])) {
			$_SESSION['panier'] = [];
		}

		//vérifier que la quantité n'est pas négative
		if (filter_input(INPUT_POST, 'article_quantite', FILTER_SANITIZE_STRING) <= 0) {
			$client = Services::sendUserIdGetUser($_SESSION['currentUserID']);
			$client->setUser_actif('FALSE');
			session_unset();
			break;
		}

		//trouver le prix unitaire à partir du produit à partir de son ID
		$filtre	 = 'article_id = ' . filter_input(INPUT_POST, 'article_id', FILTER_SANITIZE_STRING);
		$prix	 = ArticleDAO::getObjet(0, $filtre)->getArticle_prix();

		//vérifier si l'article ajouté n'est pas déjà dans le panier
		$dejaPresent = false;
		$index		 = 0;
		for ($i = 0; $i < sizeof($_SESSION['panier']); $i++) {
			if ($_SESSION['panier'][$i]->getArticle_id() == filter_input(INPUT_POST, 'article_id', FILTER_SANITIZE_STRING)) {
				$dejaPresent = true;
				$index		 = $i;
				break;
			}
		}
		//calculer le sous-total
		$contenu_prix = filter_input(INPUT_POST, 'article_quantite', FILTER_SANITIZE_STRING) * $prix;

		//ajouter l'article au panier ou modifier la quantité
		if ($dejaPresent) {
			$_SESSION['panier'][$index]->setArticle_quantite(filter_input(INPUT_POST, 'article_quantite', FILTER_SANITIZE_STRING));
			$_SESSION['panier'][$index]->setContenu_prix($contenu_prix);
		} else {
			array_push($_SESSION['panier'], new Contenu(0, filter_input(INPUT_POST, 'article_id', FILTER_SANITIZE_STRING), filter_input(INPUT_POST, 'article_quantite', FILTER_SANITIZE_STRING), $contenu_prix));
		}

		//recalculer le total
		$_SESSION['total'] = 0;
		for ($i = 0; $i < sizeof($_SESSION['panier']); $i++) {
			$_SESSION['total'] += $_SESSION['panier'][$i]->getContenu_prix();
		}

		$article_nom = Services::sendArticleIdGetArticleNom(filter_input(INPUT_POST, 'article_id', FILTER_SANITIZE_STRING));
		echo '✔ ' . $article_nom . ' ajouté(e) au panier en ' . filter_input(INPUT_POST, 'article_quantite', FILTER_SANITIZE_STRING) . ' exemplaire(s).';
		break;
	case 'vider':
		Services::viderPanier();
		echo '';
		break;
	case 'finaliser':
		$client		 = Services::sendUserIdGetUser($_SESSION['currentUserID']);
		if ($client->getUser_actif()) {
			$_SESSION['message'] = Services::finaliserCommande();
		}

		$articles			 = Services::afficherArticles('', '');
		include_once 'vue/boutique/main.php';
		break;
	case 'inscrire':
		$login				 = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_STRING);
		$pass				 = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_STRING);
		$pass_hash			 = password_hash($pass, PASSWORD_BCRYPT);
		$_SESSION['message'] = Services::inscription($login, $pass_hash);
		include_once 'vue/boutique/main.php';
		break;
	case 'recherche':
		if (filter_input(INPUT_POST, 'recherche', FILTER_SANITIZE_STRING) !== null) {
			$recherche = filter_input(INPUT_POST, 'recherche', FILTER_SANITIZE_STRING);
		} else {
			$recherche = '';
		}
		if (filter_input(INPUT_POST, 'type', FILTER_SANITIZE_STRING) !== null) {
			$type = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_STRING);
		} else {
			$type = '';
		}
		$articles		 = Services::afficherArticles($recherche, $type);
		include_once 'vue/boutique/catalogue.php';
		break;
	case 'compte':
		$commandes		 = Services::afficherCommandesUser($_SESSION['currentUserID']);
		include_once 'vue/boutique/compte.php';
		break;
	case 'commande':
		$id				 = filter_input(INPUT_POST, 'commande', FILTER_SANITIZE_STRING);
		$une_commande	 = Services::afficherContenus($id);
		include_once 'vue/boutique/commande.php';
		break;
	case 'articles':
		if (isset($_SESSION['panier'])) {
			echo sizeof($_SESSION['panier']);
		} else {
			echo '';
		}
		break;
	default:
		include_once 'vue/boutique/main.php';
		break;
}
