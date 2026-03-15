<?php
namespace App\Models;

require_once __DIR__ . '/BaseModel.php';

class Contract extends BaseModel {
    protected $table = 'contracts';

    /**
     * Valida se o contrato não excede o limite legal de 2 anos.
     */
    public function validateDuration($startDate, $endDate) {
        $start = new \DateTime($startDate);
        $end = new \DateTime($endDate);
        $diff = $start->diff($end);

        // Se a diferença for maior que 2 anos ou tiver meses/dias além dos 2 anos
        if ($diff->y > 2 || ($diff->y == 2 && ($diff->m > 0 || $diff->d > 0))) {
            return false;
        }
        return true;
    }

    public function allWithDetails() {
        $sql = "SELECT c.*, s.nome as estagiario, i.razao_social as instituicao, 
                       ch.descricao as carga_horaria, m.descricao as motivo_desligamento,
                       sup.nome as supervisor_name
                FROM contracts c
                LEFT JOIN students s ON c.student_id = s.id
                LEFT JOIN institutions i ON c.institution_id = i.id
                LEFT JOIN cargas_horarias ch ON c.carga_horaria_id = ch.id
                LEFT JOIN motivos_desligamento m ON c.motivo_desligamento_id = m.id
                LEFT JOIN supervisors sup ON c.supervisor_id = sup.id
                ORDER BY c.data_inicio DESC";
        
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Busca contratos que vencem em 30 dias ou menos.
     */
    public function getExpiringContracts($days = 30) {
        $sql = "SELECT c.*, s.nome as student_name 
                FROM {$this->table} c
                JOIN students s ON c.student_id = s.id
                WHERE DATEDIFF(c.data_fim, CURDATE()) <= :days 
                AND c.status = 'Ativo'";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':days' => $days]);
        return $stmt->fetchAll();
    }

    public function create($data) {
        // Validação de 2 anos
        if (!$this->validateDuration($data['data_inicio'], $data['data_fim'])) {
            return false;
        }

        $sql = "INSERT INTO contracts (
                    student_id, institution_id, supervisor_id, position_id, 
                    carga_horaria_id, data_inicio, data_fim, valor_bolsa, 
                    valor_transporte, apolice_seguro, status
                ) VALUES (
                    :student_id, :institution_id, :supervisor_id, :position_id, 
                    :carga_horaria_id, :data_inicio, :data_fim, :valor_bolsa, 
                    :valor_transporte, :apolice_seguro, :status
                )";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':student_id' => $data['student_id'],
            ':institution_id' => $data['institution_id'],
            ':supervisor_id' => $data['supervisor_id'],
            ':position_id' => $data['position_id'] ?? null,
            ':carga_horaria_id' => $data['carga_horaria_id'] ?? null,
            ':data_inicio' => $data['data_inicio'],
            ':data_fim' => $data['data_fim'],
            ':valor_bolsa' => $data['valor_bolsa'] ?? 0.00,
            ':valor_transporte' => $data['valor_transporte'] ?? 0.00,
            ':apolice_seguro' => $data['apolice_seguro'] ?? null,
            ':status' => $data['status'] ?? 'Ativo'
        ]);
    }
}
