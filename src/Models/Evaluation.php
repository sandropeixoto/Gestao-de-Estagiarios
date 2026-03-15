<?php
namespace App\Models;

require_once __DIR__ . '/BaseModel.php';

class Evaluation extends BaseModel {
    protected $table = 'evaluations';

    /**
     * Busca avaliações pendentes (contratos ativos sem avaliação).
     */
    public function getPendingEvaluations() {
        $sql = "SELECT c.id, s.nome as student_name 
                FROM contracts c 
                JOIN students s ON c.student_id = s.id
                WHERE c.status = 'Ativo' 
                AND c.id NOT IN (SELECT contract_id FROM evaluations)";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
}
