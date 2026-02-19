<?php
// Use __DIR__ para garantir que o PHP encontre o arquivo independente de onde for chamado
include_once __DIR__ . '/../config/database.php';

class StatusController
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function check()
    {
        if ($this->db) {
            echo json_encode([
                "status" => "online",
                "message" => "Connected to Supabase via PostgreSQL",
                "database_type" => "pgsql"
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
?>