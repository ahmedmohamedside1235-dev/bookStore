<?php

require_once __DIR__ . "/../Model.php";
require_once __DIR__ . "/../../../core/Database.php";

class AuthorModel extends Model
{
    public static function  createAuthor()
    {
        $DB = Database::getConnection();
        $stmt = $DB->prepare("INSERT INTO authors 
                    (name,bio) 
                    VALUES 
                    (:name , :bio)");
        $stmt->execute([
            'name' => Request::input('name'),
            'bio' => Request::input('bio')
        ]);

        $lastId = $DB->lastInsertId();

        $author = $DB->query("SELECT * FROM authors WHERE id = '{$lastId}';");
        return $author->fetch();
    }
}
