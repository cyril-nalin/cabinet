<?php

require_once __DIR__ . '/Database.php';

class Person
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnexion();
    }

    public function getAll(): array
    {
        $sql = 'SELECT *
                FROM `person`
                ORDER BY `id` ASC';

        $requete = $this->db->query($sql);

        return $requete->fetchAll();
    }
	
    public function getByEmail($smail): array
    {
        $sql = 'SELECT * FROM `person` WHERE `email` = :mail';
		$stmt = $this->db->prepare($sql);
		$stmt->execute([
			'mail'   => $smail
		]);
        return $stmt->fetch();
    }

    public function getByClientId($id)
    {
        try {
            $sql = 'SELECT * FROM `person` WHERE `id` = :id';

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'id'   => $id
            ]);
            $ret =  $stmt->fetch();
        } catch (PDOException $e) {
            // Gestion des erreurs
            throw new PDOException($e->getMessage(), (int)$e->getCode());
            return FALSE;
        }
        return $ret;
    }
}
?>
