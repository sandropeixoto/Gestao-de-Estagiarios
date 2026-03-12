<?php
namespace App\Models;

require_once __DIR__ . '/BaseModel.php';

class Position extends BaseModel {
    protected $table = 'positions';

    public function allWithDetails() {
        $sql = "SELECT p.*, l.subunidade, n.descricao as nivel, c.descricao as carga_horaria 
                FROM positions p
                LEFT JOIN lotacoes l ON p.lotacao_id = l.id
                LEFT JOIN niveis_escolaridade n ON p.nivel_escolaridade_id = n.id
                LEFT JOIN cargas_horarias c ON p.carga_horaria_id = c.id
                ORDER BY p.created_at DESC";
        
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function create($data) {
        $sql = "INSERT INTO positions (lotacao_id, nivel_escolaridade_id, carga_horaria_id, quantidade, remuneracao_base, requisitos, status) 
                VALUES (:lotacao_id, :nivel_escolaridade_id, :carga_horaria_id, :quantidade, :remuneracao_base, :requisitos, :status)";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':lotacao_id' => $data['lotacao_id'],
            ':nivel_escolaridade_id' => $data['nivel_escolaridade_id'],
            ':carga_horaria_id' => $data['carga_horaria_id'],
            ':quantidade' => $data['quantidade'] ?? 1,
            ':remuneracao_base' => $data['remuneracao_base'] ?? 0.00,
            ':requisitos' => $data['requisitos'] ?? null,
            ':status' => $data['status'] ?? 'Aberta'
        ]);
    }
}
