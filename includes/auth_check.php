<?php
/**
 * Global Session Handler - GestorGov Protection (Governance v3)
 * Orion Orchestrator: Defining Roles and Permissions
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Bloqueio Fundamental
if (!isset($_SESSION['sso_authenticated']) || $_SESSION['sso_authenticated'] !== true) {
    die("<div style='font-family: sans-serif; text-align: center; padding: 50px;'>
            <h1>🚫 Acesso Negado</h1>
            <p>Este módulo exige autenticação através do <b>Portal GestorGov</b>.</p>
            <p>Por favor, acesse o portal e clique no ícone deste sistema.</p>
         </div>");
}

// 2. Definição de Variáveis de Identidade
$user_id   = $_SESSION['user_id'] ?? 0;
$userName  = $_SESSION['user_name'] ?? 'Usuário';
$userEmail = $_SESSION['user_email'] ?? '';
$userLevel = (int)($_SESSION['user_level'] ?? 4); // Default: Visitante (4)

/**
 * NÍVEIS DE ACESSO:
 * 1 - Administrador: Acesso Total + Gestão de Usuários
 * 2 - Gestor: Cadastro/Alteração/Exclusão + Gestão de Usuários
 * 3 - Consultor: Cadastro e Alteração (Módulos Gerais)
 * 4 - Visitante: Apenas Visualização (Se permitido)
 */

$isAdmin     = ($userLevel === 1);
$isGestor    = ($userLevel === 2);
$isConsultor = ($userLevel === 3);
$isVisitante = ($userLevel === 4);

// 3. Trava de Segurança: Visitante Bloqueado (Se a chave estiver OFF)
// Nota: A lógica de permitir/bloquear o visitante já foi processada no auth_sso.php
// Mas garantimos aqui que um visitante não faça ações de escrita se necessário.

function canEdit() {
    global $userLevel;
    return $userLevel <= 3; // Admin, Gestor e Consultor podem cadastrar/alterar
}

function canDelete() {
    global $userLevel;
    return $userLevel <= 2; // Apenas Admin e Gestor podem excluir
}

function canManageUsers() {
    global $userLevel;
    return $userLevel <= 2; // Apenas Admin e Gestor gerenciam usuários
}
