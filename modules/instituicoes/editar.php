<?php
require_once __DIR__ . '/../../src/Models/Institution.php';
use App\Models\Institution;

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: index.php?status=error&message=ID não fornecido.');
    exit;
}

$instModel = new Institution();
$instituicao = $instModel->find($id);

if (!$instituicao) {
    header('Location: index.php?status=error&message=Instituição não encontrada.');
    exit;
}

require_once __DIR__ . '/../../includes/header.php';
?>

<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="bg-blue-600 px-8 py-6 text-white">
            <h2 class="text-2xl font-bold flex items-center">
                <i class="fas fa-edit mr-3"></i> Editar Instituição: <?= htmlspecialchars($instituicao['razao_social']) ?>
            </h2>
        </div>
        
        <form action="update.php" method="POST" class="p-8 space-y-8">
            <input type="hidden" name="id" value="<?= $instituicao['id'] ?>">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700">Razão Social</label>
                    <input type="text" name="razao_social" value="<?= htmlspecialchars($instituicao['razao_social']) ?>" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700">CNPJ</label>
                    <input type="text" name="cnpj" value="<?= htmlspecialchars($instituicao['cnpj']) ?>" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
            </div>

            <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2 text-sm font-bold text-gray-500 uppercase tracking-wider mb-2">Contatos de Gestão (Opcional)</div>
                
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700">Nome do Diretor</label>
                    <input type="text" name="nome_diretor" value="<?= htmlspecialchars($instituicao['nome_diretor'] ?: '') ?>" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700">E-mail do Diretor</label>
                    <input type="email" name="email_diretor" value="<?= htmlspecialchars($instituicao['email_diretor'] ?: '') ?>" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700">Nome do Coordenador</label>
                    <input type="text" name="nome_coordenador" value="<?= htmlspecialchars($instituicao['nome_coordenador'] ?: '') ?>" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700">E-mail do Coordenador</label>
                    <input type="email" name="email_coordenador" value="<?= htmlspecialchars($instituicao['email_coordenador'] ?: '') ?>" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-sm font-semibold text-gray-700">Status do Convênio</label>
                <select name="status_convenio" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 outline-none">
                    <option value="Ativo" <?= $instituicao['status_convenio'] == 'Ativo' ? 'selected' : '' ?>>Ativo</option>
                    <option value="Inativo" <?= $instituicao['status_convenio'] == 'Inativo' ? 'selected' : '' ?>>Inativo</option>
                </select>
            </div>

            <div class="pt-6 border-t border-gray-100 flex justify-end space-x-4">
                <a href="index.php" class="px-6 py-2.5 rounded-lg text-gray-600 hover:bg-gray-100 transition-all font-medium">Cancelar</a>
                <button type="submit" class="px-8 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow-lg font-bold">Salvar Alterações</button>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
