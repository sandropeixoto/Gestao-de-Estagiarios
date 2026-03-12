<?php
require_once __DIR__ . '/../src/Models/Institution.php';

use App\Models\Institution;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $instModel = new Institution();
    
    $data = [
        'razao_social' => $_POST['razao_social'],
        'cnpj' => preg_replace('/[^0-9]/', '', $_POST['cnpj']),
        'nome_diretor' => $_POST['nome_diretor'] ?? null,
        'email_diretor' => $_POST['email_diretor'] ?? null,
        'nome_coordenador' => $_POST['nome_coordenador'] ?? null,
        'email_coordenador' => $_POST['email_coordenador'] ?? null,
        'status_convenio' => 'Ativo'
    ];

    try {
        if ($instModel->create($data)) {
            header('Location: index.php?status=success&message=Instituição cadastrada com sucesso!');
        } else {
            header('Location: instituicoes_novo.php?status=error&message=Erro ao cadastrar instituição.');
        }
    } catch (\Exception $e) {
        header('Location: instituicoes_novo.php?status=error&message=' . urlencode($e->getMessage()));
    }
    exit;
}
