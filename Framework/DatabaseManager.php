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
            echo "Resetting auto increment for table $table. \n";
            $this->db->exec("ALTER TABLE $table AUTO_INCREMENT = 1");
        }
    }

    public function dropAllTables()
    {
        foreach ($this->tables as $table) {
            echo "Dropping table $table. \n";
            $this->db->exec("DROP TABLE $table");
        }
    }
}
