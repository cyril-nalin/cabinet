    <main>
        <section>
            <h2>Services proposés</h2>
            <ul>
                <?php
                foreach($datas as $v) {
                    if('.' !== $v['type']) {
                        echo '<li>', $v['type'], '</li>';
                    }
                }
                ?>
            </ul>
        </section>
    </main>
