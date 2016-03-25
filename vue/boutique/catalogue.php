<?php foreach ($articles as $article) { ?>
    <div class="<?php
    if ($article->getArticle_stock() != 0) {
        echo 'article';
    } else {
        echo 'article_rupture';
    }
    ?>" id="article<?php echo $article->getArticle_id(); ?>">
        <div>
            <em>Référence : </em><?php echo $article->getArticle_id(); ?>
        </div>
        <div>
            <em>Nom : </em><?php echo $article->getArticle_nom(); ?>
        </div>
        <div>
            <em>Prix : </em>
            <span class="hidden" id="prix<?php echo $article->getArticle_id(); ?>"><?php echo $article->getArticle_prix(); ?></span>
            <?php echo number_format($article->getArticle_prix(), 2); ?>
        </div>
        <div>
            <em>Stock : </em>
            <span id="stock<?php echo $article->getArticle_id(); ?>"><?php echo $article->getArticle_stock(); ?></span>
        </div>
        <div>
            <em>Disponibilité : </em><?php echo $article->getArticle_dispo(); ?>
        </div>
        <div>
            <em>Type : </em><?php echo $article->getArticle_type(); ?>
        </div>
        <div>
            <em>Fournisseur : </em><?php echo $article->getFournisseur_nom(); ?>
        </div>
        <?php if ($article->getArticle_stock() != 0) { ?>
            <input class="ajouter" type="button" id="ajouter<?php echo $article->getArticle_id(); ?>" value="Ajouter au panier" />
            <select class="quantite" id="qte<?php echo $article->getArticle_id(); ?>">
                <?php for ($j = 0; $j < $article->getArticle_stock(); $j++) { ?>
                    <option value="<?php echo $j + 1; ?>"><?php echo $j + 1; ?></option>
                <?php } ?>
            </select>
        <?php } else { ?>
            <input id="ajouter<?php echo $article->getArticle_id(); ?>" value="Rupture de stock" type="button" class="rupture" disabled />
        <?php } ?>
    </div>
    <?php
}    