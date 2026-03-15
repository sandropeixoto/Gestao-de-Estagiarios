<?php
/**
 * SSO Authentication Handler - GestorGov Integration (Governance v3)
 * Orion Orchestrator: Super-Admin Bypass + Visitor Management
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

// 5. Política de Governança
try {
    $userModel = new User();
    
    // Identificar nível informado pelo Portal
    $portalLevelString = $userData['user_level'] ?? 'Visitante';
    $isPortalAdmin = (in_array($portalLevelString, ['Administrador', 'Admin']));

    // Busca usuário local
    $localUser = $userModel->findBySSO($userData['user_id'], $userData['user_email']);

    if (!$localUser) {
        // A. CASO ADMINISTRADOR: Bypass Total + Cadastro Automático
        if ($isPortalAdmin) {
            $userModel->createManual([
                'nome' => $userData['user_name'],
                'email' => $userData['user_email'],
                'sso_user_id' => $userData['user_id'],
                'nivel_acesso' => 1 // Administrador
            ]);
            $localUser = $userModel->findBySSO($userData['user_id'], $userData['user_email']);
        } 
        // B. CASO VISITANTE: Verificar se a chave está ligada
        else {
            $allowVisitors = $userModel->getSetting('allow_visitors');

            if ($allowVisitors === '1') {
                $localUser = [
                    'id' => 0,
                    'nome' => $userData['user_name'] . ' (Visitante)',
                    'email' => $userData['user_email'],
                    'nivel_acesso' => 4 // Nível Visitante (Apenas Visualização)
                ];
            } else {
                // Visitante Barrado: Mensagem solicitada pelo comandante
                die("<div style='font-family: sans-serif; text-align: center; padding: 50px; background: #f8fafc; height: 100vh;'>
                        <div style='max-width: 500px; margin: auto; background: white; padding: 40px; border-radius: 20px; shadow: 0 10px 15px rgba(0,0,0,0.1); border: 1px solid #e2e8f0;'>
                            <div style='font-size: 50px; margin-bottom: 20px;'>🔒</div>
                            <h1 style='color: #1e293b;'>Acesso Não Autorizado</h1>
                            <p style='color: #64748b; line-height: 1.6;'>Olá <b>{$userData['user_name']}</b>, você está autenticado no Portal GestorGov, mas este sistema exige um cadastro prévio realizado por um administrador.</p>
                            <p style='color: #64748b; margin-top: 20px;'>Por favor, entre em contato com o gestor do módulo de estagiários para solicitar sua liberação.</p>
                            <a href='#' onclick='window.history.back()' style='display: inline-block; margin-top: 30px; background: #3b82f6; color: white; padding: 12px 25px; border-radius: 10px; text-decoration: none; font-weight: bold;'>Voltar para o Portal</a>
                        </div>
                     </div>");
            }
        }
    } else {
        // Usuário Cadastrado: Atualizar acesso
        $userModel->update($localUser['id'], ['ultimo_acesso' => date('Y-m-d H:i:s')]);
    }

    // 6. Iniciar Sessão
    if (session_status() === PHP_SESSION_NONE) { session_start(); }

    $_SESSION['user_id'] = $localUser['id'];
    $_SESSION['user_email'] = $localUser['email'];
    $_SESSION['user_name'] = $localUser['nome'];
    $_SESSION['user_level'] = (int)$localUser['nivel_acesso'];
    $_SESSION['sso_authenticated'] = true;

    header("Location: index.php");
    exit();

} catch (Exception $e) {
    die("Erro interno: " . $e->getMessage());
}
