<?php

abstract class DAO {

	/**
	 * Retourne le $offset-ième objet de la table correspondant au $filtre.
	 * @param integer $offset L'ordinal de l'objet demandé.
	 * @param string $filtre Les critères de sélection de l'objet.
	 * @return mixed Une ligne de la table sous la forme d'un objet.
	 */
	abstract static function getObjet($offset, $filtre);

	/**
	 * Insère une nouvelle ligne dans la table dont les valeurs correspondent à un objet passé en entrée.
	 * @param $objet Un objet contenant les valeurs à insérer dans la table.
	 * @return string Un message de réussite ou d'erreur de l'opération.
	 */
	abstract static function insertObjet($objet);

	/**
	 * Met à jour une ligne de la table dont la clé primaire et les nouvelles valeurs sont contenues dans un objet.
	 * @param $objet Un objet contenant la clé primaire de la ligne à modifier et les nouvelles valeurs à modifier.
	 * @return string Un message de réussite ou d'erreur de l'opération.
	 */
	abstract static function updateObjet($objet);

	/**
	 * Supprime les lignes de la table selon le filtre passé en entrée.
	 * @param string $filtre Les critères de suppression.
	 * @return string Un message de réussite ou d'erreur de l'opération.
	 */
	abstract static function deleteObjet($filtre);
}
