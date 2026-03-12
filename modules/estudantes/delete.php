<?php
require_once __DIR__ . '/../../src/Models/Student.php';
use App\Models\Student;

$id = $_GET['id'] ?? null;

if ($id) {
    $studentModel = new Student();
    try {
        if ($studentModel->delete($id)) {
            header('Location: index.php?status=success&message=Estudante excluído com sucesso!');
        } else {
            header('Location: index.php?status=error&message=Erro ao excluir estudante.');
        }
    } catch (\Exception $e) {
        header('Location: index.php?status=error&message=' . urlencode($e->getMessage()));
    }
} else {
    header('Location: index.php?status=error&message=ID não fornecido.');
}
exit;
