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
?>
