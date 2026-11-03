<?php
require_once __DIR__ . '/../models/Config.php';
require_once __DIR__ . '/../models/RendezVous.php';
require_once __DIR__ . '/_Top.php';

$o = new Config();
$cfg = $o->get();

$hmin = sprintf('%02u', $cfg['heure_min']);
$hmax = sprintf('%02u', $cfg['heure_max']);
?>
    <main>
        <section>
            <p>TODO: formulaire prise de rdv</p>

            <div id="rdv_form_container">    
                
            <?php
            $show_form = TRUE;
            if(isset($_POST['date'], $_POST['heure'])) {
                $date = trim($_POST['date']);
                $heure = trim($_POST['heure']);
                $motif = trim($_POST['motif']);

                if(!empty($date) && !empty($heure)) {
                    $o = new RendezVous();
                    $result = $o->add($_SESSION['client_id'], $date . ' ' . $heure, $motif, 0); 
                    if(1 === $result) {
                        echo "<p>Votre demande de rendez-vous a été enregistrée avec succès.</p>";
                        $show_form = FALSE;
                    } else if(-1 === $result) {
                        echo "<p>Le rendez-vous est déjà pris pour cette date et cette heure.</p>";
                    } else {
                        echo "<p>Une erreur est survenue lors de l'enregistrement de votre demande. Veuillez réessayer.</p>";
                    }
                } else {
                    echo "<p>Tous les champs sont requis.</p>";
                }
            }
            if($show_form) {
            ?>
                <form action="index.php?page=rendez-vous" method="POST">
                    <h2>Prendre rendez-vous</h2>
<!--
                    <div class="rdv_form_container_item">
                        <label for="nom">Nom :</label><br />
                        <input type="text" id="nom" name="nom" value="<?php echo $_SESSION['nom'] ?? NULL; ?>" required>
                    </div>
                    <div class="rdv_form_container_item">
                        <label for="prenom">Prénom :</label><br />
                        <input type="text" id="prenom" name="prenom" value="<?php echo $_SESSION['prenom'] ?? NULL; ?>" required>
                    </div>

                    <div class="rdv_form_container_item">
                        <label for="email">Adresse e-mail :</label><br />
                        <input type="email" id="email" name="email" value="<?php echo $_SESSION['email'] ?? NULL; ?>" required>
                    </div>
-->
    <!--
                    <label for="telephone">Téléphone :</label>
                    <input type="tel" id="telephone" name="telephone" required>
    -->
                    <div class="rdv_form_container_item">
                        <label for="date">Date du rendez-vous :</label><br />
                        <input type="date" id="date" name="date" required>
                    </div>
                    <script>
                    document.getElementById('date').addEventListener('change', function () {
                        const date = new Date(this.value + 'T00:00:00');
                        const jour = date.getDay();

                        if (jour === 0 || jour === 6) {
                            alert("Les rendez-vous ne sont pas possibles le week-end.");
                            this.value = "";
                        }
                    });
                    </script>

                    <div class="rdv_form_container_item">
                        <label for="heure">Heure du rendez-vous (<?php echo $hmin; ?>h00 - <?php echo $hmax; ?>h00) :</label><br />
                        <input value="08:00" type="time" id="heure" name="heure" min="<?php echo $hmin; ?>:00" max="<?php echo $hmax; ?>:00" required>
                    </div>

                    <div class="rdv_form_container_item">
                        <label for="motif">Motif du rendez-vous :</label><br />
                        <select id="motif" name="motif" required>
                            <option value="">-- Choisir un motif --</option>
                            <option value="0">Consultation</option>
                            <option value="1">Détartrage</option>
                            <option value="2">Soins dentaires</option>
                            <option value="3">Dévitalisation</option>
                            <option value="4">Prothèse</option>
                            <option value="5">Urgence dentaire</option>
                            <option value="6">Autre</option>
                        </select>
                    </div>
    <!--
                    <label for="message">Informations complémentaires :</label>
                    <textarea id="message" name="message" rows="4"></textarea>
-->
                    <button type="submit">Confirmer ma demande</button>

                </form>
                <?php }//$show_form ?>
            </div>

        </section>
    </main>
<?php
require_once __DIR__ . '/_Bottom.php';
?>
