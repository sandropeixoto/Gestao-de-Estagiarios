<?php
require_once __DIR__ . '/../../src/Models/Position.php';

use App\Models\Position;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $posModel = new Position();
    
    $data = [
        'lotacao_id' => (int)$_POST['lotacao_id'],
        'nivel_escolaridade_id' => (int)$_POST['nivel_escolaridade_id'],
        'carga_horaria_id' => (int)$_POST['carga_horaria_id'],
        'quantidade' => (int)$_POST['quantidade'],
        'remuneracao_base' => (float)$_POST['remuneracao_base'],
        'requisitos' => $_POST['requisitos'] ?? '',
        'status' => 'Aberta'
    ];

    try {
        if ($posModel->create($data)) {
            header('Location: index.php?status=success&message=Vaga publicada com sucesso!');
        } else {
            header('Location: vagas_novo.php?status=error&message=Erro ao publicar vaga.');
        }
    } catch (\Exception $e) {
        header('Location: vagas_novo.php?status=error&message=' . urlencode($e->getMessage()));
    }
    exit;
}
