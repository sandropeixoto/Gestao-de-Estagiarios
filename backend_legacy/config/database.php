<?php
/**
 * Legado Database Bridge to Root Database
 * Orion Orchestrator: Unified persistence layer for MySQL/MariaDB
 */

require_once __DIR__ . '/../../config/database.php';

class Database {
    public $conn;

    /**
     * Get connection using the central Database class
     */
    public function getConnection() {
        try {
            $this->conn = \Database::getConnection();
        } catch (\PDOException $exception) {
            http_response_code(503);
            echo json_encode([
                "message" => "Database connection error (Unified MySQL).",
                "details" => (isset($_GET['debug']) && $_GET['debug'] == '1') ? $exception->getMessage() : "Check environment configuration."
            ]);
            exit();
        }
        return $this->conn;
    }
}
