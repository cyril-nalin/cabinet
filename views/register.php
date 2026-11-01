<?php
$EXTRA_HTML_HDRS = '<link rel="stylesheet" href="./assets/css/register.css" />';
require_once __DIR__ . '/_Top.php';
?>
    <main>
        <section>
            <form id="reg_form" action="" method="POST">

                <label for="nom">Nom :</label><br>
                <input type="text" id="nom" name="nom" value="azerty" required>
                <br><br>

                <label for="prenom">Prénom :</label><br>
                <input type="text" id="prenom" name="prenom" value="azerty" required>
                <br><br>

                <label for="email">Adresse email :</label><br>
                <input type="email" id="email" name="email" value="azerty@azerty.com" required>
                <br><br>

                <label for="password">Mot de passe :</label><br>
                <input type="password" id="password" name="password" value="azertyuiop" required minlength="8">
                <br><br>

                <label for="confirmation">Confirmer le mot de passe :</label><br>
                <input type="password" id="confirmation" name="confirmation" value="azertyuiop" required>
                <br><br>

                <label>
                    <input type="checkbox" name="conditions" checked="checked" required>
                    J'accepte les conditions d'utilisation
                </label>
                <br><br>

                <input type="button" id="btn_reg" value="S'inscrire" onclick="regCheckAndDo()">

            </form>
            <div id="reg_err_msg"> </div>
        </section>
    </main>
<?php
require_once __DIR__ . '/_Bottom.php';
?>
<script type="text/javascript" src="./assets/js/register.js"></script>