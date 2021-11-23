<?php

class User
{
    private Database $_database;
    private $_tableName = "users";

    public function __construct()
    {
        $this->_database = Database::instance();
    }

    public function create(
        array $data
    ): Database {
        return $this->_database->insert(
            $this->_tableName,
            $data
        );
    }

    public function update(
        array $data,
        int $id
    ): Database {
        return $this->_database->update(
            $this->_tableName,
            $data,
            $id
        );
    }

    public function delete(
        array|int $targets,
        array $conjuctions = ["AND"]
    ): Database {
        return $this->_database->delete(
            $this->_tableName,
            $targets,
            $conjuctions
        );
    }

    public function get(
        array|int $search,
        array $conjuctions = ["AND"]
    ): Database {
        return $this->_database->get(
            $this->_tableName,
            $search,
            $conjuctions
        );
    }
}
