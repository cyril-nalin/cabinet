<?php

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Crypto.php';

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
            throw new PDOException($e->getMessage(), (int)$e->getCode());
            return FALSE;
        }
        return $ret;
    }

    public function validateLogin($email, $password)
    {
        $k = keygen($password);
        try {
            $sql = 'SELECT `nom`,`prenom`,`email`,`access` FROM `person` WHERE `email` = :mail AND `pwd` = :password';

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'mail'   => $email,
                'password' => $k
            ]);
            return $stmt->fetch();
            //return (1 === $stmt->rowCount());
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
            return FALSE;
        }
        return FALSE;
    }

    public function add($nom, $prenom, $email, $password) {
        $k = keygen($password);
        try {
            $sql = 'SELECT COUNT(*) FROM `person` WHERE `email` = :email';

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'email' => $email,
            ]);

            if ((int) $stmt->fetchColumn() > 0) {
                return 2;
            }

            $sql = 'INSERT INTO `person`(`nom`,`prenom`,`email`,`pwd`,`access`) VALUES (:nom, :prenom, :email, :key, :access)';

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'nom'   => $nom,
                'prenom' => $prenom,
                'email' => $email,
                'key' => $k,
                'access' => 'CLIENT'

            ]);
            return (1 === $stmt->rowCount()) ? '1' : '0';
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
            return FALSE;
        }
        return FALSE;
    }


    public function upd($id, $nom, $prenom, $email, $password) {
        $k = keygen($password);
        try {
            $sql = 'SELECT COUNT(*) FROM `person` WHERE `email` = :email';

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'email' => $email,
            ]);

            if ((int) $stmt->fetchColumn() > 0) {
                return 2;
            }

            $sql = 'UPDATE `person` SET `nom` = :nom, `prenom` = :prenom, `pwd` = :key, `access` = :access `email` = :email WHERE `id` = :id';

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'id' => $id,
                'nom'   => $nom,
                'prenom' => $prenom,
                'email' => $email,
                'key' => $k,
                'access' => 'CLIENT'

            ]);
            return (1 === $stmt->rowCount()) ? '1' : '0';
        } catch (PDOException $e) {
            return FALSE;
        }
    }

    public function del($id) {
        try {
            $sql = 'DELETE FROM `person` WHERE `id` = :id';

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'id' => $id
            ]);
            return (1 === $stmt->rowCount()) ? '1' : '0';
        } catch (PDOException $e) {
            return FALSE;
        }
    }
}
?>
