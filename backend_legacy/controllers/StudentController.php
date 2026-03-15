<?php
/**
 * Student Controller - Unified Pattern
 * Orion Orchestrator: Transitioning legacy to App\Models
 */

require_once __DIR__ . '/../../src/Models/Student.php';

use App\Models\Student;

class StudentController
{
    private $studentModel;

    public function __construct()
    {
        $this->studentModel = new Student();
    }

    public function create()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!empty($data['nome']) && !empty($data['cpf'])) {
            if ($this->studentModel->create($data)) {
                http_response_code(201);
                echo json_encode(["message" => "Student created successfully."]);
            }
            else {
                http_response_code(503);
                echo json_encode(["message" => "Unable to create student."]);
            }
        }
        else {
            http_response_code(400);
            echo json_encode(["message" => "Incomplete data. Nome and CPF are required."]);
        }
    }

    public function getAll()
    {
        $students = $this->studentModel->all();
        echo json_encode($students);
    }
}
