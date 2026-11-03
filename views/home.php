<?php
require_once __DIR__ . '/../models/News.php';
require_once __DIR__ . '/../models/Person.php';
require_once __DIR__ . '/_Top.php';

?>
    <main>
        <section>
            <?php
            $o = new News();
            $data = $o->getAll();
            if(!is_array($data) || empty($data)) {  
                echo "<p>Aucune news n'est disponible.</p>";
            } else {
                echo '<h2>Liste des actualités</h2>';
                foreach($data as $n) {
                    if(0 == intval($n['visible'])) {
                        continue;
                    }
                    $p = new Person();
                    $infos = $p->getByClientId($n['client_id']);
                    $dte = new DateTime($n['date_news'], new DateTimeZone('Europe/Paris'));
                    $s = $dte->format('d/m/Y H:i:s');
                    echo '<div class="news_item">';
                        echo '<h3>', $n['titre'], '</h3>';
                        echo '<div class="news_content_block">';
                        if(!empty($n['lien_media'])) {
                            echo '<div class="news_media"><img src="', $n['lien_media'], '" alt="Media" /></div>';
                        }
                        echo '<p class="news_content">',  $n['contenu'], '</p></div>';
                        echo '<div class="news_info"><p class="news_author">Publié par : ',  $infos['nom'], ' ', $infos['prenom'], '</p>';
                        
                        echo '<p class="news_date">',  $s, '</p></div>';
                    
                    echo '</div>';
                }

            }
            ?>
        </section>
    </main>
<?php
require_once __DIR__ . '/_Bottom.php';
?>
