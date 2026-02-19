// Use __DIR__ para caminhos absolutos baseados no diretório do arquivo
include_once __DIR__ . '/../config/database.php';
include_once __DIR__ . '/../models/TimeSheet.php';

class TimeSheetController
{
    private $db;
    private $timesheet;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->timesheet = new TimeSheet($this->db);
    }

    public function register()
    {
        $data = json_decode(file_get_contents("php://input"));

        $this->timesheet->contract_id = $data->contract_id;
        $this->timesheet->date = $data->date;
        $this->timesheet->hora_entrada = $data->hora_entrada;
        $this->timesheet->hora_saida = $data->hora_saida;
        $this->timesheet->geolocalizacao = $data->geolocalizacao;
        $this->timesheet->is_dia_prova = $data->is_dia_prova; // Boolean passed from frontend

        if ($this->timesheet->register()) {
            http_response_code(201);
            echo json_encode(array("message" => "TimeSheet registered."));
        }
        else {
            http_response_code(400);
            echo json_encode(array("message" => "Unable to register timesheet. Exceeds daily limit."));
        }
    }
}
?>