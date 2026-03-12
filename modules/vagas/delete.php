<?php
require_once __DIR__ . '/../../src/Models/Position.php';
use App\Models\Position;

$id = $_GET['id'] ?? null;

if ($id) {
    $posModel = new Position();
    try {
        if ($posModel->delete($id)) {
            header('Location: index.php?status=success&message=Vaga excluída com sucesso!');
        } else {
            header('Location: index.php?status=error&message=Erro ao excluir vaga.');
        }
    } catch (\Exception $e) {
        header('Location: index.php?status=error&message=' . urlencode($e->getMessage()));
    }
} else {
    header('Location: index.php?status=error&message=ID não fornecido.');
}
exit;
