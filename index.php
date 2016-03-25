<?php

include_once 'modele/Contenu.class.php';
session_start();

include_once 'modele/Connexion_sql.class.php';
$bdd = Connexion_sql::getConnexion();

include_once 'modele/Services.class.php';

switch (filter_input(INPUT_GET, 'page')) {
    case 'catalogue':
        include_once 'controleur/test_dao_controleur.php';
        break;
    case 'admin':
        include_once 'controleur/admin_controleur.php';
        break;
    case 'magasinier':
        include_once 'controleur/magasinier_controleur.php';
        break;
    default:
        include_once 'controleur/test_dao_controleur.php';
        break;
}