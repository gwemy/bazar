<?php

class TypeArticle {

	private $article_type;
	private $type_seuil;

	function __construct($article_type, $type_seuil) {
		$this->article_type	 = $article_type;
		$this->type_seuil	 = $type_seuil;
	}

	function getArticle_type() {
		return $this->article_type;
	}

	function getType_seuil() {
		return $this->type_seuil;
	}

	function setArticle_type($article_type) {
		$this->article_type = $article_type;
	}

	function setType_seuil($type_seuil) {
		$this->type_seuil = $type_seuil;
	}

}
