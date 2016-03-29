USE bazaar;
DELIMITER $$

  /*----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
 /* COMMERCE																																																						 */
/*----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/

DROP PROCEDURE IF EXISTS ps_concat_articles $$
CREATE PROCEDURE ps_concat_articles()
BEGIN
	UPDATE COMMANDE 
SET 
    commande_contenu = (
		SELECT 
            GROUP_CONCAT(article_nom,
                    ' (x',
                    article_quantite,
                    ')'
                    SEPARATOR ', ')
        FROM
            CONTENU
                INNER JOIN
            ARTICLE ON CONTENU.article_id = ARTICLE.article_id
        WHERE
            commande_id = LAST_INSERT_ID()
        GROUP BY commande_id)
WHERE
    commande_id = LAST_INSERT_ID();
END; $$

DROP PROCEDURE IF EXISTS ps_get_lastID $$
CREATE PROCEDURE ps_get_lastID(
	OUT retour INT)
BEGIN
	SELECT
		commande_id
	INTO
		retour
	FROM 
		COMMANDE
	WHERE
		commande_id = LAST_INSERT_ID();
END; $$


  /*----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
 /* INSCRIPTION ET CONNEXION																																																		 */
/*----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/

/*permet de s'inscrire*/
DROP PROCEDURE IF EXISTS ps_ajouter_user $$
CREATE PROCEDURE ps_ajouter_user(
	IN login VARCHAR(25),
    IN pass TEXT,
    OUT retour TEXT)
BEGIN
	DECLARE EXIT HANDLER FOR 1062
    BEGIN
		SET retour = 'duplicate';
	END;
	INSERT INTO `user` (user_login, user_pass) VALUES (login, pass);
    SET retour = 'success';
END; $$

/*reçoit un identifiant de connexion, retourne le mot de passe hashé du login correspondant*/
DROP PROCEDURE IF EXISTS ps_sendLoginGetHash $$
CREATE PROCEDURE ps_sendLoginGetHash(
	IN login VARCHAR(25),
    OUT hashed_pass TEXT)
BEGIN
	IF EXISTS (SELECT * FROM `USER` WHERE user_login = login)
    THEN
		SELECT user_pass INTO hashed_pass FROM `USER` WHERE user_login = login;
	ELSE
		SET hashed_pass = 'inexistant';
    END IF;
END; $$

/*permet de se connecter quand on est déjà inscrit*/
DROP PROCEDURE IF EXISTS ps_log_in $$
CREATE PROCEDURE ps_log_in(
	IN login VARCHAR(25),
    OUT retour VARCHAR(25))
BEGIN
	DECLARE user_is_active BOOLEAN;
	SELECT user_actif INTO user_is_active FROM `USER` WHERE user_login = login;
	IF user_is_active = TRUE
	THEN
		SELECT user_status INTO retour FROM `USER` WHERE user_login = login;
	ELSE
		SET retour = 'désactivé';
	END IF;
END; $$

  /*----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
 /* ADMINISTRATION																																																					 */
/*----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/

DROP PROCEDURE IF EXISTS ps_est_sous_seuil $$
CREATE PROCEDURE ps_est_sous_seuil(
	IN id int,
    OUT retour boolean)
BEGIN
	DECLARE stock INT;
    DECLARE seuil FLOAT;
    
    SELECT article_stock INTO stock FROM `ARTICLE` WHERE article_id = id;
    SELECT type_seuil INTO seuil FROM `TYPE`, `ARTICLE` WHERE `ARTICLE`.`article_type` = `TYPE`.`article_type` AND article_id = id;
    
	SELECT
		(stock < (seuil/4))
	INTO 
		retour;
END; $$

DROP PROCEDURE IF EXISTS ps_gain_par_jour $$
CREATE PROCEDURE ps_gain_par_jour()
BEGIN
	SELECT SUM(`commande_prix`) AS `gain_somme`, `commande_date`AS `gain_date` FROM `COMMANDE` GROUP BY `commande_date`;
END; $$

DROP PROCEDURE IF EXISTS ps_gain_meilleur_jour $$
CREATE PROCEDURE ps_gain_meilleur_jour()
BEGIN
	SELECT SUM(`commande_prix`) AS `gain_somme`, `commande_date`AS `gain_date` FROM `COMMANDE` GROUP BY `commande_date` ORDER BY `gain_somme` DESC LIMIT 1;
END; $$

  /*----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
 /* PROCEDURES GENERIQUES																																																			 */
/*----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
DROP PROCEDURE IF EXISTS ps_lectureTable; $$
CREATE PROCEDURE ps_lectureTable(IN nom_table LONGTEXT, IN filtre LONGTEXT, IN _offset INT, IN _limit INT)
BEGIN
    SET @concat_string = CONCAT('SELECT * FROM ', nom_table, ' WHERE ', filtre, ' LIMIT ', _offset, ',', _limit);
	PREPARE stmt FROM @concat_string;
	EXECUTE stmt;
END; $$

DROP PROCEDURE IF EXISTS ps_insert; $$
CREATE PROCEDURE ps_insert(IN nom_table LONGTEXT, IN colonnes LONGTEXT, IN valeurs LONGTEXT)
BEGIN
	SET @concat_string = CONCAT('INSERT INTO ', nom_table, ' (', colonnes, ') VALUES (', valeurs, ')');
	PREPARE stmt FROM @concat_string;
	EXECUTE stmt;
END; $$

DROP PROCEDURE IF EXISTS ps_update; $$
CREATE PROCEDURE ps_update(IN nom_table LONGTEXT, IN valeurs LONGTEXT, IN filtre LONGTEXT)
BEGIN
	SET @concat_string = CONCAT('UPDATE ', nom_table, ' SET ', valeurs , ' WHERE ', filtre);
	PREPARE stmt FROM @concat_string;
	EXECUTE stmt;
END; $$

DROP PROCEDURE IF EXISTS ps_delete; $$
CREATE PROCEDURE ps_delete(IN nom_table LONGTEXT, IN filtre LONGTEXT)
BEGIN
	SET @concat_string = CONCAT('DELETE FROM ', nom_table, ' WHERE ', filtre);
	PREPARE stmt FROM @concat_string;
	EXECUTE stmt;

END; $$