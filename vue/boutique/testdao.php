<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Le Bazar de l'Aventurier</title>
        <link rel="stylesheet" type="text/css" href="vue/css/normalize.css" />
        <link rel="stylesheet" type="text/css" href="vue/css/style.css" />
        <link rel="stylesheet" href="vue/polices/font-awesome/css/font-awesome.min.css">
    </head>
    <body id="body">
        <div id="fixedHeader">
            <div id="test"></div>
            <header>
                <h1>
                    <span id="titre"><span id="swordsBabySwords">⚔</span>Le Bazar de l'Aventurier</span>
                    <i class="fa fa-shopping-basket boutonHeader" id="bouton_afficher_panier">
                        <?php if (isset($_SESSION['panier'])) { ?>
                            <span id="nombre_articles_panier"><?php echo sizeof($_SESSION['panier']); ?></span>
                        <?php } else { ?>
                            <span id="nombre_articles_panier"></span>
                        <?php } ?>
                    </i>
                    <?php if (!isset($_SESSION['statusConnexion'])) { ?>
                        <i class="fa fa-sign-in boutonHeader" id="bouton_afficher_connexion"></i>
                        <i class="fa fa-user-plus boutonHeader" id="bouton_afficher_inscription"></i>
                    <?php } else { ?>
                        <i class="fa fa-sign-out boutonHeader" id="bouton_afficher_deconnexion"></i>
                        <i class="fa fa-user boutonHeader" id="bouton_afficher_compte"></i>
                    <?php } ?>
                    <i class="fa fa-search boutonHeader" id="bouton_afficher_recherche"></i>
                    <?php if (isset($_SESSION['statusConnexion']) AND $_SESSION['statusConnexion'] == 'administrateur') { ?>
                        <i class="fa fa-cogs boutonHeaderNoDiv" id="administration"></i>
                    <?php } ?>
                    <?php if (isset($_SESSION['statusConnexion']) AND $_SESSION['statusConnexion'] == 'magasinier') { ?>
                        <i class="fa fa-truck boutonHeaderNoDiv" id="stocks"></i>
                    <?php } ?>
                    <i class="fa fa-bug boutonHeader" id="bouton_afficher_debug"></i>
                    <span id="menu_option_texte"> </span>
                </h1>
            </header>
            <div id="div_deconnexion" class="deroulant">
                <span class="hoverable" id="bouton_deconnexion">Confirmer la déconnexion (votre panier sera perdu)</span>
            </div>
            <div id="div_compte" class="deroulant">
                <div id="div_commandes"></div>
                <div id="div_une_commande"></div>
            </div>
            <div id="div_recherche" class="deroulant">
                <div id="champ_recherche_div">
                    <label for="champ_recherche">Recherche</label>
                    <input name="recherche" id="champ_recherche" type="text" placeholder="article dont le nom contient..."/>
                </div>
                <span id="bouton_categorie_" class="bouton_categorie hoverable">Toutes catégories</span>
                <span id="bouton_categorie_Arme" class="bouton_categorie hoverable">Armes</span>
                <span id="bouton_categorie_Armure" class="bouton_categorie hoverable">Armures</span>
                <span id="bouton_categorie_Accessoire" class="bouton_categorie hoverable">Accessoires</span>
                <span id="bouton_categorie_Consommable" class="bouton_categorie hoverable">Consommables</span>
            </div>
            <div id="div_panier" class="deroulant"></div>
            <div id="div_connexion" class="deroulant">
                <form action="index.php" method="post">
                    <div>
                        <label for="login_log">Identifiant</label>
                        <input name="login" id="login_log" type="text" />
                    </div>
                    <div>
                        <label for="pass_log">Mot de passe</label>
                        <input name="pass" id="pass_log" type="password" />
                    </div>
                    <input type="hidden" name="action" value="connecter"/>
                    <input type="submit" class="hoverable" id="seConnecter" value="Se connecter" />
                </form>
            </div>
            <div id="div_inscription" class="deroulant">
                <form action="index.php" method="post">
                    <div>
                        <label for="login_reg">Identifiant</label>
                        <input name="login" id="login_reg" type="text" />
                    </div>
                    <div>
                        <label for="pass_reg">Mot de passe</label>
                        <input name="pass" id="pass_reg" type="password" />
                    </div>
                    <input type="hidden" name="action" value="inscrire"/>
                    <input type="submit" class="hoverable" id="sInscrire" value="S'inscrire" />
                </form>
            </div>
            <div id="div_debug" class="deroulant">
                <pre>
                    <?php
                    echo 'SESSION ';
                    print_r($_SESSION);
                    ?>
                </pre>
                <pre>
                    <?php
                    echo 'POST ';
                    print_r($_POST);
                    ?>
                </pre>
                <pre>
                    <?php
                    echo 'GET ';
                    print_r($_GET);
                    ?>
                </pre>

            </div>
        </div>
        <div id="mainWrapper">
            <div id="retour">
                <?php
                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                    /* unset($_SESSION['message']); */
                }
                ?>
            </div>
            <section id="section">
                <?php include 'vue/boutique/catalogue.php'; ?>
            </section>
        </div>
        <script src="vue/js/jquery.js"></script>
        <script src="vue/js/test.js"></script>
        <script src="vue/js/ajax.js"></script>
    </body>
</html>