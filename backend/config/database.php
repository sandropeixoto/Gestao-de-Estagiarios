<?php
class Database
{
    // Supabase Credentials
    private $host = "db.vpwjcgxtgpzicvgmatll.supabase.co";
    private $db_name = "postgres"; // Standard Supabase DB name
    private $username = "postgres";
    private $password = "FLpEMiCSTw88gRD2"; // User needs to update this
    private $port = "5432";
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
            if ($this->debug) {
                echo "Connection error: " . $exception->getMessage();
            }
            else {
                echo "Connection error.";
            }
        }
        return $this->conn;
    }
}
?>