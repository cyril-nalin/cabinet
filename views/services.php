<?php
require_once __DIR__ . '/../models/Service.php';
require_once __DIR__ . '/_Top.php';
$o = new Service();
$datas = $o->getAll();
?>
    <main>
        <section>
            <h2>Services proposés</h2>
            <ul>
                <?php
                foreach($datas as $v) {
                    echo '<li>', $v['type'], '</li>';
                }
                ?>
            </ul>
        </section>
    </main>
<?php
require_once __DIR__ . '/_Bottom.php';
?>
