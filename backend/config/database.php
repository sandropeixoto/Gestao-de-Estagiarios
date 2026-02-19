<?php
class Database
{
    // Supabase Credentials
    // Supabase Credentials (via Env Vars)
    private $host;
    private $db_name;
    private $username;
    private $password;
    private $port;

    public function __construct()
    {
        $this->host = getenv('DB_HOST') ?: "db.vpwjcgxtgpzicvgmatll.supabase.co";
        $this->db_name = getenv('DB_NAME') ?: "postgres";
        $this->username = getenv('DB_USER') ?: "postgres";
        $this->password = getenv('DB_PASS') ?: "FLpEMiCSTw88gRD2";
        $this->port = getenv('DB_PORT') ?: "5432";
    }
    public $conn;
    public $debug = true;

    public function getConnection()
    {
        $this->conn = null;
        try {
            $dsn = "pgsql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name;
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $exception) {
            // Log error internally if needed, but return clean JSON response
            http_response_code(503); // Service Unavailable
            echo json_encode([
                "message" => "Database connection error.",
                "details" => $this->debug ? $exception->getMessage() : "Check server logs."
            ]);
            exit(); // Stop execution
        }
        return $this->conn;
    }
}
?>