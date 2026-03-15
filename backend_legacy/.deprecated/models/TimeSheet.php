<?php
class TimeSheet
{
    private $conn;
    private $table_name = "timesheets";

    public $contract_id;
    public $date;
    public $hora_entrada;
    public $hora_saida;
    public $geolocalizacao;
    public $is_dia_prova;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function register()
    {
        // Calculate hours
        $start = new DateTime($this->hora_entrada);
        $end = new DateTime($this->hora_saida);
        $diff = $start->diff($end);
        $hours = $diff->h + ($diff->i / 60);

        $limit = 6;
        if ($this->is_dia_prova) {
            $limit = 3; // Reduced by half
        }

        if ($hours > $limit) {
            return false; // Exceeds limit
        }

        $query = "INSERT INTO " . $this->table_name . "
                    (contract_id, date, hora_entrada, hora_saida, geolocalizacao, is_dia_prova)
                    VALUES
                    (:contract_id, :date, :hora_entrada, :hora_saida, :geolocalizacao, :is_dia_prova)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":contract_id", $this->contract_id);
        $stmt->bindParam(":date", $this->date);
        $stmt->bindParam(":hora_entrada", $this->hora_entrada);
        $stmt->bindParam(":hora_saida", $this->hora_saida);
        $stmt->bindParam(":geolocalizacao", $this->geolocalizacao);
        $stmt->bindParam(":is_dia_prova", $this->is_dia_prova);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>