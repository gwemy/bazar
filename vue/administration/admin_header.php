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
                a{
                    font-size: 0.8em;
                    border: 1px solid grey;
                    text-decoration: none;
                    padding: 5px;
                    color: black;
                    background-color: #cccccc;
                    font-family: sans-serif;
                }
            </style>
        </head>
        <body>
            <h1>Administration</h1>
            <a href="index.php">← retour à la boutique</a>
            <a href="index.php?page=admin&action=stocks">État des stocks</a>
            <a href="index.php?page=admin&action=clients">Gestion des clients</a>
            <a href="index.php?page=admin&action=commandes">Liste des commandes</a>
            <a href="index.php?page=admin&action=affaire">Chiffre d'affaire</a>
            <a href="index.php?page=admin&action=personnel">Gestion du personnel</a>
            <br/><br/>
            <?php
        }