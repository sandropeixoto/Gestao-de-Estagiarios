<?php
namespace App\Models;

require_once __DIR__ . '/BaseModel.php';

class Student extends BaseModel {
    protected $table = 'students';

    public function allWithDetails() {
        $sql = "SELECT s.*, i.razao_social as instituicao, n.descricao as nivel 
                FROM students s
                LEFT JOIN institutions i ON s.institution_id = i.id
                LEFT JOIN niveis_escolaridade n ON s.nivel_escolaridade_id = n.id
                ORDER BY s.nome ASC";
        
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function create($data) {
        $sql = "INSERT INTO students (nome, cpf, curso, semestre, previsao_formatura, nivel_escolaridade_id, institution_id) 
                VALUES (:nome, :cpf, :curso, :semestre, :previsao_formatura, :nivel_escolaridade_id, :institution_id)";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':nome' => $data['nome'],
            ':cpf' => $data['cpf'],
            ':curso' => $data['curso'],
            ':semestre' => $data['semestre'],
            ':previsao_formatura' => $data['previsao_formatura'],
            ':nivel_escolaridade_id' => $data['nivel_escolaridade_id'],
            ':institution_id' => $data['institution_id']
        ]);
    }
}
