<?php
require_once __DIR__ . '/../models/RendezVous.php';
require_once __DIR__ . '/../models/Person.php';
require_once __DIR__ . '/../models/News.php';
require_once __DIR__ . '/../models/Config.php';
require_once __DIR__ . '/../models/Service.php';
/*
$o = new Service();
$o->add(
    array('type_soin', 'type'),
    array('AUTRE', 'test')
);
var_dump($o->getAll());
$o->delByColName('type', 'test');
var_dump($o->getAll());*/
$EXTRA_HTML_HDRS = '<link rel="stylesheet" href="./assets/css/gestion.css"/><script type="text/javascript" src="./assets/js/gestion.js"></script>';
require_once __DIR__ . '/_Top.php';


$type_gest = $_GET['q'] ?? 'rdv';
$type_action = $_GET['a'] ?? NULL;
$action_id = $_GET['id'] ?? NULL;

if(!isset($LOG_LEVEL) || $LOG_LEVEL < 2) {
    echo '<p>Vous n\'avez pas les droits pour accéder à cette page.</p>';
    require_once __DIR__ . '/_Bottom.php';
    exit;
}

if(0 === strcmp('per', $type_gest)) {
    if(isset($LOG_LEVEL) && $LOG_LEVEL < 3) {
        echo '<p>Vous n\'avez pas les droits pour accéder à cette page.</p>';
        require_once __DIR__ . '/_Bottom.php';
        exit;
    }
}

/**
Gestion des rendez-vous : Voir, modifier, confirmer ou annuler les rendez-vous pris par les patients.
Gestion des services : Ajouter, modifier ou supprimer les services offerts par le cabinet.
Gestion des actualités : Ajouter, modifier ou supprimer des actualités.
Gestion des patients : Voir, ajouter, modifier ou supprimer des patients.
Gestion des horaires : Modifier les horaires d'ouverture du cabinet.
 */
?>
    <main>
        <section>
            
            <?php
            if(0 === strcmp('rdv', $type_gest)) {
                ?>
                <h3>Gestion des rendez-vous</h3>
                <div id="block_gest"></div>
                <script type="text/javascript">runGetRdvsDatas();</script>
                <?php
            }
            else if(0 === strcmp('per', $type_gest)) {
                echo '<h3>Gestion Personnel/Clients</h3><div id="block_gest">';
                echo '<script type="text/javascript">runPersonnelDatas();</script>';
                echo '</div>';
            }
            else if(0 === strcmp('news', $type_gest)) {
                if($type_action && 0 === strcmp('add', $type_action)) {
                    $o = new News();
                    $date_news = date('Y-m-d H:i:s');
                    $titre = $_POST['titre'] ?? NULL;
                    $article = $_POST['article'] ?? NULL;
                    $image = $_FILES['image'] ?? NULL;

                    if($titre && $article) {
                        if($image && $image['error'] === UPLOAD_ERR_OK) {
                            $target_dir = __DIR__ . "/../uploads/";
                            @mkdir($target_dir, 0777, true); 
                            $target_file = $target_dir . basename($image["name"]);
                            if(move_uploaded_file($image["tmp_name"], $target_file)) {
                                $lien_media = "uploads/" . basename($image["name"]);
                                $visible = 1;
                                if('1' === $o->add($_SESSION['client_id'], $date_news, $titre, $article, $lien_media, $visible)) {
                                    //echo "La news a été ajoutée avec succès.";
                                    //unset($_POST);
                                    header('Location: index.php?page=gestion&q=news');
                                    exit;
                                } else {
                                    echo "Erreur lors de l'ajout de la news.";
                                }
                            } else {
                                echo "Désolé, il y a eu une erreur lors du téléchargement de votre fichier.";
                            }
                        } else {
                            $lien_media = NULL;
                            $visible = 1;
                            if('1' === $o->add($_SESSION['client_id'], $date_news, $titre, $article, $lien_media, $visible)) {
                                header('Location: index.php?page=gestion&q=news');
                                exit;
                            } else {
                                echo "Erreur lors de l'ajout de la news.";
                            }
                        }
                    } else {
                        echo "Tous les champs sont requis.";
                    }
                }//fin add 
                ?>
                <h3>Gestion des actualités</h3>
                <div id="block_gest">
                    <h4>Ecrire une news</h4>
                    <form action="index.php?page=gestion&q=news&a=add" method="POST" enctype="multipart/form-data">

                        <label for="titre">Titre :</label><br />
                        <input type="text" id="titre" name="titre" value="" required>

                        <br /><br />

                        <label for="article">Article :</label><br />
                        <textarea id="article" name="article" rows="8" required></textarea>

                        <br /><br />

                        <label for="image">Image :</label><br />
                        <input type="file" id="image" name="image" accept="image/*">

                        <br /><br />

                        <button type="submit">Envoyer</button>

                    </form>
                </div>
                <div id="block_gest_news"><h4>Liste des news</h4></div>
                <script type="text/javascript">runNewsDatas();</script>
                <?php
            }//fin news
            else if(0 === strcmp('horaire', $type_gest)) {
                $o = new Config();
                $cfg = $o->get();
                if(isset($_POST['heure_min'], $_POST['heure_max'])) {
                    $heure_min = intval(trim($_POST['heure_min']));
                    $heure_max = intval(trim($_POST['heure_max']));
                    if(!empty($heure_min) && !empty($heure_max)) {
                        if($heure_min >= $heure_max) {
                            echo "<p class='error'>L'heure d'ouverture doit être inférieure à l'heure de fermeture.</p>";
                        } else {
                            if($heure_min < 0 || $heure_min > 23 || $heure_max < 0 || $heure_max > 23) {
                                echo "<p class='error'>Les heures doivent être comprises entre 0 et 23.</p>";
                            } else {
                                $o->set($heure_min, $heure_max);
                                echo "<p class='success'>Les horaires ont été mis à jour avec succès.</p>";
                                $cfg = $o->get();
                            }
                        }
                    } else {
                        echo "<p class='error'>Tous les champs sont requis.</p>";
                    }
                }
                ?>
                <h3>Gestion des horaires</h3>
                <div id="block_gest">
                    <form action="index.php?page=gestion&q=horaire&a=upd" method="POST">
                        <label for="heure_min">Heure d'ouverture :</label><br />
                        <input type="text" id="heure_min" name="heure_min" value="<?php echo $cfg['heure_min']; ?>" required>
                        <br /><br />
                        <label for="heure_max">Heure de fermeture :</label><br />
                        <input type="text" id="heure_max" name="heure_max" value="<?php echo $cfg['heure_max']; ?>" required>
                        <br /><br />
                        <button type="submit">Mettre à jour</button>
                </div>
            <?php }
            ?>
        </section>
    </main>
<?php
require_once __DIR__ . '/_Bottom.php';
?>
