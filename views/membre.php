    <main>
        <section>
            <div id="member_gest">
            <?php
            if(isset($success) && !empty($success)) echo '<p class="success">', $success,'</p>';
            else if(isset($err) && !empty($err)) echo '<p class="error">', $err,'</p>';
                ?>
            <div id="form_container">
                <form id="form_membre" method="POST" action="index.php?page=membre" enctype="multipart/form-data">
                    <h3>Mes informations</h3>
                    <div class="form_container_item">
                        <label for="nom">Nom:</label><br />
                        <input type="text" name="nom" id="nom" value="<?php echo $_SESSION['nom'] ?? ''; ?>" required/>
                    </div>
                    <div class="form_container_item">
                        <label for="prenom">Prénom:</label><br />
                        <input type="text" name="prenom" id="prenom" value="<?php echo $_SESSION['prenom'] ?? ''; ?>" required/>
                    </div>
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
        </section>
    </main>

