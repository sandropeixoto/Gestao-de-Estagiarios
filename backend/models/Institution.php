<?php
class Institution
{
    private $conn;
    private $table_name = "institutions";

    public $id;
    public $razao_social;
    public $cnpj;
    public $coordenador_responsavel;
    public $status_convenio;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create()
    {
        $query = "INSERT INTO " . $this->table_name . "
                    (razao_social, cnpj, coordenador_responsavel, status_convenio)
                    VALUES
                    (:razao_social, :cnpj, :coordenador_responsavel, :status_convenio)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":razao_social", $this->razao_social);
        $stmt->bindParam(":cnpj", $this->cnpj);
        $stmt->bindParam(":coordenador_responsavel", $this->coordenador_responsavel);
        $stmt->bindParam(":status_convenio", $this->status_convenio);

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