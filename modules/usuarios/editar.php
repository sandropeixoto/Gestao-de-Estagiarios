<?php
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../src/Models/User.php';

use App\Models\User;

if (!canManageUsers()) { die("Acesso negado."); }

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
            
            <div class="space-y-4">
                <label class="text-sm font-bold text-gray-700 uppercase tracking-wider">Selecione o Nível de Acesso</label>
                
                <div class="grid grid-cols-1 gap-4">
                    <!-- Administrador -->
                    <label class="relative flex p-4 cursor-pointer rounded-xl border focus:outline-none transition-all hover:bg-gray-50 <?= $usuario['nivel_acesso'] == 1 ? 'border-purple-500 bg-purple-50' : 'border-gray-200' ?>">
                        <input type="radio" name="nivel_acesso" value="1" class="hidden" <?= $usuario['nivel_acesso'] == 1 ? 'checked' : '' ?>>
                        <div class="flex items-center">
                            <div class="p-2 bg-purple-100 text-purple-600 rounded-lg mr-4">
                                <i class="fas fa-crown text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-900">Administrador</p>
                                <p class="text-xs text-gray-500">Acesso total, gestão de usuários e configurações.</p>
                            </div>
                        </div>
                    </label>

                    <!-- Gestor -->
                    <label class="relative flex p-4 cursor-pointer rounded-xl border focus:outline-none transition-all hover:bg-gray-50 <?= $usuario['nivel_acesso'] == 2 ? 'border-blue-500 bg-blue-50' : 'border-gray-200' ?>">
                        <input type="radio" name="nivel_acesso" value="2" class="hidden" <?= $usuario['nivel_acesso'] == 2 ? 'checked' : '' ?>>
                        <div class="flex items-center">
                            <div class="p-2 bg-blue-100 text-blue-600 rounded-lg mr-4">
                                <i class="fas fa-user-tie text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-900">Gestor</p>
                                <p class="text-xs text-gray-500">Cadastro, alteração, exclusão e gestão de usuários.</p>
                            </div>
                        </div>
                    </label>

                    <!-- Consultor -->
                    <label class="relative flex p-4 cursor-pointer rounded-xl border focus:outline-none transition-all hover:bg-gray-50 <?= $usuario['nivel_acesso'] == 3 ? 'border-green-500 bg-green-50' : 'border-gray-200' ?>">
                        <input type="radio" name="nivel_acesso" value="3" class="hidden" <?= $usuario['nivel_acesso'] == 3 ? 'checked' : '' ?>>
                        <div class="flex items-center">
                            <div class="p-2 bg-green-100 text-green-600 rounded-lg mr-4">
                                <i class="fas fa-edit text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-900">Consultor</p>
                                <p class="text-xs text-gray-500">Permissão para cadastrar e alterar registros gerais.</p>
                            </div>
                        </div>
                    </label>
                </div>
            </div>

            <div class="flex items-center justify-between pt-4">
                <a href="index.php" class="text-gray-500 hover:text-gray-700 font-medium">
                    <i class="fas fa-arrow-left mr-1"></i> Voltar
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-bold shadow-lg transition-all transform hover:scale-105">
                    Atualizar Perfil
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Pequeno script para mudar a borda ao selecionar via rádio
    document.querySelectorAll('input[type="radio"]').forEach(radio => {
        radio.addEventListener('change', function() {
            document.querySelectorAll('label.relative').forEach(l => {
                l.classList.remove('border-purple-500', 'bg-purple-50', 'border-blue-500', 'bg-blue-50', 'border-green-500', 'bg-green-50');
                l.classList.add('border-gray-200');
            });
            const parent = this.closest('label');
            const color = this.value == '1' ? 'purple' : (this.value == '2' ? 'blue' : 'green');
            parent.classList.remove('border-gray-200');
            parent.classList.add(`border-${color}-500`, `bg-${color}-50`);
        });
    });
</script>
