<?php
require_once __DIR__ . '/_Top.php';
require_once __DIR__ . '/../models/Person.php';

$err = NULL;
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST) && array_key_exists('email', $_POST) && array_key_exists('password', $_POST) ){
    $mail = strtolower(trim($_POST['email']));
    $pwd = trim($_POST['password']);
    $o = new Person();
    $res = $o->validateLogin($mail, $pwd);
    if(FALSE !== $res) {
        $_SESSION['state'] = TRUE;
        $_SESSION['client_id'] = $res['id'];
        $_SESSION['nom'] = $res['nom'];
        $_SESSION['prenom'] = $res['prenom'];
        $_SESSION['email'] = $res['email'];
        $_SESSION['access'] = $res['access'];

        header('Location: index.php');
        exit;
    } else {
        $err = 'Les informations saisies ne correspondent pas.';
    }
}
?>
    <main>
        <section>
            <div id="login_box">
                <form method="post" action="index.php?page=login">
                    <label for="email">E-mail:</label>
                    <input type="text" id="email" name="email" placeholder="E-Mail" value="" minlength="5" required />
                    <label for="password">Mot de passe:</label>
                    <input type="password" id="password" name="password" value="" minlength="6" required />
                    <button type="submit" id="btn_log">Envoyer</button>
                </form>
                <?php
                if($err) {
                    echo '<p class="error">', $err, '</p>';
                }
                ?>
            </div>
        </section>
    </main>
<?php
require_once __DIR__ . '/_Bottom.php';
?>
