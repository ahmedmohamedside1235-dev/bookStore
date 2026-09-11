<?php

require_once __DIR__ . "/../core/Database.php";
class create_authors_tables
{
    public static function up()
    {
        Database::getConnection()->exec("CREATE TABLE IF NOT EXISTS authors(
                    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    name VARCHAR(255) NOT NULL,
                    bio TEXT NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    update_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                    );");
    }
    public static function dawn()
    {
        Database::getConnection()->exec("DROP TABLE IF EXISTS authors");
    }
}
