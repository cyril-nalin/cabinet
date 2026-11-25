<?php

require_once __DIR__ . '/Database.php';


//TODO:En COURS DE REECRITURE DU CODE
class Person /*extends Table*/
{
/**    public function __construct() {
        parent::__construct();
        $this->setName('person');
        $this->setFields(['nom', 'prenom', 'prenom', 'email', 'access', 'pwd']);
    }

    public function getByEmail($smail): array {
        return $this->getByColName('email', $smail);
    }

    public function exists($email):bool {
        return 0 !== $this->Count('email', $email);
    }

    public function validateLogin($email, $password){
        return $this->CountFromArray(['email', 'pwd']], [$email, keygen($password)])
    }

    public function updSimple($id, $nom, $prenom) {
        return $this->upd($id, array('nom','prenom'), array($nom, $prenom))
    }
*/

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
            return $stmt->fetch();
        } catch (PDOException $e) {
            //throw new PDOException($e->getMessage(), (int)$e->getCode());
            return FALSE;
        }
    }

    public function validateLogin($email, $password)
    {
        try {
            //$sql = 'SELECT `nom`,`prenom`,`email`,`access` FROM `person` WHERE `email` = :mail AND `pwd` = :password';
            $sql = 'SELECT * FROM `person` WHERE `email` = :mail';
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'mail'   => $email
            ]);
            $tmp = $stmt->fetch();
            if(!is_array($tmp)) return FALSE;
            var_dump(password_hash('testtest', PASSWORD_DEFAULT));
            if(!password_verify($password, $tmp['pwd'])) return FALSE;
            return $tmp;
        } catch (PDOException $e) {
            //throw new PDOException($e->getMessage(), (int)$e->getCode());
            return FALSE;
        }
        return FALSE;
    }

    public function exists($email) {
        $sql = 'SELECT COUNT(*) FROM `person` WHERE `email` = :email';

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'email' => $email,
        ]);

        if ((int) $stmt->fetchColumn() > 0) {
            return TRUE;
        }
        return FALSE;
    }

    public function add($nom, $prenom, $email, $password) {
        $k = password_hash($password, PASSWORD_DEFAULT);
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
    public function updSimple($id, $nom, $prenom) {
        try {
            $sql = 'UPDATE `person` SET `nom` = :nom, `prenom` = :prenom WHERE `id` = :id';
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'id' => $id,
                'nom'   => $nom,
                'prenom' => $prenom
            ]);
            return (1 === $stmt->rowCount()) ? '1' : '0';
        } catch (PDOException $e) {
            return FALSE;
        }
    }

    public function upd($id, $nom, $prenom, $email, $password = NULL) {
        if(NULL !== $password) {
            $k = password_hash($password, PASSWORD_DEFAULT);
            try {
                $sql = 'UPDATE `person` SET `nom` = :nom, `prenom` = :prenom, `email` = :email, `pwd` = :pass WHERE `id` = :id';
                
                $stmt = $this->db->prepare($sql);
                $stmt->execute([
                    'id' => $id,
                    'nom'   => $nom,
                    'prenom' => $prenom,
                    'email' => $email,
                    'pwd' => $k
                ]);
                return (1 === $stmt->rowCount()) ? '1' : '0';
            } catch (PDOException $e) {
                return FALSE;
            }
        } else {
            try {
                $sql = 'UPDATE `person` SET `nom` = :nom, `prenom` = :prenom, `email` = :email WHERE `id` = :id';
                
                $stmt = $this->db->prepare($sql);
                $stmt->execute([
                    'id' => $id,
                    'nom'   => $nom,
                    'prenom' => $prenom,
                    'email' => $email
                ]);
                return (1 === $stmt->rowCount()) ? '1' : '0';
            } catch (PDOException $e) {
                return FALSE;
            }
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
