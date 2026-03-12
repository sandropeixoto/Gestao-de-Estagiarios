<?php
require_once __DIR__ . '/../../src/Models/Student.php';
use App\Models\Student;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $studentModel = new Student();
    
    $data = [
        'nome' => $_POST['nome'],
        'cpf' => preg_replace('/[^0-9]/', '', $_POST['cpf']),
        'curso' => $_POST['curso'],
        'semestre' => (int)$_POST['semestre'],
        'nivel_escolaridade_id' => (int)$_POST['nivel_escolaridade_id'],
        'institution_id' => (int)$_POST['institution_id']
    ];

    try {
        if ($studentModel->update($id, $data)) {
            header('Location: index.php?status=success&message=Estudante atualizado com sucesso!');
        } else {
            header('Location: editar.php?id=' . $id . '&status=error&message=Erro ao atualizar estudante.');
        }
    } catch (\Exception $e) {
        header('Location: editar.php?id=' . $id . '&status=error&message=' . urlencode($e->getMessage()));
    }
    exit;
}
