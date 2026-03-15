<?php
/**
 * Status Controller - Unified Pattern
 * Orion Orchestrator: Reflecting unified MySQL connection
 */

require_once __DIR__ . '/../../config/database.php';

class StatusController
{
    private $db;

    public function __construct()
    {
        $this->db = \Database::getConnection();
    }

    public function check()
    {
        if ($this->db) {
            echo json_encode([
                "status" => "online",
                "message" => "Connected to Unified MySQL Database",
                "database_type" => "mysql"
            ]);
        }
        else {
            http_response_code(500);
            echo json_encode([
                "status" => "offline",
                "message" => "Failed to connect to database"
            ]);
        }
    }
}
