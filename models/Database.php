<?php

class Database
{
    private static ?PDO $connexion = null;

    public static function getConnexion(): PDO
    {
        if (self::$connexion === null) {
            $host = 'localhost';
            $dbname = 'cabinet';
            $user = 'root';
            $password = '';

            $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

            self::$connexion = new PDO(
                $dsn,
                $user,
                $password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false
                ]
            );
        }

        return self::$connexion;
    }
}

class Table
{
    private PDO $db;
    private string $name;

    public function __construct()
    {
        $this->db = Database::getConnexion();
        $this->name = '';
    }
    public function getDB() :PDO {
        return $this->db;
    }

    public function getName() {
        return $this->name;
    }
    public function setName($name) {
        $this->name = $name;
    }

    public function getAll($order = NULL): array
    {
        if(!is_array($order)) {
            $order = ['id', 'ASC'];
        }
        $sql = 'SELECT * FROM `' . $this->name . '` ORDER BY `' . $order[0] . '` ' . $order[1];
        $requete = $this->getDB()->query($sql);
        return $requete->fetchAll();
    }

    public function get($id): array {
        $sql = 'SELECT * FROM `' . $this->name . '` WHERE `id` = :id';
        $stmt = $this->getDB()->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function getByid($id): array{
        return $this->get($id);
    }
    
    //pas vraiment fait pour une class Table mais bon...
    public function getByClientId($id): array {
        $sql = 'SELECT * FROM `' . $this->name . '` WHERE `client_id` = :id';
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function add(array $keys, array $values): int
    {
        $n = count($keys);
        if(0 === $n || $n !== count($values)) return 0;
        try{
            $i = 0;
            $k = '';
            $v = '';
            for($i = 0;$i < $n; $i++) {
                $k .= '`' . $keys[$i] . '`';
                $v .= "'" . $values[$i] . "'";
                if($i + 1 !== $n) {
                    $k .= ',';
                    $v .= ',';
                }
            }
            $sql = 'INSERT INTO `' . $this->name . '` (' . $k . ') VALUES (' . $v . ')';
            echo $sql;
            $stmt = $this->db->query($sql);
            
            return $stmt->rowCount();
        }
        catch (PDOException $e) {
            var_dump($e);
            return 0;
        }
    }

    public function upd(int $id, array $keys, array $values): int
    {
        $n = count($keys);
        if(0 === $n || $n !== count($values)) return 0;
        try{
            $i = 0;
            $s = '';
            for($i = 0;$i < $n; $i++) {
                $s .= '`' . $keys[$i] . '`="' . $values[$i] . '"';
                if($i + 1 !== $n) {
                    $s .= ',';
                }
            }
            $sql = 'UPDATE `' . $this->name . '` SET ' . $s . ' WHERE id="' . $id . '"';
            $stmt = $this->db->query($sql);
            return $stmt->rowCount();
        }
        catch (PDOException $e) {
            return 0;
        }
    }

    public function del($id): int
    {
        return $this->delByColName('id', $id);
    }

    public function delByColName($col, $value): int
    {
        try {
            $sql = 'DELETE FROM `' . $this->name . '` WHERE `' . $col . '` = :value';
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                    'value' => $value
                ]);
            return $stmt->rowCount();
        }
        catch (PDOException $e) {
            return 0;
        }
    }
}
/*
$o = new Table('service');
var_dump($o->add(array('type_soin', 'type'), array('CONSULT', '123')));
var_dump($o->upd(array('type_soin', 'type'), array('CONSULT', '123')));*/

?>
