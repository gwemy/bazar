<table id="table_commandes">
	<thead>
	<tr>
		<th>Référence commande</th>
		<th>Date commande</th>
		<th>Prix commande</th>
		<th>Contenu commande</th>
		<th>Référence client (debug)</th>
	</tr>
	</thead>

	<?php /** @var Commande $commande */
	foreach ($commandes as $commande) { ?>
		<tbody>
		<tr class="ligne_commande" id="commande_id_<?php echo $commande->getCommande_id(); ?>">
			<td>
				<?php echo $commande->getCommande_id(); ?>
			</td>
			<td>
				<?php echo $commande->getCommande_date(); ?>
			</td>
			<td class="money">
				<?php echo number_format($commande->getCommande_prix(), 2); ?>
			</td>
			<td class="td_contenu">
				<?php echo $commande->getCommande_contenu(); ?>
			</td>
			<td>
				<?php echo $commande->getUser_id(); ?>
			</td>
		</tr>
		</tbody>
	<?php } ?>
</table>