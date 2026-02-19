<?php
class Supervisor
{
    private $conn;
    private $table_name = "supervisors";

    public $id;
    public $nome;
    public $cargo;
    public $area;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create()
    {
        $query = "INSERT INTO " . $this->table_name . " (nome, cargo, area) VALUES (:nome, :cargo, :area)";
        $stmt = $this->conn->prepare($query);

        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->cargo = htmlspecialchars(strip_tags($this->cargo));
        $this->area = htmlspecialchars(strip_tags($this->area));

        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":cargo", $this->cargo);
        $stmt->bindParam(":area", $this->area);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getActiveInternsCount($supervisor_id)
    {
        $query = "SELECT COUNT(*) as total FROM contracts WHERE supervisor_id = :supervisor_id AND status = 'Ativo'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":supervisor_id", $supervisor_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }

    public function getAll()
    {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>