<?php
require_once __DIR__ . '/../../src/Models/Supervisor.php';

use App\Models\Supervisor;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $supervisorModel = new Supervisor();
    
    $data = [
        'nome' => $_POST['nome'],
        'cargo' => $_POST['cargo'] ?? null,
        'email' => $_POST['email'] ?? null,
        'telefone_ramal' => $_POST['telefone_ramal'] ?? null,
        'lotacao_id' => (int)$_POST['lotacao_id']
    ];

    try {
        if ($supervisorModel->create($data)) {
            header('Location: index.php?status=success&message=Supervisor cadastrado com sucesso!');
        } else {
            header('Location: supervisores_novo.php?status=error&message=Erro ao cadastrar supervisor.');
        }
    } catch (\Exception $e) {
        header('Location: supervisores_novo.php?status=error&message=' . urlencode($e->getMessage()));
    }
    exit;
}
