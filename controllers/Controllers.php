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
		require __DIR__ . '/../views/' . $this->page . '.' . $this->ftype;
	}
}

require __DIR__ . '/HomeController.php';
require __DIR__ . '/RendezVousController.php';

?>
