<?php
require_once __DIR__ . '/../../src/Models/Position.php';
require_once __DIR__ . '/../../config/database.php';
use App\Models\Position;

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: index.php?status=error&message=ID não fornecido.');
    exit;
}

$posModel = new Position();
$vaga = $posModel->find($id);

if (!$vaga) {
    header('Location: index.php?status=error&message=Vaga não encontrada.');
    exit;
}

$db = Database::getConnection();

// Buscar informações da lotação atual
$lotacaoAtual = $db->prepare("SELECT unidade, subunidade FROM lotacoes WHERE id = ?");
$lotacaoAtual->execute([$vaga['lotacao_id']]);
$infoLotacao = $lotacaoAtual->fetch();

$unidades = $db->query("SELECT DISTINCT unidade FROM lotacoes WHERE unidade IS NOT NULL AND unidade != '' ORDER BY unidade")->fetchAll();
$todasLotacoes = $db->query("SELECT id, subunidade, unidade FROM lotacoes ORDER BY subunidade")->fetchAll();
$niveis = $db->query("SELECT id, descricao FROM niveis_escolaridade")->fetchAll();
$cargas = $db->query("SELECT id, descricao FROM cargas_horarias")->fetchAll();

require_once __DIR__ . '/../../includes/header.php';
?>

<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="bg-indigo-600 px-8 py-6 text-white">
            <h2 class="text-2xl font-bold flex items-center">
                <i class="fas fa-edit mr-3"></i> Editar Vaga
            </h2>
        </div>
        
        <form action="update.php" method="POST" class="p-8 space-y-6">
            <input type="hidden" name="id" value="<?= $vaga['id'] ?>">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Seleção de Lotação em Dois Níveis -->
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700">Unidade</label>
                    <select id="unidade_select" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 outline-none" onchange="filtrarSubunidades()">
                        <option value="">Selecione a Unidade</option>
                        <?php foreach($unidades as $u): ?>
                            <option value="<?= htmlspecialchars($u['unidade']) ?>" <?= (isset($infoLotacao['unidade']) && $infoLotacao['unidade'] == $u['unidade']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($u['unidade']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700">Subunidade / Lotação</label>
                    <select id="subunidade_select" name="lotacao_id" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 outline-none">
                        <option value="">Selecione primeiro a unidade</option>
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700">Quantidade de Vagas</label>
                    <input type="number" name="quantidade" value="<?= $vaga['quantidade'] ?>" min="1" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700">Nível de Escolaridade</label>
                    <select name="nivel_escolaridade_id" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 outline-none">
                        <?php foreach($niveis as $n): ?>
                            <option value="<?= $n['id'] ?>" <?= $n['id'] == $vaga['nivel_escolaridade_id'] ? 'selected' : '' ?>><?= $n['descricao'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700">Carga Horária</label>
                    <select name="carga_horaria_id" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 outline-none">
                        <?php foreach($cargas as $c): ?>
                            <option value="<?= $c['id'] ?>" <?= $c['id'] == $vaga['carga_horaria_id'] ? 'selected' : '' ?>><?= $c['descricao'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700">Remuneração Base (R$)</label>
                    <input type="number" step="0.01" name="remuneracao_base" value="<?= $vaga['remuneracao_base'] ?>" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700">Status</label>
                    <select name="status" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 outline-none">
                        <option value="Aberta" <?= $vaga['status'] == 'Aberta' ? 'selected' : '' ?>>Aberta</option>
                        <option value="Ocupada" <?= $vaga['status'] == 'Ocupada' ? 'selected' : '' ?>>Ocupada</option>
                        <option value="Suspensa" <?= $vaga['status'] == 'Suspensa' ? 'selected' : '' ?>>Suspensa</option>
                    </select>
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-sm font-semibold text-gray-700">Requisitos / Observações</label>
                <textarea name="requisitos" rows="4" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 outline-none"><?= htmlspecialchars($vaga['requisitos'] ?: '') ?></textarea>
            </div>

            <div class="pt-6 border-t border-gray-100 flex justify-end space-x-4">
                <a href="index.php" class="px-6 py-2.5 rounded-lg text-gray-600 hover:bg-gray-100 transition-all font-medium">Cancelar</a>
                <button type="submit" class="px-8 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg shadow-lg font-bold">Salvar Alterações</button>
            </div>
        </form>
    </div>
</div>

<script>
    const lotacoes = <?= json_encode($todasLotacoes) ?>;
    const lotacaoIdAtual = <?= $vaga['lotacao_id'] ?: 'null' ?>;

    function filtrarSubunidades(selecionarAtual = false) {
        const unidadeSelecionada = document.getElementById('unidade_select').value;
        const subunidadeSelect = document.getElementById('subunidade_select');
        
        subunidadeSelect.innerHTML = '<option value="">Selecione a Subunidade</option>';
        
        if (unidadeSelecionada) {
            const filtradas = lotacoes.filter(l => l.unidade === unidadeSelecionada);
            
            filtradas.forEach(l => {
                const option = document.createElement('option');
                option.value = l.id;
                option.textContent = l.subunidade;
                if (selecionarAtual && l.id == lotacaoIdAtual) {
                    option.selected = true;
                }
                subunidadeSelect.appendChild(option);
            });
            
            subunidadeSelect.disabled = false;
        } else {
            subunidadeSelect.disabled = true;
            subunidadeSelect.innerHTML = '<option value="">Selecione primeiro a unidade</option>';
        }
    }

    window.onload = function() {
        if (document.getElementById('unidade_select').value) {
            filtrarSubunidades(true);
        }
    };
</script>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
