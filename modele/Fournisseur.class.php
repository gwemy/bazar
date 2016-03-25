<?php

class Fournisseur {

    private $fournisseur_nom;
    private $fournisseur_type;

    function __construct($fournisseur_nom, $fournisseur_type) {
        $this->fournisseur_nom  = $fournisseur_nom;
        $this->fournisseur_type = $fournisseur_type;
    }

    function getFournisseur_nom() {
        return $this->fournisseur_nom;
    }

    function getFournisseur_type() {
        return $this->fournisseur_type;
    }

    function setFournisseur_nom($fournisseur_nom) {
        $this->fournisseur_nom = $fournisseur_nom;
    }

    function setFournisseur_type($fournisseur_type) {
        $this->fournisseur_type = $fournisseur_type;
    }

}
