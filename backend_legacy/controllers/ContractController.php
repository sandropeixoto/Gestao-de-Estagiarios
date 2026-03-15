<?php
/**
 * Contract Controller - Unified Pattern
 * Orion Orchestrator: Transitioning legacy to App\Models
 */

require_once __DIR__ . '/../../src/Models/Contract.php';
require_once __DIR__ . '/../../src/Models/Supervisor.php';

use App\Models\Contract;
use App\Models\Supervisor;

class ContractController
{
    private $contractModel;
    private $supervisorModel;

    public function __construct()
    {
        $this->contractModel = new Contract();
        $this->supervisorModel = new Supervisor();
    }

    public function create()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!$data) {
            http_response_code(400);
            echo json_encode(["message" => "Invalid JSON input."]);
            return;
        }

        // 1. Validate Supervisor Limit (Shared Logic)
        $activeInterns = $this->supervisorModel->getActiveInternsCount($data['supervisor_id']);
        if ($activeInterns >= 10) {
            http_response_code(400);
            echo json_encode(["message" => "Limite legal de 10 estagiários por supervisor excedido"]);
            return;
        }

        // 2. Create Contract (Shared Logic including 2-year validation)
        if ($this->contractModel->create($data)) {
            http_response_code(201);
            echo json_encode(["message" => "Contract created successfully."]);
        }
        else {
            http_response_code(400);
            echo json_encode(["message" => "Unable to create contract. Check 2-year limit or missing fields."]);
        }
    }

    public function checkExpiring()
    {
        $contracts = $this->contractModel->getExpiringContracts();
        echo json_encode($contracts);
    }

    public function getAll()
    {
        $contracts = $this->contractModel->allWithDetails();
        echo json_encode($contracts);
    }
}
