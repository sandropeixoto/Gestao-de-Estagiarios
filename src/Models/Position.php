<?php
namespace App\Models;

require_once __DIR__ . '/BaseModel.php';

class Position extends BaseModel {
    protected $table = 'positions';

    public function allWithDetails() {
        $sql = "SELECT p.*, l.subunidade 
                FROM positions p
                LEFT JOIN lotacoes l ON p.lotacao_id = l.id
                ORDER BY p.created_at DESC";
        
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function create($data) {
        $sql = "INSERT INTO positions (lotacao_id, quantidade, requisitos, status) 
                VALUES (:lotacao_id, :quantidade, :requisitos, :status)";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':lotacao_id' => $data['lotacao_id'],
            ':quantidade' => $data['quantidade'] ?? 1,
            ':requisitos' => $data['requisitos'] ?? null,
            ':status' => $data['status'] ?? 'Aberta'
        ]);
    }
}
