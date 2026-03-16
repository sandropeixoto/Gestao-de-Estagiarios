<?php
require_once __DIR__ . '/../../src/Models/Position.php';

use App\Models\Position;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $posModel = new Position();
    
    $data = [
        'lotacao_id' => (int)$_POST['lotacao_id'],
        'quantidade' => (int)$_POST['quantidade'],
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
