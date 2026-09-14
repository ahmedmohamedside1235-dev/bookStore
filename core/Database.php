<?php

class Database
{
    private const DSN = "mysql:host=fdb1028.awardspace.net;dbname=4788996_bookstore";
    private const USERNANE = "4788996_bookstore";
    private const PASSWORD = "Ahmed@25";
    private static ?PDO $connection = null;


    public static function getConnection(): PDO
    {
        if (self::$connection === null) {
            try {
                self::$connection = new PDO(self::DSN, self::USERNANE, self::PASSWORD);
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                die("Database Connection Failed : {$e->getMessage()}");
            }
        }
        return self::$connection;
    }
}
