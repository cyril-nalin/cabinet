<?php
require_once __DIR__ . '/RendezVous.php';
require_once __DIR__ . '/Person.php';

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
            echo $o->updateFull($j->id, $j->date_rdv, $j->confirm, $j->type_soin);
        }
    break;

    default: break;
}
?>
