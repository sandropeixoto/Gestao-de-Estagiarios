// Use __DIR__ para caminhos absolutos baseados no diretório do arquivo
include_once __DIR__ . '/../config/database.php';
include_once __DIR__ . '/../models/Student.php';

class StudentController
{
    private $db;
    private $student;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->student = new Student($this->db);
    }

    public function create()
    {
        $data = json_decode(file_get_contents("php://input"));
        if (!empty($data->nome) && !empty($data->cpf)) {
            $this->student->nome = $data->nome;
            $this->student->cpf = $data->cpf;
            $this->student->curso = $data->curso ?? null;
            $this->student->semestre = $data->semestre ?? null;
            $this->student->previsao_formatura = $data->previsao_formatura ?? null;
            $this->student->dados_bancarios = $data->dados_bancarios ?? null;
            $this->student->comprovante_matricula_path = $data->comprovante_matricula_path ?? null;

            if ($this->student->create()) {
                http_response_code(201);
                echo json_encode(array("message" => "Student created."));
            }
            else {
                http_response_code(503);
                echo json_encode(array("message" => "Unable to create student."));
            }
        }
        else {
            http_response_code(400);
            echo json_encode(array("message" => "Incomplete data."));
        }
    }

    public function getAll()
    {
        $stmt = $this->student->getAll();
        echo json_encode($stmt);
    }
}
?>