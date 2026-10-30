<?php
require_once __DIR__ . '/_Top.php';
require_once __DIR__ . '/../models/RendezVous.php';
require_once __DIR__ . '/../models/Person.php';

$o = new RendezVous();
$rdv = $o->getAll();

$opersonels = new Person();


?>
    <main>
        <section>
            
            <?php
            if( !is_array($rdv) || empty($rdv)) {

            } else {
                echo '<table><caption>Liste des rendez-vous</caption>';
                echo '<thead><tr><th>Nom</th><th>Prénom</th><th>Type de soin</th><th>Date RDV</th></tr><tbody>';
                foreach($rdv as $r) {
                    $infos = $opersonels->getByClientId($r['client_id']);
                    echo '<tr>';
                    //echo '<td>',  $r['id'], '</td><td>',  $r['client_id'], '</td>';
                    echo '<td>', $infos['nom'], '</td><td>', $infos['prenom'], '</td><td>',  $r['type_soin'], '</td><td>',  $r['date_rdv'], '</td>';
                    echo '</tr>';
                }
                echo '</tbody></table>';
            }
            ?>
            
        </section>
    </main>
<?php
require_once __DIR__ . '/_Bottom.php';
?>
