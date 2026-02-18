<?php
class Contract
{
    private $conn;
    private $table_name = "contracts";

    public $id;
    public $student_id;
    public $institution_id;
    public $supervisor_id;
    public $data_inicio;
    public $data_fim;
    public $valor_bolsa;
    public $valor_transporte;
    public $apolice_seguro;
    public $status;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create()
    {
        // Validation: Max 2 years
        $start = new DateTime($this->data_inicio);
        $end = new DateTime($this->data_fim);
        $diff = $start->diff($end);

        if ($diff->y > 2 || ($diff->y == 2 && $diff->m > 0) || ($diff->y == 2 && $diff->d > 0)) {
            // Contract longer than 2 years
            return false;
        }

        $query = "INSERT INTO " . $this->table_name . "
                    (student_id, institution_id, supervisor_id, data_inicio, data_fim, valor_bolsa, valor_transporte, apolice_seguro, status)
                    VALUES
                    (:student_id, :institution_id, :supervisor_id, :data_inicio, :data_fim, :valor_bolsa, :valor_transporte, :apolice_seguro, 'Ativo')";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":student_id", $this->student_id);
        $stmt->bindParam(":institution_id", $this->institution_id);
        $stmt->bindParam(":supervisor_id", $this->supervisor_id);
        $stmt->bindParam(":data_inicio", $this->data_inicio);
        $stmt->bindParam(":data_fim", $this->data_fim);
        $stmt->bindParam(":valor_bolsa", $this->valor_bolsa);
        $stmt->bindParam(":valor_transporte", $this->valor_transporte);
        $stmt->bindParam(":apolice_seguro", $this->apolice_seguro);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Check for expiring contracts (30 days)
    public function getExpiringContracts()
    {
        $query = "SELECT c.*, s.nome as student_name 
                  FROM " . $this->table_name . " c
                  JOIN students s ON c.student_id = s.id
                  WHERE DATEDIFF(c.data_fim, CURDATE()) <= 30 AND c.status = 'Ativo'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAll()
    {
        $query = "SELECT c.*, s.nome as student_name, i.razao_social as institution_name, sup.nome as supervisor_name
                  FROM " . $this->table_name . " c
                  JOIN students s ON c.student_id = s.id
                  JOIN institutions i ON c.institution_id = i.id
                  JOIN supervisors sup ON c.supervisor_id = sup.id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>