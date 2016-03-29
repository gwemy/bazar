<?php if (!isset($_SESSION['statusConnexion']) OR $_SESSION['statusConnexion'] != 'administrateur') { ?>
    ⨂ Erreur : vous n'êtes pas authentifié.
<?php } else {
    ?>
    <html>
        <head>
            <meta charset="UTF-8">
            <title>Administration</title>
            <style>
                body {
                    font-family: sans-serif;
                }
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
                a {
                    margin: 0 2px;
                    font-size: 0.9em;
                    border: 1px solid grey;
                    border-radius: 2px;
                    text-decoration: none;
                    padding: 5px;
                    color: black;
                    background-color: #ddd;
                }
                a:hover{
                    background-color: #eee;
                }
                form{
                    margin: 0;
                }
            </style>
        </head>
        <body>
            <h1>Administration</h1>
            <a href="index.php">← retour à la boutique</a>
            <a href="index.php?page=admin&section=stocks">État des stocks</a>
            <a href="index.php?page=admin&section=clients">Gestion des clients</a>
            <a href="index.php?page=admin&section=commandes">Liste des commandes</a>
            <a href="index.php?page=admin&section=affaire">Chiffre d'affaire</a>
            <a href="index.php?page=admin&section=personnel">Gestion du personnel</a>
            <br/><br/>
            <?php
        }