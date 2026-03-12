<?php
require_once __DIR__ . '/../../src/Models/Institution.php';
use App\Models\Institution;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $instModel = new Institution();
    
    $data = [
        'razao_social' => $_POST['razao_social'],
        'cnpj' => preg_replace('/[^0-9]/', '', $_POST['cnpj']),
        'nome_diretor' => $_POST['nome_diretor'] ?: null,
        'email_diretor' => $_POST['email_diretor'] ?: null,
        'nome_coordenador' => $_POST['nome_coordenador'] ?: null,
        'email_coordenador' => $_POST['email_coordenador'] ?: null,
        'status_convenio' => $_POST['status_convenio']
    ];

    try {
        if ($instModel->update($id, $data)) {
            header('Location: index.php?status=success&message=Instituição atualizada com sucesso!');
        } else {
            header('Location: editar.php?id=' . $id . '&status=error&message=Erro ao atualizar instituição.');
        }
    } catch (\Exception $e) {
        header('Location: editar.php?id=' . $id . '&status=error&message=' . urlencode($e->getMessage()));
    }
    exit;
}
