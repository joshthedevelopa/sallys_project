<?php

class User
{
    private Database $_database;

    public function __construct()
    {
        $this->_database = Database::instance();
    }

    public function create(array $data): Database
    {
        return $this->_database->insert("users", $data);
    }

    public function update(array $data, int $id): Database
    {
        return $this->_database->update("users", $data, $id);
    }

    public function delete(array $targets, array $conjuctions = ["AND"]): Database
    {
        return $this->_database->delete("users", $targets, $conjuctions);
    }

    public function get(array|int $search, array $conjuctions = ["AND"]): Database
    {
        return $this->_database->get("users", $search, $conjuctions);
    }
}
