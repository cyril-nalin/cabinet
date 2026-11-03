<?php
require_once __DIR__ . '/RendezVous.php';
require_once __DIR__ . '/Person.php';
require_once __DIR__ . '/News.php';
require_once __DIR__ . '/Service.php';

$q = $_GET['q'] ?? NULL;
/*
if (!isset($_SESSION['nom'])) {
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'message' => 'Vous devez être connecté.'
    ]);
    exit;
}*/

switch($q) {
    case 'get_rdvs':
        $ret = array();
        $o = new RendezVous();
        $rdv = $o->getAll();
        if(is_array($rdv) && !empty($rdv)) {
            $opersonels = new Person();
            
            foreach($rdv as $r) {
                $infos = $opersonels->getByClientId($r['client_id']);
                if(!is_array($infos) || empty($infos)) {
                    $infos = [
                        'nom' => '',
                        'prenom' => '',
                        'email' => ''
                    ];
                }   
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
        }
        $s = json_encode($ret);
        header('Content-length: ' . strlen($s));
        header('Content-Type: application/json');
        echo $s;
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

    case 'getall_news':
        $o = new News();
        $news = $o->getAll();
        if(!is_array($news) || empty($news)) {
            $news = [];
        }
        header('Content-Type: application/json');
        echo json_encode($news);
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

    case 'getall_person':
        $o = new Person();
        header('Content-Type: application/json');
        echo json_encode($o->getAll());
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
            echo $o->upd($j->id, $j->nom, $j->prenom, $j->email);
        }
    break;

    case 'getall_service':
        $o = new Service();
        echo json_encode($o->getAll());
    break;

    default: break;
}
?>
