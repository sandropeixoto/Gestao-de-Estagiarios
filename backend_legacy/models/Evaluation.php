<?php
class Evaluation
{
    private $conn;
    private $table_name = "evaluations";

    public $id;
    public $contract_id;
    public $status; // Virtual field for logic

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Get pending evaluations (logic: active contracts without evaluation in last 6 months)
    public function getPendingEvaluations()
    {
        // Complex query: Select contracts where no evaluation exists in the last 6 months
        // For MVP: Select contracts where id NOT IN (select contract_id from evaluations)
        $query = "SELECT c.id, s.nome as student_name 
                  FROM contracts c 
                  JOIN students s ON c.student_id = s.id
                  WHERE c.status = 'Ativo' 
                  AND c.id NOT IN (SELECT contract_id FROM evaluations)";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>