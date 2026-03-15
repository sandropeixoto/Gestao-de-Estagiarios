<?php
/**
 * SSO Authentication Handler - GestorGov Integration
 * Orion Orchestrator: Validating HMAC-SHA256 signature and Provisioning JIT
 */

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/src/Models/User.php';

use App\Models\User;

// 1. Configuração do Segredo
$ssoSecret = getenv('SSO_SECRET_KEY');
if (!$ssoSecret) {
    die("Erro de Configuração: SSO_SECRET_KEY não definida no ambiente.");
}

// 2. Captura dos Parâmetros
$payloadBase64 = $_GET['sso_payload'] ?? null;
$signatureReceived = $_GET['sso_sig'] ?? null;

if (!$payloadBase64 || !$signatureReceived) {
    header("HTTP/1.1 401 Unauthorized");
    die("Acesso negado: Token SSO ausente ou incompleto.");
}

// 3. Validação da Assinatura (HMAC-SHA256)
$expectedSignature = hash_hmac('sha256', $payloadBase64, $ssoSecret);

if (!hash_equals($expectedSignature, $signatureReceived)) {
    header("HTTP/1.1 403 Forbidden");
    die("Acesso negado: Assinatura SSO inválida.");
}

// 4. Decodificação e Validação de Expiração
$userData = json_decode(base64_decode($payloadBase64), true);

if (!$userData || !isset($userData['exp'])) {
    die("Acesso negado: Payload SSO malformado.");
}

if (time() > $userData['exp']) {
    die("Acesso negado: Token SSO expirado.");
}

// 5. Provisionamento Just-in-Time (JIT) e Login
try {
    $userModel = new User();
    $localUser = $userModel->findOrCreateFromSSO($userData);

    // Iniciar Sessão Local PHP
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $_SESSION['user_id'] = $localUser['id'];
    $_SESSION['user_email'] = $localUser['email'];
    $_SESSION['user_name'] = $localUser['nome'];
    $_SESSION['user_level'] = $localUser['nivel_acesso'];
    $_SESSION['sso_authenticated'] = true;

    // Redirecionar para o dashboard principal
    header("Location: public/index.php");
    exit();

} catch (Exception $e) {
    die("Erro interno durante autenticação: " . $e->getMessage());
}
