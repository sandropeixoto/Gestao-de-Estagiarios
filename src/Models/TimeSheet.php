<?php
namespace App\Models;

require_once __DIR__ . '/BaseModel.php';

class TimeSheet extends BaseModel {
    protected $table = 'timesheets';

    /**
     * Registra uma folha de ponto com validação de carga horária.
     */
    public function register($data) {
        // Cálculo de horas
        $start = new \DateTime($data['hora_entrada']);
        $end = new \DateTime($data['hora_saida']);
        $diff = $start->diff($end);
        $hours = $diff->h + ($diff->i / 60);

        // Limite legal (6h padrão, 3h em dia de prova)
        $limit = 6;
        if (isset($data['is_dia_prova']) && $data['is_dia_prova']) {
            $limit = 3;
        }

        if ($hours > $limit) {
            return false; // Excede o limite legal
        }

        $sql = "INSERT INTO {$this->table} (contract_id, date, hora_entrada, hora_saida, geolocalizacao, is_dia_prova)
                VALUES (:contract_id, :date, :hora_entrada, :hora_saida, :geolocalizacao, :is_dia_prova)";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':contract_id' => $data['contract_id'],
            ':date' => $data['date'],
            ':hora_entrada' => $data['hora_entrada'],
            ':hora_saida' => $data['hora_saida'],
            ':geolocalizacao' => $data['geolocalizacao'] ?? null,
            ':is_dia_prova' => isset($data['is_dia_prova']) ? (int)$data['is_dia_prova'] : 0
        ]);
    }
}
