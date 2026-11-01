<?php

require_once __DIR__ . '/Database.php';

class RendezVous
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnexion();
    }

    public function getAll(): array
    {
        $sql = 'SELECT * FROM `rdv` ORDER BY `date_rdv` ASC';
        $requete = $this->db->query($sql);
        return $requete->fetchAll();
    }

    public function get($email): array
    {
        $sql = 'SELECT * FROM `rdv` WHERE `email` = :mail ORDER BY `date_rdv` ASC';
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['mail' => $email]);
        return $stmt->fetchAll();
    }

    public function add($client_id, $date_rdv, $type_soin, $confirm = 0): int
    {
        $sql = 'INSERT INTO `rdv` (`client_id`, `date_rdv`, `type_soin`, `confirm`) VALUES (:client_id, :date_rdv, :type_soin, :confirm)';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
                'client_id' => $client_id,
                'date_rdv' => $date_rdv,
                'type_soin' => $type_soin,
                'confirm' => $confirm
            ]);
        return $stmt->rowCount();
    }
    public function upd($id, $date, $confirm, $type_soin): int
    {
        $sql = 'UPDATE `rdv` SET `date_rdv` = :date_rdv, `confirm` = :confirm, `type_soin` = :type_soin WHERE `id` = :id';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
                'id' => $id,
                'date_rdv' => $date,
                'confirm' => $confirm,
                'type_soin' => $type_soin
            ]);
        return $stmt->rowCount();
    }

    public function del($id): int
    {
        $sql = 'DELETE FROM `rdv` WHERE `id` = :id';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
                'id' => $id
            ]);
        return $stmt->rowCount();
    }
}
?>
