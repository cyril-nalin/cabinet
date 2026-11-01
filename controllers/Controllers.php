<?php 
class Controllers {
	private ?string $page;
	private string $ftype;
	
	public function __construct($sPage = NULL) {
		$this->page = $sPage;
		$this->ftype = 'php';
	}
	
	public function __destruct() {
	}
	
	public function setPage($spage): void {
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
		require __DIR__ . '/../views/' . $this->page . '.' . $this->ftype;
	}
}

require __DIR__ . '/HomeController.php';
require __DIR__ . '/RendezVousController.php';

?>
