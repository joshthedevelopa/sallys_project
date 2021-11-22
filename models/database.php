<?php

class Database
{
    private static Database $_instance;
    private string $_id;
    private PDO $_pdo;
    private $_query;
    private bool $_error;
    private int $_count;
    private array $_results;

    protected static array $operators = [">", "<", "=", "<=", ">="];
    protected static array $conjuctions = ["AND", "OR"];

    private function __construct()
    {
        try {
            $this->_pdo = new PDO(
                "mysql:
                host=" . Config::get("mysql/host") . ";
                dbname=" . Config::get("mysql/database"),
                Config::get("mysql/username"),
                Config::get("mysql/password")
            );
        } catch (PDOException $error) {
            die($error->getMessage());
        }
    }

    public static function instance(): Database
    {
        if (!isset(Self::$_instance)) {
            Self::$_instance = new Database();
        }

        return Self::$_instance;
    }

    public function query(
        string $sql,
        array $params = []
    ): Database {
        $this->_error = false;
        if ($this->_query = $this->_pdo->prepare($sql)) {

            if (count($params)) {
                foreach ($params as $key => $value) {
                    $this->_query->bindValue(++$key, $value);
                }
            }

            if ($this->_query->execute()) {
                $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
                $this->_count = $this->_query->rowCount();
            } else {
                $this->_error = true;
            }
        } else {
            $this->_error = true;
        }

        return $this;
    }

    public function action(
        string $action,
        string $table,
        array $where = [],
        array $conjuction = ["AND"]
    ): Database {
        $values = [];
        $sub_sql = "";

        if (is_array($where)) {
            
            $_count = count($where);
            
            if ($_count <= 0) {
                $this->_error = true;
                return $this;
            }

            $keys = array_keys($where);
            if (!is_array($where[$keys[0]])) {
                $where = [$where];
            }
            foreach ($where as $_key => $_details) {
                $field = $_details[0];
                $operator = $_details[1];
                $value = $_details[2];
                $conj = $conjuction[$_key] ??  $conjuction[0];

                if (!in_array($operator, self::$operators) || !in_array($conj, self::$conjuctions)) {
                    $this->_error = true;
                    return $this;
                }

                if ($sub_sql != "") {
                    $sub_sql .= " $conj ";
                }

                $sub_sql = "$field $operator ?";
                array_push($values, $value);
            }
        } else {

            $this->_error = true;
            return $this;
        }

        $sql = "{$action} FROM {$table} WHERE " .  $sub_sql;

        return $this->query($sql, $values);
    }

    public function get(
        string $table,
        array|int $search = 0,
        array $conjuction = ["AND"]
    ): Database {
        if (is_int($search)) {
            return $this->action("SELECT *", $table, ["id", $search == 0 ? ">" : "=", $search], $conjuction);
        }

        return $this->action("SELECT *", $table, $search, $conjuction);
    }

    public function delete(
        string $table,
        array|int $targets = [],
        array $conjuction = ["AND"]
    ): Database {
        if (is_int($targets)) {
            return $this->action("DELET", $table, ["id", "=", $targets]);
        }

        return $this->action("DELET", $table, $targets, $conjuction);
    }

    public function insert(
        String $table,
        array $data
    ): Database {
        $values = [];
        $col_names = "";
        $col_values = "";

        foreach ($data as $col => $value) {
            if ($col_values != "") {
                $col_values .= ", ";
                $col_names .= ", ";
            }

            $col_values .= "?";
            $col_names .= "$col";
            array_push($values, $value);
        }

        $this->query("INSERT INTO $table ($col_names) VALUES ($col_values)", $values);
        if (!$this->_error) {
            $this->_id = $this->_pdo->lastInsertId();
        }

        return $this;
    }

    public function update(
        String $table,
        array $data,
        int $id
    ): Database {
        $values = [$id];
        $sub_sql = "";;

        foreach ($data as $col => $value) {
            if ($sub_sql != "") {
                $sub_sql .= ", ";
            }

            $sub_sql .= "$col = ?";
            array_push($values, $value);
        }
        return $this->query("UPDATE $table SET " . $sub_sql, $values);
    }

    public function results(
        bool $only_first = false,
        bool $array = false
    ): array|object {
        if ($only_first) {
            $_key = array_key_first($this->_results);
            if (!is_null($_key)) {
                return $array ? (array) $this->_results[$_key] : $this->_results[$_key];
            }
        }

        $_data = [];
        foreach ($this->_results as $key => $value) {
            array_push($_data, (array) $value);
        }

        return $array ? $_data : $this->_results;
    }

    public function id(): int
    {
        return $this->_id;
    }

    public function error(): bool
    {
        return $this->_error;
    }

    public function count(): int
    {
        return $this->_count;
    }
}
