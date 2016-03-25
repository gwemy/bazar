<?php

class Commande {

    private $commande_id;
    private $commande_prix;
    private $commande_date;
    private $commande_contenu;
    private $user_id;

    function __construct($commande_id, $commande_prix, $commande_date, $commande_contenu, $user_id) {
        $this->commande_id      = $commande_id;
        $this->commande_prix    = $commande_prix;
        $this->commande_date    = $commande_date;
        $this->commande_contenu = $commande_contenu;
        $this->user_id          = $user_id;
    }

    function getCommande_id() {
        return $this->commande_id;
    }

    function getCommande_prix() {
        return $this->commande_prix;
    }

    function getCommande_date() {
        return $this->commande_date;
    }

    function getCommande_contenu() {
        return $this->commande_contenu;
    }

    function getUser_id() {
        return $this->user_id;
    }

    function setCommande_id($commande_id) {
        $this->commande_id = $commande_id;
    }

    function setCommande_prix($commande_prix) {
        $this->commande_prix = $commande_prix;
    }

    function setCommande_date($commande_date) {
        $this->commande_date = $commande_date;
    }

    function setCommande_contenu($commande_contenu) {
        $this->commande_contenu = $commande_contenu;
    }

    function setUser_id($user_id) {
        $this->user_id = $user_id;
    }

}
