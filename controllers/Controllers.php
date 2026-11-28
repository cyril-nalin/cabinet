<?php 

require_once('BaseControl.php');

class Controllers {
	private ?string $page;
	private string $ftype;
	
	public function __construct($sPage = NULL) {
		$this->page = $sPage;
		$this->ftype = 'php';
	}
	
	public function __destruct() {
	}
	
	public function setPage(string $spage): void {
		$this->page = $spage;
	}
	
	public function view(): void {
		if(0 === strcasecmp('logout', $this->page)) {
			session_destroy();
			session_commit();
			unset($_SESSION);
			unset($LOG_STATE);
			header('Location: ./index.php');
			exit;
		}
		$LOG_STATE = (array_key_exists('state', $_SESSION) && TRUE === $_SESSION['state']);
		$LOG_LEVEL = 0;
		if(TRUE === $LOG_STATE ) {
			switch($_SESSION['access']) {
				case 'ADMIN': $LOG_LEVEL = 3; break;
				case 'PERSONNEL': $LOG_LEVEL = 2; break;
				case 'CLIENT': $LOG_LEVEL = 1; break;
				default:  break;
			}
		}
		switch($this->page) {
			case 'rendez-vous':
			case 'membre':
				if($LOG_LEVEL < 1) {
					header('Location: ./index.php?page=login');
					exit;
				}
			break;

			case 'gestion':
				if($LOG_LEVEL < 2) {
					header('Location: ./index.php?page=login');
					exit;
				}
			default: break;
		}

		switch($this->page) {

			case 'about':
				$obj = new AboutControl();
				$obj->Display($LOG_STATE, $LOG_LEVEL);
				break;

			case 'login':
				$obj = new LoginControl();
				$obj->Display($LOG_STATE, $LOG_LEVEL);
				break;

			case 'services':
				$obj = new ServicesControl();
				$obj->Display($LOG_STATE, $LOG_LEVEL);
				break;

			case 'register':
				$obj = new RegisterControl();
				$obj->Display($LOG_STATE, $LOG_LEVEL);
				break;

			case 'rdv':
				$obj = new RdvControl();
				$obj->Display($LOG_STATE, $LOG_LEVEL);
				break;

			case 'membre':
				$obj = new MembreControl();
				$obj->Display($LOG_STATE, $LOG_LEVEL);
				break;

			case 'home':
				$obj = new HomeControl();
				$obj->Display($LOG_STATE, $LOG_LEVEL);
				break;

			default:
				require __DIR__ . '/../views/' . $this->page . '.' . $this->ftype;
				break;
		}

		
	}
}

?>
