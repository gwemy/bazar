<?php if (isset($_SESSION['panier']) AND sizeof($_SESSION['panier']) != 0) { ?>
	<div id="boutons">
		<?php if (isset($_SESSION['statusConnexion'])) { ?>
			<form action="index.php" method="post">
				<input type="hidden" name="action" value="finaliser"/>
				<input class="hoverable" type="submit" value="Commander">
			</form>
		<?php } else { ?>
			<span class="nothoverable">Connectez-vous<br/>pour commander</span>
		<?php } ?>
		<span class="hoverable" id="vider">Vider</span>
	</div>
	<table id="table_panier">
		<thead>
		<tr>
			<th>Référence commande</th>
			<th>Référence article</th>
			<th>Quantité article</th>
			<th>Sous-total</th>
		</tr>
		</thead>

		<?php /** @var Contenu $contenu */
		foreach ($_SESSION['panier'] as $contenu) { ?>

			<tbody>
			<tr>
				<td>
					<?php echo $contenu->getCommande_id(); ?>
				</td>
				<td>
					<?php echo $contenu->getArticle_id(); ?>
				</td>
				<td>
					<?php echo $contenu->getArticle_quantite(); ?>
				</td>
				<td class="money">
					<?php echo number_format($contenu->getContenu_prix(), 2); ?>
				</td>
			</tr>
			</tbody>

		<?php } ?>

		<tfoot>
		<tr>
			<td colspan="4">
				<span id="total" class="hidden"><?php echo $_SESSION['total']; ?></span>
				Total : <?php echo number_format($_SESSION['total'], 2); ?>
			</td>
		</tr>
		</tfoot>
	</table>

<?php } else { ?>
	<p id="panierVide">Panier vide ☹</p>
	<?php
}
