<?php
require_once __DIR__ . '/../models/RendezVous.php';
require_once __DIR__ . '/../models/Person.php';

$EXTRA_HTML_HDRS = '<link rel="stylesheet" href="./assets/css/gestion.css"/><script type="text/javascript" src="./assets/js/gestion.js"></script>';
require_once __DIR__ . '/_Top.php';


$type_gest = $_GET['q'] ?? 'rdv';
$type_action = $_GET['a'] ?? NULL;
$action_id = $_GET['id'] ?? NULL;
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
                echo '<h3>Gestion des rendez-vous</h3><div id="block_gest">';

                // PHP Query 
                /*
                $o = new RendezVous();
                $rdv = $o->getAll();
                if( !is_array($rdv) || empty($rdv)) {
                    echo "<div id="gest_rdvs"><p>Aucun RDV n'est disponible.</p></div>";
                } else {
                    echo '<table><caption>Liste des rendez-vous</caption>';
                    echo '<thead><tr><th>Nom</th><th>Prénom</th><th>Type de soin</th><th>Date RDV</th></tr><tbody>';
                    $opersonels = new Person();
                    foreach($rdv as $r) {
                        $infos = $opersonels->getByClientId($r['client_id']);
                        echo '<tr>';
                        //echo '<td>',  $r['id'], '</td><td>',  $r['client_id'], '</td>';
                        $dte = new DateTime($r['date_rdv'], new DateTimeZone('Europe/Paris'));
                        $s = $dte->format('d/m/Y H:i:s');
                        echo '<td>', $infos['nom'], '</td><td>', $infos['prenom'], '</td><td>',  $r['type_soin'], '</td><td>',  $s, '</td>';
                        echo '<td><input type="button" onclick="javascript:goToLoc(\'index.php?page=gestion&q=rdv&a=edit&id=', $r['id'], '\')" value="Editer" /></td>';
                        echo '<td><input type="button" onclick="goToLoc(\'index.php?page=gestion&q=rdv&a=del&id=', $r['id'], '\')" value="Supprimer" /></td>';
                        echo '</tr>';
                    }
                    echo '</tbody></table>';
                }*/
                ?>
                <div id="gest_rdvs"></div><script type="text/javascript">runGetRdvsDatas('gest_rdvs');</script>
                <?php
                echo '</div>';
            }

            ?>
        </section>
    </main>
<?php
require_once __DIR__ . '/_Bottom.php';
?>
