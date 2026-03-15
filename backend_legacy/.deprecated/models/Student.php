<?php
class Student
{
    private $conn;
    private $table_name = "students";

    public $id;
    public $nome;
    public $cpf;
    public $curso;
    public $semestre;
    public $previsao_formatura;
    public $dados_bancarios;
    public $comprovante_matricula_path;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create()
    {
        $query = "INSERT INTO " . $this->table_name . "
                    (nome, cpf, curso, semestre, previsao_formatura, dados_bancarios, comprovante_matricula_path)
                    VALUES
                    (:nome, :cpf, :curso, :semestre, :previsao_formatura, :dados_bancarios, :comprovante_matricula_path)";

        $stmt = $this->conn->prepare($query);

        // Sanitize & bind
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->cpf = htmlspecialchars(strip_tags($this->cpf));
        // ... (others)

        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":cpf", $this->cpf);
        $stmt->bindParam(":curso", $this->curso);
        $stmt->bindParam(":semestre", $this->semestre);
        $stmt->bindParam(":previsao_formatura", $this->previsao_formatura);
        $stmt->bindParam(":dados_bancarios", $this->dados_bancarios);
        $stmt->bindParam(":comprovante_matricula_path", $this->comprovante_matricula_path);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getAll()
    {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>