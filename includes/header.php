<?php
require_once __DIR__ . '/auth_check.php';
// Detecção dinâmica da URL base
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];
$scriptName = $_SERVER['SCRIPT_NAME']; 

$basePath = str_replace('\\', '/', dirname(__DIR__));
$serverRoot = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']);
$relativeUrlPath = str_replace($serverRoot, '', $basePath);
$baseUrl = $protocol . "://" . $host . rtrim($relativeUrlPath, '/') . "/";

// Lógica para detectar página ativa
$currentPath = $_SERVER['REQUEST_NAME'] ?? $_SERVER['PHP_SELF'];
function isActive($path, $currentPath) {
    return strpos($currentPath, $path) !== false ? 'bg-slate-800 text-white border-l-4 border-accent' : 'text-gray-400 hover:bg-slate-800 hover:text-white border-l-4 border-transparent';
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EstagiárioPlus - Gestão Inteligente</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1e40af',
                        secondary: '#1e293b',
                        accent: '#3b82f6'
                    }
                }
            }
        }

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('main-content');
            const labels = document.querySelectorAll('.sidebar-label');
            
            sidebar.classList.toggle('w-64');
            sidebar.classList.toggle('w-20');
            content.classList.toggle('ml-64');
            content.classList.toggle('ml-20');
            
            labels.forEach(label => label.classList.toggle('hidden'));
        }

        function toggleUserMenu() {
            document.getElementById('user-menu').classList.toggle('hidden');
        }
    </script>
    <style>
        .sidebar-transition { transition: width 0.3s ease; }
        .content-transition { transition: margin-left 0.3s ease; }
    </style>
</head>
<body class="bg-gray-50 flex min-h-screen">
    <!-- Sidebar -->
    <aside id="sidebar" class="sidebar-transition fixed inset-y-0 left-0 bg-secondary w-64 z-50 shadow-2xl overflow-hidden">
        <div class="flex flex-col h-full">
            <!-- Brand -->
            <div class="h-16 flex items-center px-6 bg-slate-900 text-white">
                <i class="fas fa-graduation-cap text-2xl text-accent"></i>
                <span class="sidebar-label ml-3 font-bold text-lg whitespace-nowrap">EstagiárioPlus</span>
            </div>

            <!-- Navigation -->
            <nav class="flex-grow py-6 space-y-1">
                <a href="<?= $baseUrl ?>index.php" class="flex items-center px-6 py-3 transition-all <?= (basename($currentPath) == 'index.php' && strpos($currentPath, 'modules') === false) ? 'bg-slate-800 text-white border-l-4 border-accent' : 'text-gray-400 hover:bg-slate-800 hover:text-white border-l-4 border-transparent' ?>">
                    <i class="fas fa-th-large w-6 text-center"></i>
                    <span class="sidebar-label ml-3 font-medium">Dashboard</span>
                </a>
                <a href="<?= $baseUrl ?>modules/estudantes/index.php" class="flex items-center px-6 py-3 transition-all <?= isActive('modules/estudantes/', $currentPath) ?>">
                    <i class="fas fa-user-graduate w-6 text-center"></i>
                    <span class="sidebar-label ml-3 font-medium">Estudantes</span>
                </a>
                <a href="<?= $baseUrl ?>modules/instituicoes/index.php" class="flex items-center px-6 py-3 transition-all <?= isActive('modules/instituicoes/', $currentPath) ?>">
                    <i class="fas fa-university w-6 text-center"></i>
                    <span class="sidebar-label ml-3 font-medium">Instituições</span>
                </a>
                <a href="<?= $baseUrl ?>modules/supervisores/index.php" class="flex items-center px-6 py-3 transition-all <?= isActive('modules/supervisores/', $currentPath) ?>">
                    <i class="fas fa-user-tie w-6 text-center"></i>
                    <span class="sidebar-label ml-3 font-medium">Supervisores</span>
                </a>
                <a href="<?= $baseUrl ?>modules/vagas/index.php" class="flex items-center px-6 py-3 transition-all <?= isActive('modules/vagas/', $currentPath) ?>">
                    <i class="fas fa-briefcase w-6 text-center"></i>
                    <span class="sidebar-label ml-3 font-medium">Vagas</span>
                </a>
                <a href="<?= $baseUrl ?>modules/contratos/index.php" class="flex items-center px-6 py-3 transition-all <?= isActive('modules/contratos/', $currentPath) ?>">
                    <i class="fas fa-file-contract w-6 text-center"></i>
                    <span class="sidebar-label ml-3 font-medium">Contratos</span>
                </a>
            </nav>

            <!-- Collapse Toggle -->
            <button onclick="toggleSidebar()" class="p-6 hover:bg-slate-800 border-t border-slate-700 text-left transition-all">
                <i class="fas fa-angle-double-left w-6"></i>
                <span class="sidebar-label ml-3 font-medium">Recolher Menu</span>
            </button>
        </div>
    </aside>

    <!-- Content Wrapper -->
    <div id="main-content" class="content-transition flex-grow ml-64 flex flex-col min-h-screen">
        <!-- Topbar -->
        <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-8 sticky top-0 z-40">
            <div class="flex items-center">
                <h2 class="text-gray-500 font-medium hidden md:block">Bem-vindo, <?= htmlspecialchars($userName) ?></h2>
            </div>

            <!-- Header Right Section -->
            <div class="flex items-center space-x-6">
                <!-- Notifications -->
                <div class="relative group cursor-pointer">
                    <i class="fas fa-bell text-gray-400 hover:text-primary text-xl"></i>
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] rounded-full w-4 h-4 flex items-center justify-center">3</span>
                </div>

                <!-- User Profile Dropdown -->
                <div class="relative">
                    <button onclick="toggleUserMenu()" class="flex items-center space-x-3 focus:outline-none">
                        <div class="text-right hidden sm:block">
                            <p class="text-sm font-bold text-gray-800 leading-tight"><?= htmlspecialchars($userName) ?></p>
                            <p class="text-xs text-gray-500"><?= $isAdmin ? 'Administrador' : 'Operador' ?></p>
                        </div>
                        <img src="https://ui-avatars.com/api/?name=<?= urlencode($userName) ?>&background=1e40af&color=fff" class="w-10 h-10 rounded-full border-2 border-gray-100 shadow-sm" alt="Avatar">
                        <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                    </button>

                    <!-- Dropdown Menu -->
                    <div id="user-menu" class="hidden absolute right-0 mt-3 w-48 bg-white rounded-xl shadow-2xl border border-gray-100 py-2 z-50">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center">
                            <i class="fas fa-user-circle mr-3 text-gray-400"></i> Meu Perfil
                        </a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center">
                            <i class="fas fa-cog mr-3 text-gray-400"></i> Configurações
                        </a>
                        <hr class="my-2 border-gray-100">
                        <a href="<?= $baseUrl ?>public/logout.php" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50 font-bold flex items-center">
                            <i class="fas fa-sign-out-alt mr-3"></i> Sair do Sistema
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Viewport -->
        <main class="p-8">
