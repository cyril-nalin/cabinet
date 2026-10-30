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
}
?>
