<?php if (isset($_SESSION['statusConnexion']) AND $_SESSION['statusConnexion'] == 'administrateur') { ?>
    <h2>Gestion des clients</h2>
    <table id="table_clients">
        <thead>
            <tr>
                <th>Référence</th>
                <th>Identifiant</th>
                <th>Activé</th>
                <th> </th>
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

                    <?php if ($user->getUser_actif()) { ?>
                        <td class="align_center">
                            <span class="green">✓</span>
                        <td class="align_center">
                            <form method="POST" action="index.php?page=admin&section=clients">
                                <input type="hidden" name="action" value="bloquer">
                                <input type="hidden" name="id" value="<?php echo $user->getUser_id(); ?>">
                                <input type="submit" value="bloquer">
                            </form>
                        </td>
                    <?php } else { ?>
                        <td class="align_center">
                            <span class="red">✗</span>
                        <td class="align_center">
                            <form method="POST" action="index.php?page=admin&section=clients">
                                <input type="hidden" name="action" value="debloquer">
                                <input type="hidden" name="id" value="<?php echo $user->getUser_id(); ?>">
                                <input type="submit" value="débloquer">
                            </form>
                        </td>
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