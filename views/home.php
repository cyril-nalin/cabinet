    <main>
        <section>
            <?php if(empty($NEWS_DATA)) {  ?>
                    <p>Aucune news n'est disponible.</p>
            <?php } else { ?>
                    <h2>Liste des actualités</h2>
            <?php foreach($NEWS_DATA as $news): ?>
                    <div class="news_item">
                        <h3><?= $news['titre'] ?></h3>
                        <div class="news_content_block">
                        <?php if(!empty($news['lien_media'])) { ?>
                        <div class="news_media"><img src="<?= $news['lien_media'] ?>" alt="Media" /></div>
                        <?php } ?>
                        <p class="news_content"><?= $news['contenu'] ?></p></div>
                        <div class="news_info"><p class="news_author">Publié par : <?= $news['nom'],' ', $news['prenom']?></p>
                        <p class="news_date"><?= $news['news_date']?></p></div>
                    </div>
            <?php endforeach; }?>
        </section>
    </main>
