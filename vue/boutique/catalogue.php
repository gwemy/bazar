<?php
/** @var Article $article */
foreach ($articles as $article) {
	?>
	<div class="<?php
	if ($article->getArticle_stock() != 0) {
		echo 'article ' . $article->getArticle_type();
	} else {
		echo 'article_rupture';
	}
	?>" id="article<?php echo $article->getArticle_id(); ?>">
		<div class='div_image_article'>
			<?php
			$src = 'vue/images/' . $article->getArticle_id() . '.png';
			if (@getimagesize($src)) {
				if ($article->getArticle_stock() != 0) {
					?>
					<img class="image_article" src="vue/images/<?php echo $article->getArticle_id(); ?>.png" alt="<?php echo $article->getArticle_nom(); ?>"/>
				<?php } else {
					?>
					<img class="image_article" src="vue/images/greyscale.php?image=<?php echo $article->getArticle_id(); ?>.png" alt="<?php echo $article->getArticle_nom(); ?>"/>
					<?php
				}
				?>

				<?php
			} else {
				?>
				<img src="vue/images/placeholder.png" alt="<?php echo $article->getArticle_nom(); ?>"/>
			<?php } ?>
		</div>
		<div class="div_description_article">
			<!--
			<div>
				<em>Référence : </em><?php echo $article->getArticle_id(); ?>
			</div>
			-->
			<div class="div_article_nom">
				<?php echo $article->getArticle_nom(); ?>
			</div>
			<div>
				<em>Type : </em><?php echo $article->getArticle_type(); ?>
			</div>
			<div>
				<em>Prix : </em>
				<?php echo number_format($article->getArticle_prix(), 2); ?>
			</div>
			<!--
			<div>
				<em>Stock : </em>
				<span
					id="stock<?php echo $article->getArticle_id(); ?>"><?php echo $article->getArticle_stock(); ?></span>
			</div>
			<div>
				<em>Disponibilité : </em><?php echo $article->getArticle_dispo(); ?>
			</div>
			-->

			<div>
				<em>Fournisseur : </em><?php echo $article->getFournisseur_nom(); ?>
			</div>
			<div class="div_ajouter_panier">
				<?php if ($article->getArticle_stock() != 0) { ?>
					<select class="quantite" id="qte<?php echo $article->getArticle_id(); ?>">
						<?php for ($j = 0; $j < $article->getArticle_stock(); $j++) { ?>
							<option value="<?php echo $j + 1; ?>"><?php echo $j + 1; ?></option>
						<?php } ?>
					</select>
					<input class="ajouter" type="button" id="ajouter<?php echo $article->getArticle_id(); ?>" value="Ajouter au panier"/>
				<?php } else { ?>
					<input id="ajouter<?php echo $article->getArticle_id(); ?>" value="Rupture de stock" type="button"
						   class="rupture" disabled/>
					   <?php } ?>
			</div>
		</div>
	</div>
	<svg height="0" width="0" xmlns="http://www.w3.org/2000/svg">
		<filter id="drop-shadow">
			<feGaussianBlur in="SourceAlpha" stdDeviation="2.2"/>
			<feOffset dx="0" dy="0" result="offsetblur"/>
			<feFlood flood-color="rgba(255,255,255,0.8)"/>
			<feComposite in2="offsetblur" operator="in"/>
			<feMerge>
				<feMergeNode/>
				<feMergeNode in="SourceGraphic"/>
			</feMerge>
		</filter>
	</svg>
	<?php
}