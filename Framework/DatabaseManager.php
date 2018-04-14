<?php

namespace Framework;

class DatabaseManager
{
    private $db;

    private $tables;

    public function __construct($db, array $tables)
    {
        $this->db = $db;
        $this->tables = $tables;
    }

    public function resetAllIncrements()
    {
        foreach ($this->tables as $table) {
            $this->db->exec("ALTER TABLE $table AUTO_INCREMENT = 1");
        }
    }

    public function dropAllTables()
    {
        foreach ($this->tables as $table) {
            $this->db->exec("DROP TABLE $table");
        }
    }
}
