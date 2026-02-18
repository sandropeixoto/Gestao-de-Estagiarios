<?php
include_once '../config/database.php';
include_once '../models/Supervisor.php';

class SupervisorController
{
    private $db;
    private $supervisor;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->supervisor = new Supervisor($this->db);
    }

    public function create()
    {
        $data = json_decode(file_get_contents("php://input"));

        if (!empty($data->nome) && !empty($data->cargo) && !empty($data->area)) {
            $this->supervisor->nome = $data->nome;
            $this->supervisor->cargo = $data->cargo;
            $this->supervisor->area = $data->area;

            if ($this->supervisor->create()) {
                http_response_code(201);
                echo json_encode(array("message" => "Supervisor created."));
            }
            else {
                http_response_code(503);
                echo json_encode(array("message" => "Unable to create supervisor."));
            }
        }
        else {
            http_response_code(400);
            echo json_encode(array("message" => "Incomplete data."));
        }
    }

    public function getAll()
    {
        $stmt = $this->supervisor->getAll();
        echo json_encode($stmt);
    }

    public function assignIntern($supervisor_id)
    {
        $activeInterns = $this->supervisor->getActiveInternsCount($supervisor_id);
        if ($activeInterns >= 10) {
            http_response_code(400);
            echo json_encode(array("message" => "Limite legal de 10 estagiários por supervisor excedido"));
            return false;
        }
        return true;
    }
}
?>