<?php

require_once __DIR__ . '/Database.php';

class News
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnexion();
    }

    public function getAll(): array
    {
        $sql = 'SELECT *
                FROM `news`
                ORDER BY `id` ASC';

        $requete = $this->db->query($sql);

        return $requete->fetchAll();
    }
	
    public function getById($id): array
    {
        $sql = 'SELECT * FROM `news` WHERE `id` = :id';
		$stmt = $this->db->prepare($sql);
		$stmt->execute([
			'id'   => $id
		]);
        return $stmt->fetch();
    }

    public function getByClientId($id)
    {
        try {
            $sql = 'SELECT * FROM `news` WHERE `client_id` = :id';

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'id'   => $id
            ]);
            $ret =  $stmt->fetch();
        } catch (PDOException $e) {
            return FALSE;
        }
        return $ret;
    }

    public function add($client_id, $date_news, $titre, $contenu, $lien_media, $visible){
        try {
            $sql = 'INSERT INTO `news`(`client_id`,`date_news`,`titre`,`contenu`,`lien_media`,`visible`) '
            . 'VALUES (:client_id, :date_news, :titre, :contenu, :lien_media, :visible)';

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'client_id' => $client_id,
                'date_news' => $date_news,
                'titre' => $titre,
                'contenu' => $contenu,
                'lien_media' => $lien_media,
                'visible' => $visible
            ]);
            return (1 === $stmt->rowCount()) ? '1' : '0';
        } catch (PDOException $e) {
            return FALSE;
        }
    }

    public function upd($id, $titre, $contenu, $lien_media, $visible){
        try {
            $sql = 'UPDATE `news` SET  `titre` = :titre, `contenu` = :contenu, `lien_media` = :lien_media, `visible` = :visible WHERE `id` = :id';

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'id' => $id,
                'titre' => $titre,
                'contenu' => $contenu,
                'lien_media' => $lien_media,
                'visible' => $visible
            ]);
            return (1 === $stmt->rowCount()) ? '1' : '0';
        } catch (PDOException $e) {
            return FALSE;
        }
    }

    public function del($id){
        try {
            $sql = 'DELETE FROM `news` WHERE `id` = :id';
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
