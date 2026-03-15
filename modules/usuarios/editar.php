<?php
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../src/Models/User.php';

use App\Models\User;

if ($userLevel > 2) { die("Acesso negado."); }

$userModel = new User();
$usuario = $userModel->find($_GET['id']);

if (!$usuario) { die("Usuário não encontrado."); }
?>

<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="bg-slate-700 px-8 py-6 text-white text-center">
            <h2 class="text-2xl font-bold flex justify-center items-center">
                <i class="fas fa-user-shield mr-3"></i> Alterar Perfil de Acesso
            </h2>
            <p class="text-slate-300 mt-1"><?= htmlspecialchars($usuario['nome']) ?></p>
        </div>
        
        <form action="save.php" method="POST" class="p-8 space-y-6">
            <input type="hidden" name="id" value="<?= $usuario['id'] ?>">
            <input type="hidden" name="action" value="update">
            
            <div class="space-y-2">
                <label class="text-sm font-bold text-gray-700 uppercase tracking-wider">Nível de Acesso</label>
                <select name="nivel_acesso" required class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-slate-500 outline-none transition-all">
                    <option value="1" <?= $usuario['nivel_acesso'] == 1 ? 'selected' : '' ?>>1 - Administrador (Total)</option>
                    <option value="2" <?= $usuario['nivel_acesso'] == 2 ? 'selected' : '' ?>>2 - Gestor (Usuários/Relatórios)</option>
                    <option value="3" <?= $usuario['nivel_acesso'] == 3 ? 'selected' : '' ?>>3 - Consultor (Visualização)</option>
                </select>
                <p class="text-xs text-gray-500 italic">O perfil define as permissões de visibilidade e escrita no sistema.</p>
            </div>

            <div class="flex items-center justify-between pt-4">
                <a href="index.php" class="text-gray-500 hover:text-gray-700 font-medium">
                    <i class="fas fa-arrow-left mr-1"></i> Voltar
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-bold shadow-lg transition-all transform hover:scale-105">
                    Salvar Alterações
                </button>
            </div>
        </form>
    </div>
</div>
