<?php
if (isset($_SESSION['statusConnexion']) AND $_SESSION['statusConnexion'] == 'administrateur') {
	include_once 'vue/administration/admin_header.php';
	switch (filter_input(INPUT_GET, 'section', FILTER_SANITIZE_STRING)) {
		case 'stocks':
			$articles = Services::afficherArticlesAdmin();
			include_once 'vue/administration/stocks.php';
			break;
		case 'clients':
			if (filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING) !== null) {
				switch (filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING)) {
					case 'bloquer':
						$id							 = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
						$user						 = Services::sendUserIdGetUser($id);
						$user->setUser_actif('FALSE');
						$_SESSION['succes_bloquage'] = Services::updateUser($user);
						break;
					case 'debloquer':
						$id							 = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
						$user						 = Services::sendUserIdGetUser($id);
						$user->setUser_actif('TRUE');
						$_SESSION['succes_bloquage'] = Services::updateUser($user);
						break;
				}
			}
			$users				 = Services::afficherUsers();
			include_once 'vue/administration/clients.php';
			break;
		case 'commandes':
			$commandes			 = Services::afficherCommandesAdmin();
			include_once 'vue/administration/commandes.php';
			break;
		case 'affaire':
			$_SESSION['gains']	 = Services::getGainParJour();
			$meilleur			 = Services::getGainMeilleurJour();
			$_SESSION['max']	 = $meilleur['gain_somme'];
			include_once 'vue/administration/chiffre_affaire.php';
			break;
		case 'personnel':
			if (filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING) == 'status') {
				$id		 = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
				$status	 = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);
				$user	 = Services::sendUserIdGetUser($id);
				$user->setUser_status($status);
				Services::updateUser($user);
			}
			$users = Services::afficherUsers();
			include_once 'vue/administration/personnel.php';
			break;
		default:
			break;
	}
} else {
	?>
	⨂ Erreur : vous n'êtes pas authentifié.
	<?php
}