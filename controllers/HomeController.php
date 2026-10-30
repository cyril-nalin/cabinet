<?php

class HomeController extends Controllers {
	public function view(): void {
		$this->setPage('home');
		parent::view();
	}
}

?>
