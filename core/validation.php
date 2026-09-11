<?php

require_once __DIR__ . "/../core/Database.php";

class validation
{

    private array $errors = [];

    public function __construct(
        private array $data,
        private array $rules
    ) {}

    public function validate(): array
    {
        foreach ($this->rules as $field => $rules) {
            $value = $this->data[$field] ?? null;

            foreach ($rules as $rule) {
                if (is_string($rule)) {
                    if ($rule === "required") {
                        $this->validateRequired($field, $value);
                    } elseif ($rule === "email") {
                        $this->validateEmail($field, $value);
                    } elseif ($rule === "EGPhone") {
                        $this->validatePhone($field, $value);
                    } elseif ($rule === "integer") {
                        $this->validateInteger($field, $value);
                    }
                } else if (is_array($rule)) {
                    if ($rule[0] === "min") {
                        $this->validateMin($field, $value);
                    } else if ($rule[0] === "unique") {
                        $this->validateUnique($field, $value, $rule[1], $rule[2]);
                    } else if ($rule[0] === "exists") {
                        $this->validateExists($field, $value, $rule[1], $rule[2]);
                    }
                }
            }
        }
        return $this->errors;
    }

    private function validateRequired(string $field, mixed $value): void
    {
        if (trim((string)$value) === "" || $value === null) {
            $this->addError($field, "The {$field} is required");
        }
    }

    private function addError(string $field, mixed $msg): void
    {
        $this->errors[$field][] = $msg;
    }

    private function validateEmail(string $field, mixed $value): void
    {
        if (empty($value)) return;
        $regex = "/^[A-Za-z_][A-Za-z_0-9\.\-]+@(gmail|yahoo)\.(com|org)$/";
        if (!preg_match($regex, $value)) {
            $this->addError($field, "invalid {$field} (example@gmail.com)");
        }
    }

    private function validateMin(string $field, mixed $value, int $min = 8): void
    {
        if (empty($value)) return;

        if (strlen($value) < $min) {
            $this->addError($field, "{$field} must be at least {$min} characters or numbers");
        }
    }

    private function validateUnique(string $field, string $value, string $tableName, ?int $exceptId = null): void
    {
        if (empty($value)) return;

        $DB = Database::getConnection();
        $stmt = $DB->query("SELECT * 
                            FROM  {$tableName} 
                            WHERE {$field} = '{$value}' AND id != '{$exceptId}';");
        $result = $stmt->fetchAll();
        if (!empty($result)) {
            $this->addError($field, "{$field} is already exists");
        }
    }
    private function validateExists(string $field, string $value, string $tableName, string $columnName): void
    {
        if (empty($value)) return;

        $DB = Database::getConnection();
        $stmt = $DB->query("SELECT * FROM  {$tableName} WHERE {$columnName} = '{$value}';");
        $result = $stmt->fetchAll();
        if (empty($result)) {
            $this->addError($field, "{$field} is not exists");
        }
    }

    private function validatePhone(string $field, string $value)
    {
        if (empty($value)) {
            return;
        }

        $regex = "/^(02)?01(2|1|5|0)[0-9]{8}$/";

        if (!preg_match($regex, $value)) {
            $this->addError($field, "Please enter {$field} valid EGPhone");
        }
    }

    private function validateInteger(string $field, mixed $value)
    {
        if ($value === null || $value === '') {
            return;
        }

        if (filter_var($value, FILTER_VALIDATE_INT) === false || (int)$value < 1) {
            $this->addError($field, "Please enter quantity number greater than 0");
        }
    }
}
