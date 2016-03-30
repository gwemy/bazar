<?php if (!isset($_SESSION['statusConnexion']) OR $_SESSION['statusConnexion'] != 'magasinier') { ?>
	⨂ Erreur : vous n'êtes pas authentifié.
<?php } else {
	?>
	<!DOCTYPE html>
	<html>
		<head>
			<meta charset = "UTF-8">
			<title>Gestion des stocks et des invendus</title>
			<link rel="stylesheet" type="text/css" href="vue/css/admin.css" />
		</head>
		<body>
			<h1>Gestion des stocks et des invendus</h1>
			<a href = "index.php">← retour à la boutique</a>
			<br/><br/>
			<table id="table_articles_magasinier">
				<thead>
					<tr>
						<th>Référence</th>
						<th>Nom</th>
						<th>Prix unitaire</th>
						<th>Stock</th>
						<th>Disponibilité</th>
						<th>Type</th>
						<th>Fournisseur</th>
						<th>si invendu</th>
						<th>renouveler stock</th>
					</tr>
				</thead>

				<?php foreach ($articles as $article) {
					?>
					<tbody>
						<tr id="article_id_<?php echo $article->getArticle_id(); ?>" >
							<td class="align_right">
								<?php echo $article->getArticle_id(); ?>
							</td>
							<td>
								<?php echo $article->getArticle_nom(); ?>
							</td>
							<td class="align_right">
								<?php echo number_format($article->getArticle_prix(), 2); ?>
							</td>
							<td class="align_right">
								<?php if (Services::estSousSeuil($article->getArticle_id())) { ?>
									<span class="red">⚠</span>
								<?php } ?>
								<?php echo $article->getArticle_stock(); ?>
							</td>
							<td class="align_center">
								<?php if ($article->getArticle_dispo()) { ?>
									<span class="green">✓</span>
								<?php } else { ?>
									<span class="red">✗</span>
								<?php } ?>
							</td>
							<td>
								<?php echo $article->getArticle_type(); ?>
							</td>
							<td>
								<?php echo $article->getFournisseur_nom(); ?>
							</td>
							<td>
								<?php if (Services::getInvendu($article->getArticle_id())) { ?>
									<form method="POST" action="index.php?page=magasinier">
										<input name="action" type="hidden" value="supprimer"/>
										<input name="id" type="hidden" value="<?php echo $article->getArticle_id(); ?>"/>
										<input type="submit" value="supprimer"/>
									</form>
								<?php } ?>
							</td>
							<td>
								<form method="POST" action="index.php?page=magasinier">
									<input name="action" type="hidden" value="update"/>
									<input name="id" type="hidden" value="<?php echo $article->getArticle_id(); ?>"/>
									<input name="quantite" type="number" min="0"/>
									<input type="submit" value="ajouter"/>
								</form>
							</td>
						</tr>
					</tbody>
				<?php } ?>
			</table>
		</body>
	</html>
	<?php
}