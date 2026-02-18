<?php
include_once __DIR__ . '/../config/database.php';
include_once __DIR__ . '/../models/Contract.php';
include_once __DIR__ . '/../models/Evaluation.php';

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
        try {
            error_log("Dashboard: Starting...");

            $expiring = $this->contract->getExpiringContracts();
            error_log("Dashboard: Expiring contracts fetched. Count: " . count($expiring));

            $pending = $this->evaluation->getPendingEvaluations();
            error_log("Dashboard: Pending evaluations fetched. Count: " . count($pending));

            // New Stats for Pro Dashboard
            // 1. Total Students
            $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM students");
            $stmt->execute();
            $totalStudents = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
            error_log("Dashboard: Total students: " . $totalStudents);

            // 2. Active Contracts
            $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM contracts WHERE status = 'Ativo'");
            $stmt->execute();
            $activeContracts = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
            error_log("Dashboard: Active contracts: " . $activeContracts);

            // 3. Contracts per Month
            $stmt = $this->db->prepare("
                SELECT to_char(created_at, 'Mon') as name, COUNT(*) as contratos 
                FROM contracts 
                WHERE created_at > NOW() - INTERVAL '6 months' 
                GROUP BY to_char(created_at, 'Mon'), date_trunc('month', created_at)
                ORDER BY date_trunc('month', created_at)
            ");
            $stmt->execute();
            $contractsChart = $stmt->fetchAll(PDO::FETCH_ASSOC);
            error_log("Dashboard: Contracts chart data fetched.");

            // 4. Students per Course
            $stmt = $this->db->prepare("SELECT curso as name, COUNT(*) as value FROM students GROUP BY curso");
            $stmt->execute();
            $coursesChart = $stmt->fetchAll(PDO::FETCH_ASSOC);
            error_log("Dashboard: Courses chart data fetched.");

            $response = array(
                "expiringContracts" => $expiring,
                "evaluationsPending" => $pending,
                "kpi" => [
                    "totalStudents" => $totalStudents,
  