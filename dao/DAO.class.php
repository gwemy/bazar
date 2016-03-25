<?php

abstract class DAO {

    abstract static function getobjet($offset, $filtre);

    abstract function insertObjet($objet);

    abstract function updateObjet($objet);

    abstract function deleteObjet($filtre);
}
