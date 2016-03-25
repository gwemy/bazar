<?php if (!isset($_SESSION['statusConnexion']) OR $_SESSION['statusConnexion'] != 'administrateur') { ?>
    ⨂ Erreur : vous n'êtes pas authentifié.
<?php } else {
    ?>
    <html>
        <head>
            <meta charset="UTF-8">
            <title>Administration</title>
            <style>
                td, th {
                    border: 1px dotted black;
                    padding: 2px 10px;
                }

                table {
                    border-collapse: collapse;
                }

                .align_right {
                    text-align: right;
                }
                .red {
                    color: red;
                    font-weight: bold;
                }
                .green {
                    color : green;
                    font-weight: bold;
                }
                .align_center{
                    text-align: center;
                }
                #div_chiffre_affaire{
                    overflow: auto;
                }
            </style>
        </head>
        <body>
            <h1>Administration</h1>
            <a href="index.php"><button>← retour à la boutique</button></a>
            <a href="index.php?page=admin&action=stocks"><button>État des stocks</button></a>
            <a href="index.php?page=admin&action=clients"><button>Gestion des clients</button></a>
            <a href="index.php?page=admin&action=commandes"><button>Liste des commandes</button></a>
            <a href="index.php?page=admin&action=affaire"><button>Chiffre d'affaire</button></a>
            <a href="index.php?page=admin&action=personnel"><button>Gestion du personnel</button></a>
            <br/><br/>
            <?php
        }