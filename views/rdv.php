    <main>
        <section>
            <div id="form_container">    
                
            <?php
            if(isset($err) && !empty($err)) {
                echo '<p>', $err, '</p>';
            }
            if(isset($success) && !empty($success)) {
                echo '<p>', $success, '</p>';
            }
            if(isset($show_form) && $show_form) {
            ?>
                <form action="index.php?page=rendez-vous" method="POST">
                    <h2>Prendre rendez-vous</h2>
                    <div class="form_container_item">
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

                    <div class="form_container_item">
                        <label for="heure">Heure du rendez-vous (<?php echo $hmin; ?>h00 - <?php echo $hmax; ?>h00) :</label><br />
                        <input value="08:00" type="time" id="heure" name="heure" min="<?php echo $hmin; ?>:00" max="<?php echo $hmax; ?>:00" required>
                    </div>

                    <div class="form_container_item">
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
                    <button type="submit">Confirmer ma demande</button>

                </form>
                <?php }//$show_form ?>
            </div>

        </section>
    </main>