<?php
require_once __DIR__ . '/../../src/Models/Institution.php';
use App\Models\Institution;

$id = $_GET['id'] ?? null;

if ($id) {
    $instModel = new Institution();
    try {
        if ($instModel->delete($id)) {
            header('Location: index.php?status=success&message=Instituição excluída com sucesso!');
        } else {
            header('Location: index.php?status=error&message=Erro ao excluir instituição.');
        }
    } catch (\Exception $e) {
        header('Location: index.php?status=error&message=' . urlencode($e->getMessage()));
    }
} else {
    header('Location: index.php?status=error&message=ID não fornecido.');
}
exit;
