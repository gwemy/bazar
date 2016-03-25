<?php
if (isset($_SESSION['statusConnexion']) AND $_SESSION['statusConnexion'] == 'administrateur') {
    include_once 'vue/administration/admin_header.php';
    switch (filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING)) {
        case 'stocks':
            $articles          = Services::afficherArticles('', '');
            include_once 'vue/administration/stocks.php';
            break;
        case 'clients':
            $users             = Services::afficherUsers();
            include_once 'vue/administration/clients.php';
            break;
        case 'commandes':
            $commandes         = Services::afficherCommandesAdmin();
            include_once 'vue/administration/commandes.php';
            break;
        case 'affaire':
            $_SESSION['gains'] = Services::getGainParJour();
            $meilleur          = Services::getGainMeilleurJour();
            $_SESSION['max']   = $meilleur['gain_somme'];
            include_once 'vue/administration/chiffre_affaire.php';
            break;
        case 'personnel':
            $users             = Services::afficherUsers();
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