<?php if (isset($_SESSION['statusConnexion']) AND $_SESSION['statusConnexion'] == 'administrateur') { ?>
    <table id="table_commandes">
        <thead>
            <tr>
                <th>Référence commande</th>
                <th>Date commande</th>
                <th>Prix commande</th>
                <th>Contenu commande</th>
                <th>Référence client</th>
            </tr>
        </thead>

        <?php foreach ($commandes as $commande) { ?>
            <tbody>
                <tr class="ligne_commande" id="commande_id_<?php echo $commande->getCommande_id(); ?>">
                    <td>
                        <?php echo $commande->getCommande_id(); ?>
                    </td>
                    <td>
                        <?php echo $commande->getCommande_date(); ?>
                    </td>
                    <td class="align_right">
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
    </body>
    </html>
<?php } else {
    ?>
    ⨂ Erreur : vous n'êtes pas authentifié.
    <?php
}