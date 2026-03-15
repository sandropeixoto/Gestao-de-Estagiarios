<?php
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../src/Models/User.php';

use App\Models\User;

if (!canManageUsers()) { die("Acesso restrito."); }

$userModel = new User();

// Processar Toggle de Visitantes
if (isset($_POST['toggle_visitors'])) {
    $newValue = ($_POST['current_value'] == '1') ? '0' : '1';
    $userModel->updateSetting('allow_visitors', $newValue);
    header("Location: index.php?status=success&message=Política de visitantes atualizada.");
    exit;
}

$usuarios = $userModel->all();
$allowVisitors = $userModel->getSetting('allow_visitors');
?>

<div class="mb-8 flex flex-col md:flex-row md:items-end md:justify-between gap-4">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Gestão de Usuários</h1>
        <p class="text-gray-500 mt-1">Controle de acesso e permissões do sistema.</p>
    </div>
    
    <!-- Chave Liga/Desliga Visitantes -->
    <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
        <div class="text-right">
            <span class="text-sm font-bold text-gray-700 uppercase block leading-none">Acesso Visitantes</span>
            <span class="text-[10px] text-gray-400">Usuários não cadastrados entram como visualizadores</span>
        </div>
        <form method="POST" class="flex items-center">
            <input type="hidden" name="toggle_visitors" value="1">
            <input type="hidden" name="current_value" value="<?= $allowVisitors ?>">
            <button type="submit" class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none <?= $allowVisitors == '1' ? 'bg-green-500' : 'bg-gray-300' ?>">
                <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform <?= $allowVisitors == '1' ? 'translate-x-6' : 'translate-x-1' ?>"></span>
            </button>
            <span class="ml-2 text-xs font-bold <?= $allowVisitors == '1' ? 'text-green-600' : 'text-gray-400' ?>">
                <?= $allowVisitors == '1' ? 'ATIVO' : 'BLOQUEADO' ?>
            </span>
        </form>
    </div>

    <a href="novo.php" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-bold shadow-lg transition-all flex items-center transform hover:scale-105">
        <i class="fas fa-user-plus mr-2"></i> Novo Usuário
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Usuário</th>
                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">E-mail</th>
                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Perfil</th>
                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Último Acesso</th>
                <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Ações</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <?php foreach($usuarios as $u): ?>
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                        <img src="https://ui-avatars.com/api/?name=<?= urlencode($u['nome']) ?>&background=random" class="w-8 h-8 rounded-full mr-3">
                        <div class="text-sm font-bold text-gray-900"><?= htmlspecialchars($u['nome']) ?></div>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    <?= htmlspecialchars($u['email']) ?>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <?php 
                        $badgeClass = 'bg-gray-100 text-gray-800';
                        $label = 'Consultor';
                        if ($u['nivel_acesso'] == 1) { $badgeClass = 'bg-purple-100 text-purple-800'; $label = 'Administrador'; }
                        if ($u['nivel_acesso'] == 2) { $badgeClass = 'bg-blue-100 text-blue-800'; $label = 'Gestor'; }
                        if ($u['nivel_acesso'] == 3) { $badgeClass = 'bg-green-100 text-green-800'; $label = 'Consultor'; }
                        if ($u['nivel_acesso'] == 4) { $badgeClass = 'bg-orange-100 text-orange-800'; $label = 'Visitante'; }
                    ?>
                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full <?= $badgeClass ?>">
                        <?= $label ?>
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    <?= $u['ultimo_acesso'] ? date('d/m/Y H:i', strtotime($u['ultimo_acesso'])) : 'Nunca' ?>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <a href="editar.php?id=<?= $u['id'] ?>" class="text-blue-600 hover:text-blue-900 bg-blue-50 p-2 rounded-lg transition-colors"><i class="fas fa-user-edit"></i> Alterar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
