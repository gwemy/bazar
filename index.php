<?php

$root = $_SERVER['DOCUMENT_ROOT'] . '/bazar/';
include_once $root . 'modele/Contenu.class.php';
session_start();

include_once $root . 'dao/Connexion_sql.class.php';
$bdd = Connexion_sql::getConnexion();

include_once $root . 'modele/Services.class.php';

switch (filter_input(INPUT_GET, 'page')) {
	case 'catalogue':
		include_once $root . 'controleur/boutique_controleur.php';
		break;
	case 'admin':
		include_once $root . 'controleur/admin_controleur.php';
		break;
	case 'magasinier':
		include_once $root . 'controleur/magasinier_controleur.php';
		break;
	default:
		include_once $root . 'controleur/boutique_controleur.php';
		break;
}