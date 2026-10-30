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
        $sql = "SELECT * FROM `rdv` ORDER BY `date_rdv` ASC";
        $requete = $this->db->query($sql);
        return $requete->fetchAll();
    }
}
?>
