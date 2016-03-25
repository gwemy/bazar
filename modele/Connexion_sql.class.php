<?php

class Connexion_sql {

    private static $host     = 'localhost';
    private static $dbname   = 'bazaar';
    private static $username = 'root';
    private static $password = 'dl10';

    function getConnexion() {
        $host     = Connexion_sql::$host;
        $dbname   = Connexion_sql::$dbname;
        $username = Connexion_sql::$username;
        $password = Connexion_sql::$password;

        try {
            $bdd = new PDO('mysql:host=' . $host . ';dbname=' . $dbname . ';charset=utf8', $username, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

        return $bdd;
    }

}