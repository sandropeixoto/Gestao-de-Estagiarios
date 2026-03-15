<?php
/**
 * SSO Authentication Handler - GestorGov Integration (Governance v2)
 * Orion Orchestrator: Manual Approval Policy + Visitor Toggle
 */

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/src/Models/User.php';

use App\Models\User;

// 1. Configuração do Segredo
if (!defined('SSO_SECRET_KEY')) {
    define('SSO_SECRET_KEY', 'GestorGov_Secure_Integration_Token_2026!');
}
$ssoSecret = SSO_SECRET_KEY;

// 2. Captura dos Parâmetros
$payloadBase64 = $_GET['sso_payload'] ?? null;
$signatureReceived = $_GET['sso_sig'] ?? null;

if (!$payloadBase64 || !$signatureReceived) {
    header("HTTP/1.1 401 Unauthorized");
    die("Acesso negado: Token SSO ausente.");
}

// 3. Validação HMAC-SHA256
$expectedSignature = hash_hmac('sha256', $payloadBase64, $ssoSecret);
if (!hash_equals($expectedSignature, $signatureReceived)) {
    header("HTTP/1.1 403 Forbidden");
    die("Acesso negado: Assinatura SSO inválida.");
}

// 4. Decodificação
$userData = json_decode(base64_decode($payloadBase64), true);
if (!$userData || time() > $userData['exp']) {
    die("Acesso negado: Token malformado ou expirado.");
}

// 5. Política de Governança: Somente Cadastrados ou Visitantes Permitidos
try {
    $userModel = new User();
    
    // Mapear user_level string para inteiro antecipadamente para o bypass
    $incomingLevel = 3; // Default Consultor
    if (isset($userData['user_level'])) {
        $levelMap = ['Administrador' => 1, 'Admin' => 1, 'Gestor' => 2];
        $incomingLevel = is_numeric($userData['user_level']) ? $userData['user_level'] : ($levelMap[$userData['user_level']] ?? 3);
    }

    $localUser = $userModel->findBySSO($userData['user_id'], $userData['user_email']);

    if (!$localUser) {
        // BYPASS: Se for Administrador no Portal, cadastrar automaticamente com poder total
        if ($incomingLevel == 1) {
            $userModel->createManual([
                'nome' => $userData['user_name'],
                'email' => $userData['user_email'],
                'sso_user_id' => $userData['user_id'],
                'nivel_acesso' => 1
            ]);
            $localUser = $userModel->findBySSO($userData['user_id'], $userData['user_email']);
        } else {
            // Usuário não cadastrado. Verificar política de visitantes.
            $allowVisitors = $userModel->getSetting('allow_visitors');

            if ($allowVisitors === '1') {
                $localUser = [
                    'id' => 0,
                    'nome' => $userData['user_name'] . ' (Visitante)',
                    'email' => $userData['user_email'],
                    'nivel_acesso' => 3 // Consultor
                ];
            } else {
                die("<div style='font-family: sans-serif; text-align: center; padding: 50px;'>
                        <h1>🔒 Acesso Restrito</h1>
                        <p>Olá <b>{$userData['user_name']}</b>, você está autenticado no Portal, mas ainda não possui cadastro neste módulo.</p>
                        <p>Por favor, solicite seu acesso ao administrador do sistema.</p>
                     </div>");
            }
        }
    } else {
        // Usuário Cadastrado: Atualizar timestamp de acesso
        $userModel->update($localUser['id'], ['ultimo_acesso' => date('Y-m-d H:i:s')]);
    }

    // 6. Iniciar Sessão
    if (session_status() === PHP_SESSION_NONE) { session_start(); }

    $_SESSION['user_id'] = $localUser['id'];
    $_SESSION['user_email'] = $localUser['email'];
    $_SESSION['user_name'] = $localUser['nome'];
    $_SESSION['user_level'] = $localUser['nivel_acesso'];
    $_SESSION['sso_authenticated'] = true;

    header("Location: index.php");
    exit();

} catch (Exception $e) {
    die("Erro interno: " . $e->getMessage());
}
