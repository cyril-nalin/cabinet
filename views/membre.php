<?php
$EXTRA_HTML_HDRS = '<link rel="stylesheet" href="./assets/css/membre.css"/>';
require_once __DIR__ . '/../models/Person.php';
require_once __DIR__ . '/_Top.php';
$o = new Person();
$person = $o->getByClientId($_SESSION['client_id'] ?? NULL);
?>
    <main>
        <section>
            <div id="member_gest">
            <?php
            $bshow_form = TRUE;
            if(isset($_POST['nom']) && isset($_POST['prenom'])/* && isset($_POST['email'])*/) {
                $nom = $_POST['nom'];
                $prenom = $_POST['prenom'];
                //$email = $_POST['email'];
                $mdp = $_POST['mdp'] ?? NULL;
                $mdp_confirm = $_POST['mdp_confirm'] ?? NULL;
                if(0 === strlen($mdp) && 0 === strlen($mdp_confirm)) {
                    $o = new Person();
                    $res = $o->updSimple($_SESSION['client_id'], $nom, $prenom);
                    if($res) {
                        echo '<p class="success">Informations mises à jour avec succès.</p>';
                        // Mettre à jour les informations de session
                        $_SESSION['nom'] = $nom;
                        $_SESSION['prenom'] = $prenom;
                    // $_SESSION['email'] = $email;
                        //$bshow_form = FALSE;
                    } else {
                        echo '<p class="error">Erreur lors de la mise à jour des informations.</p>';
                    }
                } else {
                    if(0 !== strcmp($mdp, $mdp_confirm)) {
                        echo '<p class="error">Les mots de passe ne correspondent pas.</p>';
                    } else if(strlen($mdp < 8)) {
                        echo '<p class="error">Le mot de passe doit contennir au moins 8 caractères.';
                    } else {
                        $o = new Person();
                        $res = $o->upd($_SESSION['client_id'], $nom, $prenom, $person['email'], $mdp);
                        if($res) {
                            echo '<p>Informations mises à jour avec succès.</p>';
                            // Mettre à jour les informations de session
                            $_SESSION['nom'] = $nom;
                            $_SESSION['prenom'] = $prenom;
                        // $_SESSION['email'] = $email;
                            $bshow_form = FALSE;
                        } else {
                            echo '<p class="error">Erreur lors de la mise à jour des informations.</p>';
                        }
                    }
                }
            }
            if($bshow_form) {
                ?>
            <div id="form_container">
                <form id="form_membre" method="POST" action="index.php?page=membre" enctype="multipart/form-data">
                    <h3>Mes informations</h3>
                    <div class="form_container_item">
                        <label for="nom">Nom:</label><br />
                        <input type="text" name="nom" id="nom" value="<?php echo $person['nom'] ?? ''; ?>" required/>
                    </div>
                    <div class="form_container_item">
                        <label for="prenom">Prénom:</label><br />
                        <input type="text" name="prenom" id="prenom" value="<?php echo $person['prenom'] ?? ''; ?>" required/>
                    </div>
                    <!--
                    <div class="form_container_item">
                        <label for="email">Email:</label>
                        <input type="email" name="email" id="email" value="<?php echo $person['email'] ?? ''; ?>" required/>
                    </div>
    -->
                    <div class="form_container_item">
                        <label for="mdp">Mot de passe:</label><br />
                        <input type="password" name="mdp" id="mdp"/>
                    </div>
                    <div class="form_container_item">
                        <label for="mdp_confirm">Confirmer le mot de passe:</label><br />
                        <input type="password" name="mdp_confirm" id="mdp_confirm"/>
                    </div>
                    <div class="form_container_item form_btn">
                        <input type="submit" value="Mettre à jour mes informations"/>
                    </div>
                </form>
            </div>
            <?php
            }?>
            </div>
        </section>
    </main>
<?php
require_once __DIR__ . '/_Bottom.php';
?>
