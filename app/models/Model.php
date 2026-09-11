<?php

require_once __DIR__ . "/../../core/Database.php";

class Model
{
    protected PDO $DB;
    public function __construct()
    {
        $this->DB = Database::getConnection();
    }

    public static function prepareWhereQuery(array $wheres): string
    {
        $queryWheres = "";
        if (!empty($wheres)) {
            $queryWheres = "WHERE ";
            $counter = 1;
            foreach ($wheres as $where) {

                if ($counter > 1) {
                    if (isset($where[3]))
                        $queryWheres .= "$where[3] ";
                    else
                        $queryWheres .= "AND ";
                }

                $queryWheres .= "{$where[0]} {$where[1]} '{$where[2]}' ";
                $counter++;
            }
        }
        return $queryWheres;
    }
}
