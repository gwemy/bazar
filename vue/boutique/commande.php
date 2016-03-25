<table id="table_une_commande">
    <thead>
        <tr>
            <th>Référence commande (debug)</th>
            <th>Référence article</th>
            <th>Quantité article</th>
            <th>Sous-total</th>
        </tr>
    </thead>

    <?php foreach ($une_commande as $contenu) { ?>
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
                <td>
                    <?php echo number_format($contenu->getContenu_prix(), 2); ?>
                </td>
            </tr>
        </tbody>
    </tr>
    </tbody>
<?php } ?>
</table>