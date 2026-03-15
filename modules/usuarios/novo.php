<?php
require_once __DIR__ . '/../../includes/header.php';

if ($userLevel > 2) { die("Acesso restrito."); }
?>

<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="bg-blue-600 px-8 py-6 text-white text-center">
            <h2 class="text-2xl font-bold flex justify-center items-center">
                <i class="fas fa-user-plus mr-3"></i> Cadastrar Novo Usuário
            </h2>
            <p class="text-blue-100 mt-1">Autorize o acesso de um usuário do Portal GestorGov.</p>
        </div>
        
        <form action="save.php" method="POST" class="p-8 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-700 uppercase tracking-wider">Nome Completo</label>
                    <input type="text" name="nome" required placeholder="Ex: João Silva" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-700 uppercase tracking-wider">E-mail (Portal)</label>
                    <input type="email" name="email" required placeholder="email@sefa.pa.gov.br" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-700 uppercase tracking-wider">ID Usuário Portal (Opcional)</label>
                    <input type="number" name="sso_user_id" placeholder="ID no GestorGov" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-700 uppercase tracking-wider">Nível de Acesso</label>
                    <select name="nivel_acesso" required class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                        <option value="1">1 - Administrador (Total)</option>
                        <option value="2">2 - Gestor (Usuários/Relatórios)</option>
                        <option value="3" selected>3 - Consultor (Visualização)</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center justify-between pt-4">
                <a href="index.php" class="text-gray-500 hover:text-gray-700 font-medium">
                    <i class="fas fa-arrow-left mr-1"></i> Voltar
                </a>
                <button type="submit" name="action" value="create" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-bold shadow-lg transition-all transform hover:scale-105">
                    Cadastrar Usuário
                </button>
            </div>
        </form>
    </div>
</div>
