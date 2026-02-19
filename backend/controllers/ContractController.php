// Use __DIR__ para caminhos absolutos baseados no diretório do arquivo
include_once __DIR__ . '/../config/database.php';
include_once __DIR__ . '/../models/Contract.php';
include_once '../models/Supervisor.php';

class ContractController
{
    private $db;
    private $contract;
    private $supervisor;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->contract = new Contract($this->db);
        $this->supervisor = new Supervisor($this->db);
    }

    public function create()
    {
        $data = json_decode(file_get_contents("php://input"));

        // Validate Supervisor Limit
        $activeInterns = $this->supervisor->getActiveInternsCount($data->supervisor_id);
        if ($activeInterns >= 10) {
            http_response_code(400);
            echo json_encode(array("message" => "Limite legal de 10 estagiários por supervisor excedido"));
            return;
        }

        $this->contract->student_id = $data->student_id;
        $this->contract->institution_id = $data->institution_id;
        $this->contract->supervisor_id = $data->supervisor_id;
        $this->contract->data_inicio = $data->data_inicio;
        $this->contract->data_fim = $data->data_fim;
        $this->contract->valor_bolsa = $data->valor_bolsa;
        $this->contract->valor_transporte = $data->valor_transporte;
        $this->contract->apolice_seguro = $data->apolice_seguro;

        if ($this->contract->create()) {
            http_response_code(201);
            echo json_encode(array("message" => "Contract created."));
        }
        else {
            http_response_code(400); // Bad Request commonly for validation errors
            echo json_encode(array("message" => "Unable to create contract. Check 2-year limit."));
        }
    }

    public function checkExpiring()
    {
        $contracts = $this->contract->getExpiringContracts();
        echo json_encode($contracts);
    }

    public function getAll()
    {
        $stmt = $this->contract->getAll();
        echo json_encode($stmt);
    }
}
?>