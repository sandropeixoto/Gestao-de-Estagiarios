<?php
namespace App\Models;

require_once __DIR__ . '/BaseModel.php';

class Supervisor extends BaseModel {
    protected $table = 'supervisors';

    public function allWithLotacao() {
        $sql = "SELECT s.*, l.unidade, l.subunidade 
                FROM supervisors s
                LEFT JOIN lotacoes l ON s.lotacao_id = l.id
                ORDER BY s.nome ASC";
        
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function create($data) {
        $sql = "INSERT INTO supervisors (nome, cargo, email, telefone_ramal, lotacao_id) 
                VALUES (:nome, :cargo, :email, :telefone_ramal, :lotacao_id)";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':nome' => $data['nome'],
            ':cargo' => $data['cargo'] ?? null,
            ':email' => $data['email'] ?? null,
            ':telefone_ramal' => $data['telefone_ramal'] ?? null,
            ':lotacao_id' => $data['lotacao_id']
        ]);
    }
}
