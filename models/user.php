<?php

class User
{
    private $_database;
    private $_tableName = "users";

    public function __construct()
    {
        $this->_database = Database::instance();
    }

    public function create(
        $data
    ) {
        return $this->_database->insert(
            $this->_tableName,
            $data
        );
    }

    public function update(
        $data,
        $id
    ) {
        return $this->_database->update(
            $this->_tableName,
            $data,
            $id
        );
    }

    public function delete(
        $targets,
        $conjuctions = ["AND"]
    ) {
        return $this->_database->delete(
            $this->_tableName,
            $targets,
            $conjuctions
        );
    }

    public function get(
        $search,
        $conjuctions = ["AND"]
    ) {
        return $this->_database->get(
            $this->_tableName,
            $search,
            $conjuctions
        );
    }
}
