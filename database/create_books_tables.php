<?php

require_once __DIR__ . "/../core/Database.php";
class create_books_tables
{
    public static function up()
    {
        Database::getConnection()->exec("CREATE TABLE IF NOT EXISTS books(
                    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    author_id BIGINT UNSIGNED NOT NULL,
                    CONSTRAINT fk_author_id FOREIGN KEY (author_id) REFERENCES authors(id),
                    title VARCHAR(255) NOT NULL,
                    image VARCHAR(255) NULL,
                    description TEXT,
                    price DECIMAL(10,2),
                    stock INT UNSIGNED DEFAULT 0,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    update_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                    );");
    }
    public static function dawn()
    {
        Database::getConnection()->exec("DROP TABLE IF EXISTS books");
    }
}
