<?php
if (isset($_SESSION['statusConnexion']) AND $_SESSION['statusConnexion'] == 'magasinier') {
    switch (filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING)) {
        case 'supprimer':
            $id    = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
            Services::supprimerArticle($id);
            break;
        case 'update':
            $id    = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
            $ajout = filter_input(INPUT_POST, 'quantite', FILTER_SANITIZE_STRING);
            Services::majStock($id, $ajout);
            break;
        default:
            break;
    }
    $articles = Services::afficherArticles('', '');
    include_once 'vue/administration/magasinier.php';
} else {
    ?>
    ⨂ Erreur : vous n'êtes pas authentifié.
    <?php
}