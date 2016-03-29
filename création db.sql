DROP DATABASE IF EXISTS bazaar;
CREATE DATABASE bazaar;
USE bazaar;

/*------------------------------------------------------------ Table: TYPE ------------------------------------------------------------*/
CREATE TABLE `TYPE` (
	`article_type` 	VARCHAR(25),
    `type_seuil` 	INT UNSIGNED,
    PRIMARY KEY (`article_type`)
) ENGINE = INNODB;

/*------------------------------------------------------------ Table: FOURNISSEUR ------------------------------------------------------------*/
CREATE TABLE `FOURNISSEUR` (
    `fournisseur_nom` 	VARCHAR(50) NOT NULL,
    `fournisseur_type` 	VARCHAR(25),
    PRIMARY KEY (`fournisseur_nom`)
)  ENGINE=INNODB;

/*------------------------------------------------------------Table: ARTICLE ------------------------------------------------------------*/
CREATE TABLE `ARTICLE` (
    `article_id` 		INT(11) AUTO_INCREMENT NOT NULL,
    `article_nom` 		VARCHAR(25) UNIQUE,
    `article_prix` 		DECIMAL(13, 4) UNSIGNED,
    `article_stock` 	INT UNSIGNED,
    `article_dispo` 	BOOLEAN DEFAULT TRUE,
    `article_type` 		VARCHAR(25),
    `fournisseur_nom` 	VARCHAR(50),
    UNIQUE INDEX `index` (`article_nom` ASC, `article_type` ASC),
    CONSTRAINT FK_ARTICLE_fournisseur_id FOREIGN KEY (`fournisseur_nom`) REFERENCES `FOURNISSEUR`(`fournisseur_nom`),
    CONSTRAINT FK_ARTICLE_article_type FOREIGN KEY (`article_type`) REFERENCES `TYPE`(`article_type`),
    PRIMARY KEY (`article_id`)
)  ENGINE=INNODB;

/*------------------------------------------------------------Table: AVENTURIER ------------------------------------------------------------*/
CREATE TABLE `USER` (
    `user_id`		INT(8) AUTO_INCREMENT NOT NULL,
    `user_login`	VARCHAR(25) UNIQUE NOT NULL,
    `user_actif`	BOOLEAN DEFAULT TRUE,
    `user_status`	VARCHAR(25) DEFAULT 'client',
    `user_pass`		TEXT NOT NULL,
    PRIMARY KEY (`user_id`)
)  ENGINE=INNODB;

/*------------------------------------------------------------Table: COMMANDE ------------------------------------------------------------*/
CREATE TABLE `COMMANDE` (
    `commande_id` 		INT(11) AUTO_INCREMENT NOT NULL,
    `commande_prix` 	DECIMAL(13, 4) UNSIGNED DEFAULT 0,
    `commande_date` 	DATE,
    `commande_contenu` 	LONGTEXT,
    `user_id` 	INT(8),
    CONSTRAINT FK_COMMANDE_user_id FOREIGN KEY (`user_id`) REFERENCES `USER` (`user_id`),
    PRIMARY KEY (`commande_id`)
)  ENGINE=INNODB;

/*------------------------------------------------------------Table: CONTENU ------------------------------------------------------------*/
CREATE TABLE `CONTENU` (
    `commande_id` 		INT,
    `article_id` 		INT NOT NULL,
    `article_quantite` 	INT UNSIGNED,
    `contenu_prix` 		DECIMAL(13, 4) UNSIGNED,
    CONSTRAINT FK_CONTENU_article_id FOREIGN KEY (`article_id`) REFERENCES `ARTICLE` (`article_id`),
    CONSTRAINT FK_CONTENU_commande_id FOREIGN KEY (`commande_id`) REFERENCES `COMMANDE` (`commande_id`),
    PRIMARY KEY (`article_id` , `commande_id`)
)  ENGINE=INNODB;