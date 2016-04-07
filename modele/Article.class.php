<?php

class Article {

	private $article_id;
	private $article_nom;
	private $article_prix;
	private $article_stock;
	private $article_dispo;
	private $article_type;
	private $fournisseur_nom;

	function __construct($article_id, $article_nom, $article_prix, $article_stock, $article_dispo, $article_type, $fournisseur_nom) {
		$this->article_id		 = $article_id;
		$this->article_nom		 = $article_nom;
		$this->article_prix		 = $article_prix;
		$this->article_stock	 = $article_stock;
		$this->article_dispo	 = $article_dispo;
		$this->article_type		 = $article_type;
		$this->fournisseur_nom	 = $fournisseur_nom;
	}

	function getArticle_id() {
		return $this->article_id;
	}

	function getArticle_nom() {
		return $this->article_nom;
	}

	function getArticle_prix() {
		return $this->article_prix;
	}

	function getArticle_stock() {
		return $this->article_stock;
	}

	function getArticle_dispo() {
		return $this->article_dispo;
	}

	function getArticle_type() {
		return $this->article_type;
	}

	function getFournisseur_nom() {
		return $this->fournisseur_nom;
	}

	function setArticle_id($article_id) {
		$this->article_id = $article_id;
	}

	function setArticle_nom($article_nom) {
		$this->article_nom = $article_nom;
	}

	function setArticle_prix($article_prix) {
		$this->article_prix = $article_prix;
	}

	function setArticle_stock($article_stock) {
		$this->article_stock = $article_stock;
	}

	function setArticle_dispo($article_dispo) {
		$this->article_dispo = $article_dispo;
	}

	function setArticle_type($article_type) {
		$this->article_type = $article_type;
	}

	function setFournisseur_nom($fournisseur_nom) {
		$this->fournisseur_nom = $fournisseur_nom;
	}

}
