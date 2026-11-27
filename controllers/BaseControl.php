<?php

class BaseControl {
    public function ShowTop(string $hdrs = '', bool $logs = false, int $logl = 0) {
        $EXTRA_HTML_HDRS = $hdrs;
        $LOG_STATE = $logs;
        $LOG_LEVEL = $logl;
        require_once __DIR__ . '/../views/_Top.php';
    }

    public function ShowBottom() {
        require_once __DIR__ . '/../views/_Bottom.php';
    }
}

class AboutControl extends BaseControl {
    public function Display($logs, $logl) {
        parent::ShowTop('<link rel="stylesheet" href="./assets/css/about.css"/>', $logs, $logl);
        require_once __DIR__ . '/../views/about.php';
        parent::ShowBottom();
    }
}

class MembreControl extends BaseControl {
    public function Display($logs, $logl) {
        require_once __DIR__ . '/../models/Person.php';
        $o = new Person();
        $person = $o->getByClientId($_SESSION['client_id'] ?? NULL);
        $err = NULL;
        $success = NULL;
        if(isset($_POST['nom']) && isset($_POST['prenom'])) {
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $mdp = $_POST['mdp'] ?? NULL;
            $mdp_confirm = $_POST['mdp_confirm'] ?? NULL;
            if(0 === strlen($mdp) && 0 === strlen($mdp_confirm)) {
                $o = new Person();
                $res = $o->updSimple($_SESSION['client_id'], $nom, $prenom);
                if($res) {
                    $success = 'Informations mises à jour avec succès.';
                    // Mettre à jour les informations de session
                    $_SESSION['nom'] = $nom;
                    $_SESSION['prenom'] = $prenom;
                } else {
                    $err = 'Erreur lors de la mise à jour des informations.';
                }
            } else {
                if(0 !== strcmp($mdp, $mdp_confirm)) {
                    $err = 'Les mots de passe ne correspondent pas.';
                } else if(strlen($mdp < 8)) {
                    $err = 'Le mot de passe doit contennir au moins 8 caractères.';
                } else {
                    $o = new Person();
                    $res = $o->upd($_SESSION['client_id'], $nom, $prenom, $person['email'], $mdp);
                    if($res) {
                        $success = 'Informations mises à jour avec succès.';
                        // Mettre à jour les informations de session
                        $_SESSION['nom'] = $nom;
                        $_SESSION['prenom'] = $prenom;
                    } else {
                        $err = 'Erreur lors de la mise à jour des informations.';
                    }
                }
            }
        }
        parent::ShowTop('<link rel="stylesheet" href="./assets/css/membre.css"/>', $logs, $logl);
        require_once __DIR__ . '/../views/membre.php';
        parent::ShowBottom();
    }
}

class ServicesControl extends BaseControl {
    public function Display($logs, $logl) {
        parent::ShowTop('', $logs, $logl);
        require_once __DIR__ . '/../models/Service.php';
        $o = new Service();
        $datas = $o->getAll();
        require_once 'views/services.php';
        parent::ShowBottom();
    }
}

class RegisterControl extends BaseControl {
    public function Display($logs, $logl) {
        parent::ShowTop('<link rel="stylesheet" href="./assets/css/register.css" />', $logs, $logl);
        require_once 'views/register.php';
        parent::ShowBottom();
    }
}

class RdvControl extends BaseControl {
    public function Display($logs, $logl) {
        parent::ShowTop('', $logs, $logl);
        require_once __DIR__ . '/../models/Config.php';
        require_once __DIR__ . '/../models/RendezVous.php';

        $o = new Config();
        $cfg = $o->getLimited(1, 0, NULL, FALSE);

        $hmin = sprintf('%02u', $cfg['heure_min']);
        $hmax = sprintf('%02u', $cfg['heure_max']);

        $show_form = TRUE;
        $err = NULL;
        $success = NULL;
        if(isset($_POST['date'], $_POST['heure'])) {
            $date = trim($_POST['date']);
            $heure = trim($_POST['heure']);
            $motif = trim($_POST['motif']);

            if(!empty($date) && !empty($heure)) {
                $o = new RendezVous();
                $result = $o->add($_SESSION['client_id'], $date . ' ' . $heure, $motif, 0); 
                if(1 === $result) {
                    $success = 'Votre demande de rendez-vous a été enregistrée avec succès.';
                    $show_form = FALSE;
                } else if(-1 === $result) {
                    $err = 'Le rendez-vous est déjà pris pour cette date et cette heure.';
                } else {
                    $err = 'Une erreur est survenue lors de l\'enregistrement de votre demande. Veuillez réessayer.';
                }
            } else {
                $err = 'Tous les champs sont requis.';
            }
        }
        require_once 'views/rdv.php';
        parent::ShowBottom();
    }
}

class LoginControl extends BaseControl {
    public function Display($logs, $logl) {
        require_once __DIR__ . '/../models/Person.php';
        $err = NULL;
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST) && array_key_exists('email', $_POST) && array_key_exists('password', $_POST) ){
            $mail = strtolower(trim($_POST['email']));
            $pwd = trim($_POST['password']);
            $o = new Person();
            $res = $o->validateLogin($mail, $pwd);
            if(FALSE !== $res) {
                $_SESSION['state'] = TRUE;
                $_SESSION['client_id'] = $res['id'];
                $_SESSION['nom'] = $res['nom'];
                $_SESSION['prenom'] = $res['prenom'];
                $_SESSION['email'] = $res['email'];
                $_SESSION['access'] = $res['access'];

                header('Location: index.php');
                exit;
            } else {
                $err = 'Les informations saisies ne correspondent pas.';
            }
        }
        parent::ShowTop('', $logs, $logl);
        require_once __DIR__ . '/../views/login.php';
        parent::ShowBottom();
    }
}

?>
