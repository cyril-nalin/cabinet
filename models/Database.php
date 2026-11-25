<?php

class Database
{
    private static ?PDO $connexion = null;
    public static $TYPE_SOINS = ['CONSULT', 'DETARTRAGE', 'CARIE', 'DEVITALISATION', 'PROTHESE', 'URGENCE', 'AUTRE'];

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
    private array $fields;
//CONSTRUCTION OBJET
    public function __construct()
    {
        $this->db = Database::getConnexion();
        $this->name = '';
        $this->fields = [];
    }
//OPERATIONS DIRECTES
    private function Query(string $sql):PDOStatement|false {
        return $this->getDB()->query($sql);
    }

    private function Prepare(string $sql):PDOStatement|FALSE {
        return $this->getDB()->prepare($sql);
    }

    private function Execute(string $sql, array $key_vals, bool $get_all = FALSE) {
        try{
            $stmt = $this->Prepare($sql);
            $stmt->execute($key_vals);
            return $get_all ?
                [$stmt->fetchAll(), $stmt->rowCount(), (int) $stmt->fetchColumn()] :
                [$stmt->fetch(), $stmt->rowCount(), (int) $stmt->fetchColumn()];
        }
        catch (PDOException $e) {
            return array(NULL, NULL, NULL);
        }
    }
//OPERATIONS SENSIBLE
    function Delete() {
        $this->Query('DELETE FROM `' . $this->name . '` WHERE 1');
    }
    function Truncate() {
        $this->Query('TRUNCATE TABLE `' . $this->name . '`');
    }
    function Drop() {
        $this->Query('DROP TABLE `' . $this->name . '`');
    }

//GET/SET OBJET
    public function getDB() :PDO {
        return $this->db;
    }

    public function getName() {
        return $this->name;
    }
    public function setName($name) {
        $this->name = $name;
    }

    public function getFields():array {
        return $this->fields;
    }
    public function setFields(array $fields) {
        $this->fields = $fields;
    }

/* Fonctions sur la Base de données */
//GET - Obtenir des données
    public function getAll($order = NULL):array
    {
        if(!is_array($order)) {
            $order = ['id', 'ASC'];
        }
        $requete = $this->Query('SELECT * FROM `' . $this->name . '` ORDER BY `' . $order[0] . '` ' . $order[1]);
        return $requete->fetchAll();
    }

    public function getLimited(int $cnt, int $start = 0, $order = NULL, $get_all = TRUE):array
    {
        if(!is_array($order)) {
            $order = ['id', 'ASC'];
        }
        $q = $this->Query('SELECT * FROM `' . $this->name . '` ORDER BY `' . $order[0] . '` ' . $order[1] . ' LIMIT ' . $start . ',' . $cnt);
        return $get_all ? $q->fetchAll() : $q->fetch();
    }

    public function getFirst():array
    {
        $q = $this->Query('SELECT * FROM `' . $this->name . '` LIMIT 1');
        return $q->fetch();
    }

    public function getByColName(string $col, mixed $value): ?array {
        try{
            if(!is_string($value)) $value = (string)$value;
            return $this->Execute(
                $sql = 'SELECT * FROM `' . $this->name . '` WHERE `' . $col . '` = :value',
                ['value' => $value]
            )[0];
        }
        catch (PDOException $e) {
            return NULL;
        }
    }
    public function get(mixed $id): ?array {
        return $this->getByColName('id', $id);
    }

    public function getByid(mixed $id): array{
         return $this->get($id);
    }

    public function getByClientId(mixed $id): array {
        return $this->getByColName('client_id', $id);
    }
//ADD - Ajoute des données
    public function add_fast(array $keys, array $values): int
    {
        $n = count($keys);
        if(0 === $n || $n !== count($values)) return 0;
        try{
            $i = 0;
            $k = '';
            $v = '';
            for($i = 0;$i < $n; $i++) {
                $k .= '`' . $keys[$i] . '`';
                $v .= "'" . str_replace("'", "\\'", $values[$i]) . "'";
                if($i + 1 !== $n) {
                    $k .= ',';
                    $v .= ',';
                }
            }
            $stmt = $this->Query('INSERT INTO `' . $this->name . '` (' . $k . ') VALUES (' . $v . ')');
            return $stmt->rowCount();
        }
        catch (PDOException $e) {
            return 0;
        }
    }

    public function add(array $keys, array $values): int
    {
        $n = count($keys);
        if(0 === $n || $n !== count($values)) return 0;
        try{
            $params = array();
            $i = 0;
            $k = '';
            $v = '';
            for($i = 0;$i < $n; $i++) {
                $k .= '`' . $keys[$i] . '`';
                $v .= ":" . $keys[$i] . "";
                if($i + 1 !== $n) {
                    $k .= ',';
                    $v .= ',';
                }
                $params[$keys[$i]] = $values[$i];
            }
            $sql = 'INSERT INTO `' . $this->name . '` (' . $k . ') VALUES (' . $v . ')';
            $stmt = $this->GetDB()->prepare($sql);
            $stmt->execute($params);
            return (1 === $stmt->rowCount()) ? 1 : 0;
        }
        catch (PDOException $e) {
            return 0;
        }
    }

    public function Push(array $data): int {
        return $this->add($this->getFields(), $data);
    }
    public function PushFast(array $data): int {
        return $this->add_fast($this->getFields(), $data);
    }
//UPD - Mise à jour des données
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
            $stmt = $this->Query($sql);
            return $stmt->rowCount();
        }
        catch (PDOException $e) {
            return 0;
        }
    }

    public function Update(int $id, array $values): int
    {
        return $this->upd($id, $this->getFields(), $values);
    }

//DEL - Suppréssion des données
    public function del(mixed $id): int {
        return $this->delByColName('id', $id);
    }

    public function delByColName(string $col, mixed $value): int
    {
        try {
            return $this->Execute('DELETE FROM `' . $this->name . '` WHERE `' . $col . '` = :value', ['value' => (string)$value])[1];
        }
        catch (PDOException $e) {
            return 0;
        }
    }

//COUNT - Compter des données
    public function Count(string $col, string|int $value): int
    {
        try {
            $sql = 'SELECT COUNT(*) FROM `' . $this->name . '` WHERE `' . $col . '` = :value';
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['value' => $value]);
            return (int) $stmt->fetchColumn();
        }
        catch (PDOException $e) {
            //throw new PDOException($e->getMessage(), (int)$e->getCode());
            return 0;
        }
    }   
    
    public function CountFromArray(array $keys, array $values): int
    {
        $n = count($keys);
        if(0 === $n || $n !== count($values)) return 0;
        try{
            $params = array();
            $i = 0;
            $k = '';
            for($i = 0;$i < $n; $i++) {
                $k .= '`' . $keys[$i] . '`';
                $k .= "='" . $keys[$i] . "'";
                if($i + 1 !== $n) {
                    $k .= ',';
                }
                $params[$keys[$i]] = $values[$i];
            }
            $sql = 'SELECT COUNT * FROM `' . $this->name . '` WHERE ' . $k;
            return $this->Query($sql);
        }
        catch (PDOException $e) {
            return 0;
        }
    }
}

?>
