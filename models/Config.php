<?php

require_once __DIR__ . '/Database.php';

class Config extends Table
{
    public function __construct() {
        parent::__construct();
        $this->setName('config');
        $this->setFields(['heure_min', 'heure_max']);
    }
}
?>
