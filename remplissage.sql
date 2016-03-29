#------------------------------------------------------------
# Remplissage
#------------------------------------------------------------
INSERT IGNORE INTO FOURNISSEUR(fournisseur_nom, fournisseur_type) VALUES
	('Ares', 'Forgeron'),
    ('Wayland', 'Forgeron'),
    ('Masamune', 'Forgeron'),
	('Tubal-cain', 'Forgeron'),
	('Seppo Ilmarinen', 'Forgeron'),
	('Vulcain', 'Forgeron'),
	('Hephaïstos', 'Forgeron'),
    ('Merlin', 'Enchanteur'),
    ('Elias de Kelliwic''h', 'Enchanteur'),
    ('Vasishta', 'Enchanteur'),
	('Visvamitra', 'Enchanteur'),
	('Elijah', 'Enchanteur'),
	('Elisha', 'Enchanteur'),
	('Brandin des Îles', 'Enchanteur'),
	('Mabon', 'Enchanteur'),
	('Elïavrés', 'Enchanteur'),
	('Maugris', 'Enchanteur'),
	('Gwydion', 'Enchanteur'),
    ('Hermes Trismegistus', 'Alchimiste'),
	('Ostanes le perse', 'Alchimiste'),
	('Nicolas Flamel', 'Alchimiste'),
	('Agathodémon', 'Alchimiste'),
	('Zosime de Panopolis', 'Alchimiste'),
	('Arunagirinathar', 'Alchimiste'),
	('Zhang Guo l''Ancien', 'Alchimiste'),
	('Abu Ali al-Husain ibn Abdallah ibn Sina', 'Alchimiste'),
	('Tycho Brahe', 'Alchimiste'),
	('Marie-Louise von Franz', 'Alchimiste'),
    ('Roger Bacon', 'Alchimiste');
    
INSERT IGNORE INTO TYPE(article_type, type_seuil) VALUES
	('Arme', '30'),
    ('Armure', '30'),
    ('Accessoire', '30'),
    ('Consommable', '200');

INSERT IGNORE INTO ARTICLE(article_nom, article_prix, article_type, fournisseur_nom) VALUES
	('Dague', 320.05, 'Arme', 'Wayland'),
    ('Dague magique', 500, 'Arme', 'Seppo Ilmarinen'),
    ('Dague de mythril', 950, 'Arme', 'Hephaïstos'),
    ('Épée de fer', 660, 'Arme', 'Masamune'),
    ('Javeline', 880, 'Arme', 'Tubal-cain'),
    ('Bâton', 260, 'Arme', 'Vulcain'),
    ('Trident', 1100, 'Arme', 'Vulcain'),
    ('Armure de cuir', 200, 'Armure', 'Ares'),
    ('Armure de cuir clouté', 250, 'Armure', 'Seppo Ilmarinen'),
    ('Gantelet de fer', 720, 'Armure', 'Wayland'),
    ('Chapeau pointu', 260, 'Armure', 'Wayland'),
    ('Casque de bronze', 330, 'Armure', 'Masamune'),
    ('Casque de fer', 450, 'Armure', 'Hephaïstos'),
    ('Cuirasse', 530, 'Armure', 'Tubal-cain'),
    ('Armure de lin', 800, 'Armure', 'Ares'),
    ('Potion', 25, 'Consommable', 'Abu Ali al-Husain ibn Abdallah ibn Sina'),
    ('Queue de Phoenix', 200, 'Consommable', 'Agathodémon'),
    ('Ruban', 5000, 'Accessoire', 'Visvamitra'),
    ('Pendentif étoilé', 150, 'Accessoire', 'Elïavrés');

/*INSERT INTO `CLIENT`(client_login, client_pass) VALUES
	('Edward Adelbert Steiner', sha1('dagga')),
    ('Meetra Surik', sha1('exile')),
    ('Grognak the Barbarian', sha1('axe')),
    ('Deckard Cain', sha1('replicant')),
    ('Elizabeth', sha1('tear')),
	('Karin Koenig', sha1('foil')),
    ('Bob Morane', sha1('chacal'));
    
    
UPDATE `CLIENT` SET client_admin = TRUE WHERE client_login = 'Elizabeth';*/