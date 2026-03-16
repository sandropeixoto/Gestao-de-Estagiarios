<?php
require_once __DIR__ . '/../../src/Models/Position.php';
use App\Models\Position;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $posModel = new Position();
    
    $data = [
        'lotacao_id' => (int)$_POST['lotacao_id'],
        'quantidade' => (int)$_POST['quantidade'],
        'requisitos' => $_POST['requisitos'] ?: '',
        'status' => $_POST['status']
    ];

    try {
        if ($posModel->update($id, $data)) {
            header('Location: index.php?status=success&message=Vaga atualizada com sucesso!');
        } else {
            header('Location: editar.php?id=' . $id . '&status=error&message=Erro ao atualizar vaga.');
        }
    } catch (\Exception $e) {
        header('Location: editar.php?id=' . $id . '&status=error&message=' . urlencode($e->getMessage()));
    }
    exit;
}
