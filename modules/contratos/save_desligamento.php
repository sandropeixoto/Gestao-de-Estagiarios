<?php
require_once __DIR__ . '/../../src/Models/Contract.php';
require_once __DIR__ . '/../../config/database.php';
use App\Models\Contract;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $positionId = $_POST['position_id'];
    
    $contractModel = new Contract();
    $db = Database::getConnection();
    
    $data = [
        'data_desligamento' => $_POST['data_desligamento'],
        'motivo_desligamento_id' => (int)$_POST['motivo_desligamento_id'],
        'status' => 'Encerrado'
    ];

    try {
        $db->beginTransaction();
        
        // 1. Atualizar o Contrato
        if ($contractModel->update($id, $data)) {
            // 2. Abrir a Vaga novamente
            $stmt = $db->prepare("UPDATE positions SET status = 'Aberta' WHERE id = ?");
            $stmt->execute([$positionId]);
            
            $db->commit();
            header('Location: index.php?status=success&message=Desligamento registrado e vaga liberada!');
        } else {
            $db->rollBack();
            header('Location: desligar.php?id=' . $id . '&status=error&message=Erro ao registrar desligamento.');
        }
    } catch (\Exception $e) {
        if ($db->inTransaction()) $db->rollBack();
        header('Location: desligar.php?id=' . $id . '&status=error&message=' . urlencode($e->getMessage()));
    }
    exit;
}
