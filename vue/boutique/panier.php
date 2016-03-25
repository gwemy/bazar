<?php if (isset($_SESSION['panier']) AND sizeof($_SESSION['panier']) != 0) { ?>
    <div id="boutons">
        <span class="hoverable" id="vider">Vider</span>
        <span class="hoverable" id="finaliser">Commander</span>
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

        <?php for ($i = 0; $i < sizeof($_SESSION['panier']); $i++) { ?>

            <tbody>
                <tr>
                    <td>
                        <?php echo $_SESSION['panier'][$i]->getCommande_id(); ?>
                    </td>
                    <td>
                        <?php echo $_SESSION['panier'][$i]->getArticle_id(); ?>
                    </td>
                    <td>
                        <?php echo $_SESSION['panier'][$i]->getArticle_quantite(); ?>
                    </td>
                    <td class="money">
                        <?php echo number_format($_SESSION['panier'][$i]->getContenu_prix(), 2); ?>
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
