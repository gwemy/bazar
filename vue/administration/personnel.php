<?php if (isset($_SESSION['statusConnexion']) AND $_SESSION['statusConnexion'] == 'administrateur') { ?>
	<h2>Gestion du personnel</h2>
	<table id="table_clients">
		<thead>
		<tr>
			<th>Référence</th>
			<th>Identifiant</th>
			<th>Activé</th>
			<th>Status</th>
			<th>changer les autorisations</th>
			<th>Mot de passe</th>
		</tr>
		</thead>
		<?php /** @var User $user */
		foreach ($users as $user) {
			?>
			<tbody>
			<tr id="user_id_<?php echo $user->getUser_id(); ?>">
				<td class="align_right">
					<?php echo $user->getUser_id(); ?>
				</td>
				<td>
					<?php echo $user->getUser_login(); ?>
				</td>
				<td class="align_center">
					<?php if ($user->getUser_actif()) { ?>
						<span class="green">✓</span>
					<?php } else { ?>
						<span class="red">✗</span>
					<?php } ?>
				</td>
				<td>
					<?php echo $user->getUser_status(); ?>
				</td>
				<td>
					<form method="POST" action="index.php?page=admin&section=personnel">
						<input type="hidden" name="action" value="status"/>
						<input type="hidden" name="id" value="<?php echo $user->getUser_id(); ?>"/>
						<select name="status">
							<?php if ($user->getUser_status() != 'client') { ?>
								<option value="client">client</option>
							<?php } ?>
							<?php if ($user->getUser_status() != 'administrateur') { ?>
								<option value="administrateur">administrateur</option>
							<?php } ?>
							<?php if ($user->getUser_status() != 'magasinier') { ?>
								<option value="magasinier">magasinier</option>
							<?php } ?>
						</select>
						<input type="submit" value="modifier"/>
					</form>
				</td>
				<td>
					<?php echo $user->getUser_pass(); ?>
				</td>

			</tr>
			</tbody>
		<?php } ?>
	</table>
	</body>
	</html>
<?php } else {
	?>
	⨂ Erreur : vous n'êtes pas authentifié.
	<?php
}