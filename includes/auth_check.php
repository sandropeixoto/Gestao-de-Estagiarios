<?php
/**
 * Global Session Handler - GestorGov Protection
 * Orion Orchestrator: Enforcing SSO authentication across the system
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Bloquear acesso se não houver sessão SSO válida
if (!isset($_SESSION['sso_authenticated']) || $_SESSION['sso_authenticated'] !== true) {
    // Note: Em ambiente real, aqui redirecionaríamos para o Portal GestorGov
    // Para fins de desenvolvimento, vamos mostrar um erro amigável.
    die("<div style='font-family: sans-serif; text-align: center; padding: 50px;'>
            <h1>🚫 Acesso Negado</h1>
            <p>Este módulo exige autenticação através do <b>Portal GestorGov</b>.</p>
            <p>Por favor, acesse o portal e clique no ícone deste sistema.</p>
         </div>");
}

// User Variables for Frontend
$userName = $_SESSION['user_name'] ?? 'Usuário';
$userEmail = $_SESSION['user_email'] ?? '';
$userLevel = $_SESSION['user_level'] ?? 2;
$isAdmin = ($userLevel == 1);
