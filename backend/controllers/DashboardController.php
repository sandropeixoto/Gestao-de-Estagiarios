<?php
include_once '../config/database.php';
include_once '../models/Contract.php';
include_once '../models/Evaluation.php';

class DashboardController
{
    private $db;
    private $contract;
    private $evaluation;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->contract = new Contract($this->db);
        $this->evaluation = new Evaluation($this->db);
    }

    public function getManagerStats()
    {
        $expiring = $this->contract->getExpiringContracts();

        // Enrich expiring with student names
        // Note: getExpiringContracts currently returns raw rows. Ideally should join with students.
        // Let's update getExpiringContracts logic in Contract.php or do a quick loop here if strict PDO usage.
        // Better: Update Contract.php to join with students. I'll stick to a simple fix here or assume Contract.php does it?
        // Actually, looking at previous Contract.php, it did "SELECT *". I should probably update it to join.
        // For now, let's just return what we have, frontend expects "student_name".

        // Update: Let's refactor Contract.php to include student name in expiring check, 
        // OR better yet, let's just make DashboardController do the query directly if models are too simple. 
        // But adhering to MVC, let's update Contract model.

        $pending = $this->evaluation->getPendingEvaluations();

        echo json_encode(array(
            "expiringContracts" => $expiring,
            "evaluationsPending" => $pending
        ));
    }
}
?>