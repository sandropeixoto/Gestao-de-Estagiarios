<?php
require_once __DIR__ . '/../../src/Models/Supervisor.php';
require_once __DIR__ . '/../../config/database.php';
use App\Models\Supervisor;

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: index.php?status=error&message=ID não fornecido.');
    exit;
}

$supervisorModel = new Supervisor();
$supervisor = $supervisorModel->find($id);

if (!$supervisor) {
    header('Location: index.php?status=error&message=Supervisor não encontrado.');
    exit;
}

$db = Database::getConnection();
$lotacoes = $db->query("SELECT id, subunidade, municipio FROM lotacoes ORDER BY subunidade")->fetchAll();

require_once __DIR__ . '/../../includes/header.php';
?>

<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="bg-emerald-600 px-8 py-6 text-white">
            <h2 class="text-2xl font-bold flex items-center">
                <i class="fas fa-edit mr-3"></i> Editar Supervisor: <?= htmlspecialchars($supervisor['nome']) ?>
            </h2>
        </div>
        
        <form action="update.php" method="POST" class="p-8 space-y-6">
            <input type="hidden" name="id" value="<?= $supervisor['id'] ?>">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700">Nome Completo</label>
                    <input type="text" name="nome" value="<?= htmlspecialchars($supervisor['nome']) ?>" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700">Cargo / Função</label>
                    <input type="text" name="cargo" value="<?= htmlspecialchars($supervisor['cargo'] ?: '') ?>" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700">E-mail Corporativo</label>
                    <input type="email" name="email" value="<?= htmlspecialchars($supervisor['email'] ?: '') ?>" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700">Telefone / Ramal</label>
                    <input type="text" name="telefone_ramal" value="<?= htmlspecialchars($supervisor['telefone_ramal'] ?: '') ?>" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>
                <div class="md:col-span-2 space-y-2">
                    <label class="text-sm font-semibold text-gray-700">Lotação de Trabalho</label>
                    <select name="lotacao_id" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 outline-none">
                        <?php foreach($lotacoes as $l): ?>
                            <option value="<?= $l['id'] ?>" <?= $l['id'] == $supervisor['lotacao_id'] ? 'selected' : '' ?>><?= $l['subunidade'] ?> (<?= $l['municipio'] ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="pt-6 border-t border-gray-100 flex justify-end space-x-4">
                <a href="index.php" class="px-6 py-2.5 rounded-lg text-gray-600 hover:bg-gray-100 transition-all font-medium">Cancelar</a>
                <button type="submit" class="px-8 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg shadow-lg font-bold">Salvar Alterações</button>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
