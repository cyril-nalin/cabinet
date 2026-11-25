<?php

require_once __DIR__ . '/Database.php';


class Service extends Table
{
    public function __construct() {
        parent::__construct();
        $this->setName('service');
        $this->setFields(['type_soin', 'type']);
    }

    public static function getTypes():array {
        return ['CONSULT', 'DETARTRAGE', 'CARIE', 'DEVITALISATION', 'PROTHESE', 'URGENCE', 'AUTRE'];
    }
}

?>
