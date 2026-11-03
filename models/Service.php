<?php

require_once __DIR__ . '/Database.php';

class Service 
{
    private Table $table;

    public function __construct() {
        $this->table = new Table('service');
    }

    public function getAll(): array {
        return $this->table->getAll();
    }

    public function get($id): array {
        return $this->table->get($id);
    }

    public function add($type_soin, $desc): int {
        try{
            $sql = 'INSERT INTO `service` (`type_soin`, `type`) VALUES (:type_soin, :desc)';
            $stmt = $this->table->getDB()->prepare($sql);
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
        $stmt = $this->table->getDB()->prepare($sql);
        $stmt->execute([
                'type_soin' => $type_soin,
                'desc' => $desc
            ]);
        return $stmt->rowCount();
    }

    public function del($id): int {
        return $this->table->del($id);
    }
}
?>
