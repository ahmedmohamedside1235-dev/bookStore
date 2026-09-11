<?php

require_once __DIR__ . "/../Model.php";
require_once __DIR__ . "/../../../core/Database.php";

class UserModel extends Model
{

    public static function createUser()
    {
        $data = Request::all();
        $hashPassword = password_hash($data['password'], PASSWORD_DEFAULT);
        $DB = Database::getConnection()->exec("INSERT INTO users
                        (role,name,email,password,phone,gender)
                        VALUES
                        ('{$data['role']}', '{$data['name']}', '{$data['email']}', '{$hashPassword}', '{$data['phone']}', '{$data['gender']}')
        ;");
    }

    public static function editUser(string $columnName, string $value)
    {
        $authId = auth('id');

        if ($columnName == "password") {
            $value = password_hash($value, PASSWORD_DEFAULT);
        }
        $DB = Database::getConnection()->exec("UPDATE users SET {$columnName} = '{$value}' WHERE id = '{$authId}';");
    }

    public static function toggleBanUser()
    {
        $DB = Database::getConnection();
        $userId = Request::input('user_id');
        $isBanned = $DB->query("SELECT is_banned FROM users WHERE id = '{$userId}';")->fetchColumn();
        $stmt = $DB->prepare("UPDATE users SET is_banned = :newBan WHERE id = :id ; ");
        $stmt->execute([
            'newBan' => !$isBanned,
            'id' => $userId
        ]);

        return !$isBanned;
    }

    public static function getRoleOfUser(string $id): string
    {
        $DB = Database::getConnection();
        $role = $DB->query("SELECT role FROM users WHERE id = {$id};");
        return $role->fetchColumn();
    }
}
