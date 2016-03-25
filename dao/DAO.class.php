<?php

abstract class DAO {

    abstract static function getobjet($offset, $filtre);

    abstract static function insertObjet($objet);

    abstract static function updateObjet($objet);

    abstract static function deleteObjet($filtre);
}
