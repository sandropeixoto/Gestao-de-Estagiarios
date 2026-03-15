<?php
/**
 * Dashboard Controller - Unified Pattern
 * Orion Orchestrator: Transitioning legacy to App\Models and MySQL
 */

require_once __DIR__ . '/../../src/Models/Contract.php';
require_once __DIR__ . '/../../src/Models/Evaluation.php';

use App\Models\Contract;
use App\Models\Evaluation;

class DashboardController
{
    private $db;
    private $contractModel;
    private $evaluationModel;

    public function __construct()
    {
        $this->db = \Database::getConnection();
        $this->contractModel = new Contract();
        $this->evaluationModel = new Evaluation();
    }

    public function getManagerStats()
    {
        try {
            $expiring = $this->contractModel->getExpiringContracts();
            $pending = $this->evaluationModel->getPendingEvaluations();

            // 1. Total Students
            $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM students");
            $stmt->execute();
            $totalStudents = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

            // 2. Active Contracts
            $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM contracts WHERE status = 'Ativo'");
            $stmt->execute();
            $activeContracts = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

            // 3. Contracts per Month (MySQL Optimized)
            $stmt = $this->db->prepare("
                SELECT DATE_FORMAT(created_at, '%b') as name, COUNT(*) as contratos 
                FROM contracts 
                WHERE created_at > DATE_SUB(NOW(), INTERVAL 6 MONTH) 
                GROUP BY name, LAST_DAY(created_at)
                ORDER BY LAST_DAY(created_at)
            ");
            $stmt->execute();
            $contractsChart = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // 4. Students per Course
            $stmt = $this->db->prepare("SELECT curso as name, COUNT(*) as value FROM students GROUP BY curso");
            $stmt->execute();
            $coursesChart = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $response = [
                "expiringContracts" => $expiring ?? [],
                "evaluationsPending" => $pending ?? [],
                "kpi" => [
                    "totalStudents" => $totalStudents ?? 0,
                    "activeContracts" => $activeContracts ?? 0,
                    "contractsChart" => $contractsChart ?? [],
                    "coursesChart" => $coursesChart ?? []
                ]
            ];

            echo json_encode($response);
        }
        catch (Exception $e) {
            http_response_code(500);
            echo json_encode(["message" => "Error generating dashboard.", "error" => $e->getMessage()]);
        }
    }
}
