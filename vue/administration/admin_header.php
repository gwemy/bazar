<?php if (!isset($_SESSION['statusConnexion']) OR $_SESSION['statusConnexion'] != 'administrateur') { ?>
	⨂ Erreur : vous n'êtes pas authentifié.
<?php } else {
	?>
	<!DOCTYPE html>
	<html>
		<head>
			<meta charset="UTF-8">
			<title>Administration</title>
			<link rel="stylesheet" type="text/css" href="vue/css/admin.css" />
		</head>
		<body>
			<h1>Administration</h1>
			<a href="index.php">← retour à la boutique</a>
			<a href="index.php?page=admin&section=stocks">État des stocks</a>
			<a href="index.php?page=admin&section=clients">Gestion des clients</a>
			<a href="index.php?page=admin&section=commandes">Liste des commandes</a>
			<a href="index.php?page=admin&section=affaire">Chiffre d'affaire</a>
			<a href="index.php?page=admin&section=personnel">Gestion du personnel</a>
			<br/><br/>
			<?php
		}