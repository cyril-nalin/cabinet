<?php

require_once __DIR__ . '/Database.php';

class Config
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnexion();
    }

    public function get(): array
    {
        $sql = 'SELECT * FROM `config`';
        $requete = $this->db->query($sql);
        return $requete->fetch();
    }

    public function set($min, $max): bool
    {
        $sql = 'UPDATE `config` SET `heure_min` = :min, `heure_max` = :max WHERE 1';
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['min' => $min, 'max' => $max]);
        return (1 === $stmt->rowCount());
    }
}
?>
