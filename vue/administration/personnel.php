<?php if (isset($_SESSION['statusConnexion']) AND $_SESSION['statusConnexion'] == 'administrateur') { ?>
    <table id="table_clients">
        <thead>
            <tr>
                <th>Référence</th>
                <th>Identifiant</th>
                <th>Activé</th>
                <th>Status</th>
                <th>Mot de passe</th>
            </tr>
        </thead>
        <?php foreach ($users as $user) {
            ?>
            <tbody>
                <tr id="user_id_<?php echo $user->getUser_id(); ?>">
                    <td class="align_right">
                        <?php echo $user->getUser_id(); ?>
                    </td>
                    <td>
                        <?php echo $user->getUser_login(); ?>
                    </td>
                    <td class="align_center">
                        <?php if ($user->getUser_actif()) { ?>
                            <span class="green">✓</span>
                        <?php } else { ?>
                            <span class="red">✗</span>
                        <?php } ?>
                    </td>
                    <td>
                        <?php echo $user->getUser_status(); ?>
                    </td>
                    <td>
                        <?php echo $user->getUser_pass(); ?>
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