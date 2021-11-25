<?php

class Database
{
    private static $_instance;
    private $_id;
    private $_pdo;
    private $_query;
    private $_error;
    private $_count;
    private $_results;

    protected static $operators = [">", "<", "=", "<=", ">="];
    protected static $conjuctions = ["AND", "OR"];

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

    public static function instance()
    {
        if (!isset(Self::$_instance)) {
            Self::$_instance = new Database();
        }

        return Self::$_instance;
    }

    public function query(
        $sql,
        $params = []
    ) {
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
        $action,
        $table,
        $where = [],
        $conjuction = ["AND"]
    ) {
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
        $table,
        $search = 0,
        $conjuction = ["AND"]
    ) {
        if (is_int($search)) {
            return $this->action("SELECT *", $table, ["id", $search == 0 ? ">" : "=", $search], $conjuction);
        }

        return $this->action("SELECT *", $table, $search, $conjuction);
    }

    public function delete(
        $table,
        $targets = [],
        $conjuction = ["AND"]
    ) {
        if (is_int($targets)) {
            return $this->action("DELETE", $table, ["id", "=", $targets]);
        }

        return $this->action("DELETE", $table, $targets, $conjuction);
    }

    public function insert(
        $table,
        $data
    ) {
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
        $table,
        $data,
        $id
    ) {
        $values = [];
        $sub_sql = "";

        foreach ($data as $col => $value) {
            if ($sub_sql != "") {
                $sub_sql .= ", ";
            }

            $sub_sql .= "$col = ?";
            array_push($values, $value);
        }

        array_push($values, $id);
        return $this->query("UPDATE $table SET " . $sub_sql . "WHERE id = ?", $values);
    }

    public function results(
        $only_first = false,
        $array = false
    ) {
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

    public function id()
    {
        return $this->_id ?? 0;
    }

    public function error()
    {
        return $this->_error;
    }

    public function count()
    {
        return $this->_count;
    }
}
