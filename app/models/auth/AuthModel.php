<?php

require_once __DIR__ . "/../Model.php";
require_once __DIR__ . "/../../../core/Database.php";

class AuthModel extends Model
{
    public static function login()
    {
        $DB = Database::getConnection();
        $email = Request::input('email');
        $password = Request::input('password');
        $stmt = $DB->query("SELECT * FROM users WHERE email = '{$email}';");
        $user = $stmt->fetch();
        if (!empty($user) && password_verify($password, $user['password'])) {
            return $user;
        }

        return false;
    }
}
