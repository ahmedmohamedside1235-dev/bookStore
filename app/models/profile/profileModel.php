<?php

require_once __DIR__ . "/../Model.php";
require_once __DIR__ . "/../../../core/Database.php";

class profileModel extends Model
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

    public static function getTotalOfTable(string $tableName, array $wheres = [])
    {
        $DB = Database::getConnection();
        $queryWheres = Model::prepareWhereQuery($wheres);
        $stmt = $DB->query("SELECT COUNT(*) AS total FROM {$tableName} {$queryWheres} ");
        return $stmt->fetch()['total'];
    }

    public static function getTotalBoughtBooks()
    {
        $DB = Database::getConnection();
        $customerId = auth('id');
        $stmt = $DB->query("SELECT SUM(orders_items.quantity) AS total 
                                FROM orders_items
                                LEFT JOIN orders ON orders.id = orders_items.order_id
                                WHERE 
                                orders.customer_id = {$customerId}
                                AND
                                orders.status = 'done';");
        return $stmt->fetchColumn() ?? 0;
    }

    public static function getDataOfTable(string $tableName, array $wheres = [], int $page = 1)
    {
        $DB = Database::getConnection();
        $offset = ($page * 10) - 10;
        $queryWheres = Model::prepareWhereQuery($wheres);
        $data = $DB->query("SELECT *  
                                FROM 
                                    {$tableName} 
                                {$queryWheres}
                                ORDER BY id DESC
                                LIMIT 10 OFFSET $offset
                            ");
        $count = $DB->query("SELECT COUNT(*) AS total  FROM {$tableName} {$queryWheres}");

        return [
            "data" => $data->fetchAll(),
            "count" => ceil(($count->fetch()['total'] / 10)),
            "currentPage" => $page
        ];
    }
}
