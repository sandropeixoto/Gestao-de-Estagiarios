<?php
require_once __DIR__ . '/../../src/Models/Supervisor.php';
use App\Models\Supervisor;

$id = $_GET['id'] ?? null;

if ($id) {
    $supervisorModel = new Supervisor();
    try {
        if ($supervisorModel->delete($id)) {
            header('Location: index.php?status=success&message=Supervisor excluído com sucesso!');
        } else {
            header('Location: index.php?status=error&message=Erro ao excluir supervisor.');
        }
    } catch (\Exception $e) {
        header('Location: index.php?status=error&message=' . urlencode($e->getMessage()));
    }
} else {
    header('Location: index.php?status=error&message=ID não fornecido.');
}
exit;
