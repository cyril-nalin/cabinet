<?php

require_once __DIR__ . '/Database.php';

class Service extends Table
{
    public function __construct() {
        parent::__construct();
        $this->setName('service');
    }
/*
    public function add($type_soin, $desc): int {
        try{
            $sql = 'INSERT INTO `service` (`type_soin`, `type`) VALUES (:type_soin, :desc)';
            $stmt = $this->getDB()->prepare($sql);
            $stmt->execute([
                    'type_soin' => $type_soin,
                    'desc' => $desc
                ]);
            return $stmt->rowCount();
        }
        catch (PDOException $e) {
            return 0;
        }
    }
    public function upd($id, $type_soin, $desc): int {
        $sql = 'UPDATE `service` SET `type_soin` = :type_soin, `type` = :desc WHERE `id` = :id';
        $stmt = $this->getDB()->prepare($sql);
        $stmt->execute([
                'type_soin' => $type_soin,
                'desc' => $desc
            ]);
        return $stmt->rowCount();
    }*/
}

?>
