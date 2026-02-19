// Use __DIR__ para caminhos absolutos baseados no diretório do arquivo
include_once __DIR__ . '/../config/database.php';
include_once __DIR__ . '/../models/Institution.php';

class InstitutionController
{
    private $db;
    private $institution;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->institution = new Institution($this->db);
    }

    public function create()
    {
        $data = json_decode(file_get_contents("php://input"));
        if (!empty($data->razao_social) && !empty($data->cnpj)) {
            $this->institution->razao_social = $data->razao_social;
            $this->institution->cnpj = $data->cnpj;
            $this->institution->coordenador_responsavel = $data->coordenador_responsavel ?? null;
            $this->institution->status_convenio = $data->status_convenio ?? 'Ativo';

            if ($this->institution->create()) {
                http_response_code(201);
                echo json_encode(array("message" => "Institution created."));
            }
            else {
                http_response_code(503);
                echo json_encode(array("message" => "Unable to create institution."));
            }
        }
    }

    public function getAll()
    {
        $stmt = $this->institution->getAll();
        echo json_encode($stmt);
    }
}
?>