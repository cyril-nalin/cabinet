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

    public function updateFull($id, $date, $confirm, $type_soin): int
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
}
?>
