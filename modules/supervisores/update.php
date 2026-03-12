<?php
require_once __DIR__ . '/../../src/Models/Supervisor.php';
use App\Models\Supervisor;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $supervisorModel = new Supervisor();
    
    $data = [
        'nome' => $_POST['nome'],
        'cargo' => $_POST['cargo'] ?: null,
        'email' => $_POST['email'] ?: null,
        'telefone_ramal' => $_POST['telefone_ramal'] ?: null,
        'lotacao_id' => (int)$_POST['lotacao_id']
    ];

    try {
        if ($supervisorModel->update($id, $data)) {
            header('Location: index.php?status=success&message=Supervisor atualizado com sucesso!');
        } else {
            header('Location: editar.php?id=' . $id . '&status=error&message=Erro ao atualizar supervisor.');
        }
    } catch (\Exception $e) {
        header('Location: editar.php?id=' . $id . '&status=error&message=' . urlencode($e->getMessage()));
    }
    exit;
}
