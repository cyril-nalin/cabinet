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
		require __DIR__ . '/../views/' . $this->page . '.' . $this->ftype;
	}
}

require __DIR__ . '/HomeController.php';
require __DIR__ . '/RendezVousController.php';

?>
