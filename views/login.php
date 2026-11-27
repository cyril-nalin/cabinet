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
                if(isset($err) && !empty($err)) {
                    echo '<p class="error">', $err, '</p>';
                }
                ?>
            </div>
        </section>
    </main>
