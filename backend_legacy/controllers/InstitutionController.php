<?php
/**
 * Institution Controller - Unified Pattern
 * Orion Orchestrator: Transitioning legacy to App\Models
 */

require_once __DIR__ . '/../../src/Models/Institution.php';

use App\Models\Institution;

class InstitutionController
{
    private $institutionModel;

    public function __construct()
    {
        $this->institutionModel = new Institution();
    }

    public function create()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!empty($data['razao_social']) && !empty($data['cnpj'])) {
            if ($this->institutionModel->create($data)) {
                http_response_code(201);
                echo json_encode(["message" => "Institution created successfully."]);
            }
            else {
                http_response_code(503);
                echo json_encode(["message" => "Unable to create institution."]);
            }
        }
        else {
            http_response_code(400);
            echo json_encode(["message" => "Incomplete data. Razao Social and CNPJ are required."]);
        }
    }

    public function getAll()
    {
        $institutions = $this->institutionModel->all();
        echo json_encode($institutions);
    }
}
