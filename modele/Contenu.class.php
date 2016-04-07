<?php

class Contenu {

	private $commande_id;
	private $article_id;
	private $article_quantite;
	private $contenu_prix;

	function __construct($commande_id, $article_id, $article_quantite, $contenu_prix) {
		$this->commande_id		 = $commande_id;
		$this->article_id		 = $article_id;
		$this->article_quantite	 = $article_quantite;
		$this->contenu_prix		 = $contenu_prix;
	}

	function getCommande_id() {
		return $this->commande_id;
	}

	function getArticle_id() {
		return $this->article_id;
	}

	function getArticle_quantite() {
		return $this->article_quantite;
	}

	function getContenu_prix() {
		return $this->contenu_prix;
	}

	function setCommande_id($commande_id) {
		$this->commande_id = $commande_id;
	}

	function setArticle_id($article_id) {
		$this->article_id = $article_id;
	}

	function setArticle_quantite($article_quantite) {
		$this->article_quantite = $article_quantite;
	}

	function setContenu_prix($contenu_prix) {
		$this->contenu_prix = $contenu_prix;
	}

}
