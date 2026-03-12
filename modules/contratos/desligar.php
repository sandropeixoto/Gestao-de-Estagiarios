<?php
require_once __DIR__ . '/../../src/Models/Contract.php';
require_once __DIR__ . '/../../config/database.php';
use App\Models\Contract;

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: index.php?status=error&message=ID do contrato não fornecido.');
    exit;
}

$contractModel = new Contract();
$contrato = $contractModel->find($id);

if (!$contrato || $contrato['status'] == 'Encerrado') {
    header('Location: index.php?status=error&message=Contrato inválido ou já encerrado.');
    exit;
}

$db = Database::getConnection();
$motivos = $db->query("SELECT id, descricao FROM motivos_desligamento ORDER BY descricao")->fetchAll();

// Buscar nome do estagiário para exibição
$estudante = $db->prepare("SELECT nome FROM students WHERE id = ?");
$estudante->execute([$contrato['student_id']]);
$nomeEstudante = $estudante->fetchColumn();

require_once __DIR__ . '/../../includes/header.php';
?>

<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="bg-red-600 px-8 py-6 text-white">
            <h2 class="text-2xl font-bold flex items-center">
                <i class="fas fa-user-slash mr-3"></i> Desligamento de Estagiário
            </h2>
            <p class="text-red-100 mt-1">Registrar o encerramento do contrato de <strong><?= htmlspecialchars($nomeEstudante) ?></strong>.</p>
        </div>
        
        <form action="save_desligamento.php" method="POST" class="p-8 space-y-6">
            <input type="hidden" name="id" value="<?= $contrato['id'] ?>">
            <input type="hidden" name="position_id" value="<?= $contrato['position_id'] ?>">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700">Data de Desligamento</label>
                    <input type="date" name="data_desligamento" required value="<?= date('Y-m-d') ?>" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 outline-none">
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700">Motivo do Desligamento</label>
                    <select name="motivo_desligamento_id" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 outline-none">
                        <option value="">Selecione o motivo</option>
                        <?php foreach($motivos as $m): ?>
                            <option value="<?= $m['id'] ?>"><?= htmlspecialchars($m['descricao']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="p-4 bg-amber-50 border-l-4 border-amber-400 rounded-r-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-amber-400"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-amber-700">
                            Ao confirmar, o status do contrato será alterado para <strong>Encerrado</strong> e a vaga associada será marcada como <strong>Aberta</strong> novamente.
                        </p>
                    </div>
                </div>
            </div>

            <div class="pt-6 border-t border-gray-100 flex justify-end space-x-4">
                <a href="index.php" class="px-6 py-2.5 rounded-lg text-gray-600 hover:bg-gray-100 transition-all font-medium">Cancelar</a>
                <button type="submit" class="px-8 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-lg shadow-lg font-bold">Confirmar Desligamento</button>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
