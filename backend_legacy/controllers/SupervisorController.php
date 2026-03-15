<?php
/**
 * Supervisor Controller - Unified Pattern
 * Orion Orchestrator: Transitioning legacy to App\Models
 */

require_once __DIR__ . '/../../src/Models/Supervisor.php';

use App\Models\Supervisor;

class SupervisorController
{
    private $supervisorModel;

    public function __construct()
    {
        $this->supervisorModel = new Supervisor();
    }

    public function create()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!empty($data['nome'])) {
            // Note: Adapting legacy 'area' to potentially missing 'lotacao_id' or keeping as is
            // If the legacy UI sends 'area', we might need a mapping, but for now let's use the schema fields.
            $params = [
                'nome' => $data['nome'],
                'cargo' => $data['cargo'] ?? null,
                'email' => $data['email'] ?? null,
                'telefone_ramal' => $data['telefone_ramal'] ?? null,
                'lotacao_id' => $data['lotacao_id'] ?? null
            ];

            if ($this->supervisorModel->create($params)) {
                http_response_code(201);
                echo json_encode(["message" => "Supervisor created."]);
            }
            else {
                http_response_code(503);
                echo json_encode(["message" => "Unable to create supervisor."]);
            }
        }
        else {
            http_response_code(400);
            echo json_encode(["message" => "Incomplete data. Nome is required."]);
        }
    }

    public function getAll()
    {
        $supervisors = $this->supervisorModel->allWithLotacao();
        echo json_encode($supervisors);
    }

    public function assignIntern($supervisor_id)
    {
        $activeInterns = $this->supervisorModel->getActiveInternsCount($supervisor_id);
        if ($activeInterns >= 10) {
            http_response_code(400);
            echo json_encode(["message" => "Limite legal de 10 estagiários por supervisor excedido"]);
            return false;
        }
        return true;
    }
}
