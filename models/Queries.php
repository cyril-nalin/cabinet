<?php
require_once __DIR__ . '/RendezVous.php';
require_once __DIR__ . '/Person.php';
require_once __DIR__ . '/News.php';

$q = $_GET['q'] ?? NULL;

switch($q) {
    case 'get_rdvs':
        $o = new RendezVous();
        $rdv = $o->getAll();
        if(is_array($rdv) && !empty($rdv)) {
            $opersonels = new Person();
            $ret = array();
            foreach($rdv as $r) {
                $infos = $opersonels->getByClientId($r['client_id']);

                $ret[] = [
                    'id' => $r['id'],
                    'client_id' => $r['client_id'],
                    'date_rdv' => $r['date_rdv'],
                    'type_soin' => $r['type_soin'],
                    'confirm' => (0 === intval($r['confirm'])) ? 0 : 1,
                    'nom' => $infos['nom'],
                    'prenom' => $infos['prenom'],
                    'email' => $infos['email']
                ];
            }
            header('Content-Type: application/json');
            echo json_encode($ret);
        }
    break;

    case 'upd_rdvs':
        $j = @json_decode(@file_get_contents('php://input'));
        if(is_object($j)) {
            $o = new RendezVous();
            echo $o->upd($j->id, $j->date_rdv, $j->confirm, $j->type_soin);
        }
    break;

    case 'del_rdvs':
        $j = @json_decode(@file_get_contents('php://input'));
        if(is_object($j)) {
            $o = new RendezVous();
            echo $o->del($j->id);
        }
    break;

    case 'add_news':
        $j = @json_decode(@file_get_contents('php://input'));
        if(is_object($j)) {
            $o = new News();
            echo $o->add($j->client_id, $j->date_news, $j->titre, $j->contenu, $j->lien_media, $j->visible);
        }
    break;

    case 'upd_news':
        $j = @json_decode(@file_get_contents('php://input'));
        if(is_object($j)) {
            $o = new News();
            echo $o->upd($j->id, $j->titre, $j->contenu, $j->lien_media, $j->visible);
        }
    break;

    case 'del_news':
        $j = @json_decode(@file_get_contents('php://input'));
        if(is_object($j)) {
            $o = new News();
            echo $o->del($j->id);
        }
    break;

    case 'reg':
        $j = @json_decode(@file_get_contents('php://input'));
        if(is_object($j)) {
            $o = new Person();
            echo $o->add($j->nom, $j->prenom, $j->email, $j->password);
        }
    break;

    case 'del_person':
        $j = @json_decode(@file_get_contents('php://input'));
        if(is_object($j)) {
            $o = new Person();
            echo $o->del($j->id);
        }
    break;

    case 'upd_person':
        $j = @json_decode(@file_get_contents('php://input'));
        if(is_object($j)) {
            $o = new Person();
            echo $o->upd($j->id, $j->nom, $j->prenom, $j->email, $j->password);
        }
    break;

    default: break;
}
?>
