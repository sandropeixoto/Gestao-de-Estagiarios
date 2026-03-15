<?php
require_once __DIR__ . '/../../includes/auth_check.php';
require_once __DIR__ . '/../../src/Models/User.php';

use App\Models\User;

if ($userLevel > 2) { die("Acesso negado."); }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userModel = new User();
    $action = $_POST['action'] ?? 'update';

    try {
        if ($action === 'create') {
            $data = [
                'nome' => $_POST['nome'],
                'email' => $_POST['email'],
                'sso_user_id' => !empty($_POST['sso_user_id']) ? $_POST['sso_user_id'] : 0,
                'nivel_acesso' => $_POST['nivel_acesso']
            ];
            $userModel->createManual($data);
            $msg = "Usuário cadastrado com sucesso.";
        } else {
            $id = $_POST['id'];
            $nivel_acesso = $_POST['nivel_acesso'];
            $userModel->update($id, ['nivel_acesso' => $nivel_acesso]);
            $msg = "Perfil atualizado com sucesso.";
        }
        
        header('Location: index.php?status=success&message=' . urlencode($msg));
    } catch (Exception $e) {
        header('Location: index.php?status=error&message=' . urlencode($e->getMessage()));
    }
    exit;
}
