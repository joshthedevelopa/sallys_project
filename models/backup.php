<?php

class Backup
{
    private Database $_database;
    private $_tableName = "backup";

    public function __construct()
    {
        $this->_database = Database::instance();
    }

    public function create(
        array $data
    ) {
        return $this->_database->insert(
            $this->_tableName,
            $data
        );
    }

    public function update(
        array $data
    ): bool {
        return $this->_database->update(
            $this->_tableName,
            $data
        );
    }

    public function delete(
        array $targets,
        array $conjuctions = ["AND"]
    ): bool {
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
