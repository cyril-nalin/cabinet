    <main>
        <section>
            <?php
            if(empty($NEWS_DATA)) {  
                echo "<p>Aucune news n'est disponible.</p>";
            } else {
                echo '<h2>Liste des actualités</h2>';
                foreach($NEWS_DATA as $news) {
                    echo '<div class="news_item">';
                    echo '<h3>', $news['titre'], '</h3>';
                    echo '<div class="news_content_block">';
                    if(!empty($news['lien_media'])) {
                        echo '<div class="news_media"><img src="', $news['lien_media'], '" alt="Media" /></div>';
                    }
                    echo '<p class="news_content">',  $news['contenu'], '</p></div>';
                    echo '<div class="news_info"><p class="news_author">Publié par : ',  $news['nom'], ' ', $news['prenom'], '</p>';
                    echo '<p class="news_date">',  $news['news_date'], '</p></div>';
                    echo '</div>';
                }
            }
            ?>
        </section>
    </main>
