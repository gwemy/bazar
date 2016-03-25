<?php if (isset($_SESSION['statusConnexion']) AND $_SESSION['statusConnexion'] == 'administrateur') { ?>
<h2>Chiffre d'affaire</h2>
    <div id="div_chiffre_affaire">
        <img src="vue/administration/chiffre_affaire_image.php"/>
    </div>
<?php } else {
    ?>
    ⨂ Erreur : vous n'êtes pas authentifié.
    <?php
}