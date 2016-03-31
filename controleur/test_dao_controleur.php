<?php

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
		afficherCatalogue();
		break;
	case 'deconnecter':
		session_unset();
		afficherCatalogue();
		break;
	case 'panier':
		include_once 'vue/boutique/panier.php';
		break;
	case 'ajout':
		//vérifier si l'array 'panier' existe
		if (!isset($_SESSION['panier'])) {
			$_SESSION['panier'] = [];
		}
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
		$contenu_prix = filter_input(INPUT_POST, 'article_quantite', FILTER_SANITIZE_STRING) * filter_input(INPUT_POST, 'article_prix', FILTER_SANITIZE_STRING);

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
		echo 'Article ajouté.';
		break;
	case 'vider':
		Services::viderPanier();
		echo '';
		break;
	case 'finaliser':
		$_SESSION['message'] = Services::finaliserCommande();
		afficherCatalogue();
		break;
	case 'inscrire':
		$login				 = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_STRING);
		$pass				 = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_STRING);
		$pass_hash			 = password_hash($pass, PASSWORD_BCRYPT);
		$_SESSION['message'] = Services::inscription($login, $pass_hash);
		afficherCatalogue();
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
		afficherCatalogue();
		break;
}

function afficherCatalogue() {
	$articles = Services::afficherArticles('', '');

	include_once 'vue/boutique/testdao.php';
}
