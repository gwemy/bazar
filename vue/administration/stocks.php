<?php if (isset($_SESSION['statusConnexion']) AND $_SESSION['statusConnexion'] == 'administrateur') { ?>
	<h2>État des stocks</h2>
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
		</tr>
		</thead>
		<?php /** @var Article $article */
		foreach ($articles as $article) {
			?>
			<tbody>
			<tr id="article_id_<?php echo $article->getArticle_id(); ?>">
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
					<?php
					if (Services::estSousSeuil($article->getArticle_id())) {
						?>
						<span class="red">⚠</span>
						<?php
					}
					echo $article->getArticle_stock();
					?>
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
			</tr>
			</tbody>
		<?php } ?>
	</table>
	</body>
	</html>
<?php } else { ?>
	⨂ Erreur : vous n'êtes pas authentifié.
	<?php
}