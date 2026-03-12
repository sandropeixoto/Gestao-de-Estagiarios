<?php
namespace App\Models;

require_once __DIR__ . '/BaseModel.php';

class Institution extends BaseModel {
    protected $table = 'institutions';

    public function create($data) {
        $sql = "INSERT INTO institutions (razao_social, cnpj, nome_diretor, email_diretor, nome_coordenador, email_coordenador, status_convenio) 
                VALUES (:razao_social, :cnpj, :nome_diretor, :email_diretor, :nome_coordenador, :email_coordenador, :status_convenio)";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':razao_social' => $data['razao_social'],
            ':cnpj' => $data['cnpj'],
            ':nome_diretor' => $data['nome_diretor'] ?? null,
            ':email_diretor' => $data['email_diretor'] ?? null,
            ':nome_coordenador' => $data['nome_coordenador'] ?? null,
            ':email_coordenador' => $data['email_coordenador'] ?? null,
            ':status_convenio' => $data['status_convenio'] ?? 'Ativo'
        ]);
    }
}
