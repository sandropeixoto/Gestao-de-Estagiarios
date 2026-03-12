<?php
namespace App\Models;

require_once __DIR__ . '/BaseModel.php';

class Contract extends BaseModel {
    protected $table = 'contracts';

    public function allWithDetails() {
        $sql = "SELECT c.*, s.nome as estagiario, i.razao_social as instituicao, 
                       ch.descricao as carga_horaria, m.descricao as motivo_desligamento
                FROM contracts c
                LEFT JOIN students s ON c.student_id = s.id
                LEFT JOIN institutions i ON c.institution_id = i.id
                LEFT JOIN cargas_horarias ch ON c.carga_horaria_id = ch.id
                LEFT JOIN motivos_desligamento m ON c.motivo_desligamento_id = m.id
                ORDER BY c.data_inicio DESC";
        
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function create($data) {
        $sql = "INSERT INTO contracts (student_id, institution_id, supervisor_id, position_id, carga_horaria_id, data_inicio, data_fim, valor_bolsa, valor_transporte, status) 
                VALUES (:student_id, :institution_id, :supervisor_id, :position_id, :carga_horaria_id, :data_inicio, :data_fim, :valor_bolsa, :valor_transporte, :status)";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':student_id' => $data['student_id'],
            ':institution_id' => $data['institution_id'],
            ':supervisor_id' => $data['supervisor_id'],
            ':position_id' => $data['position_id'],
            ':carga_horaria_id' => $data['carga_horaria_id'],
            ':data_inicio' => $data['data_inicio'],
            ':data_fim' => $data['data_fim'],
            ':valor_bolsa' => $data['valor_bolsa'] ?? 0.00,
            ':valor_transporte' => $data['valor_transporte'] ?? 0.00,
            ':status' => $data['status'] ?? 'Ativo'
        ]);
    }
}
