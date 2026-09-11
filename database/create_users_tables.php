<?php

require_once __DIR__ . "/../core/Database.php";
class create_users_tables
{
    public static function up()
    {
        Database::getConnection()->exec("CREATE TABLE IF NOT EXISTS users(
                    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    name VARCHAR(255) NOT NULL,
                    email VARCHAR(255) NOT NULL UNIQUE,
                    password VARCHAR(255) NOT NULL,
                    phone VARCHAR(255) NOT NULL UNIQUE,
                    is_banned BOOLEAN DEFAULT false,
                    gender ENUM('male', 'female') NOT NULL,
                    role ENUM('admin', 'customer') NOT NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    update_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                    );");
    }
    public static function dawn()
    {
        Database::getConnection()->exec("DROP TABLE IF EXISTS users");
    }
}
