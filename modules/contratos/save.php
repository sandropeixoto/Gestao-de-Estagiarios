<?php
require_once __DIR__ . '/../../src/Models/Contract.php';
require_once __DIR__ . '/../../config/database.php';

use App\Models\Contract;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $contractModel = new Contract();
    $db = Database::getConnection();
    
    $data = [
        'student_id' => (int)$_POST['student_id'],
        'institution_id' => (int)$_POST['institution_id'],
        'supervisor_id' => (int)$_POST['supervisor_id'],
        'position_id' => (int)$_POST['position_id'],
        'nivel_escolaridade_id' => (int)$_POST['nivel_escolaridade_id'],
        'carga_horaria_id' => (int)$_POST['carga_horaria_id'],
        'data_inicio' => $_POST['data_inicio'],
        'data_fim' => $_POST['data_fim'],
        'valor_bolsa' => (float)$_POST['valor_bolsa'],
        'valor_transporte' => (float)$_POST['valor_transporte'],
        'status' => $_POST['status']
    ];

    try {
        $db->beginTransaction();
        
        // 1. Criar o Contrato
        if ($contractModel->create($data)) {
            // 2. Atualizar o status da Vaga para 'Ocupada'
            $stmt = $db->prepare("UPDATE positions SET status = 'Ocupada' WHERE id = ?");
            $stmt->execute([$data['position_id']]);
            
            $db->commit();
            header('Location: index.php?status=success&message=Contrato formalizado e vaga ocupada!');
        } else {
            $db->rollBack();
            header('Location: novo.php?status=error&message=Erro ao formalizar contrato.');
        }
    } catch (\Exception $e) {
        if ($db->inTransaction()) $db->rollBack();
        header('Location: novo.php?status=error&message=' . urlencode($e->getMessage()));
    }
    exit;
}
