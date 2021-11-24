<?php

class Backup
{
    private $_database;
    private $_tableName = "backups";

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
        $sql = "";
        $value = [];
        if (is_array($search) && count($search) > 0) {
            $sql .= "WHERE {$search[0]} {$search[1]} ?";
            $value = [$search[2]];
        } else if (is_int($search) && $search > 0) {
            $sql .= "WHERE id = ?";
            $value = [$search];
        }

        return $this->_database->query(
            "SELECT 
            users.id as users_id, 
            users.name as users_name,
            users.contact as users_contact,
            users.location as users_location,
            users.backup_quota as users_backup_quota,
            users.backup_size as users_backup_size,
            users.date_updated as users_date_updated,
            users.date_created as users_date_created,

            backups.id as id,
            backups.user_id as user_id,
            backups.name as name,
            backups.description as description,
            backups.backup_size as backup_size,
            backups.backup_filename as backup_filename,
            backups.date_created as date_created 

            FROM {$this->_tableName} LEFT JOIN users ON {$this->_tableName}.user_id = users.id " . $sql,
            $value
        );
    }
}
