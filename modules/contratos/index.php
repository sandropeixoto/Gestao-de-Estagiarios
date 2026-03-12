<?php
require_once __DIR__ . '/../../src/Models/Contract.php';
use App\Models\Contract;

$contractModel = new Contract();
$contratos = $contractModel->allWithDetails();

require_once __DIR__ . '/../../includes/header.php';
?>

<div class="mb-8 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Contratos de Estágio</h1>
        <p class="text-gray-500">Acompanhamento de vigência, bolsas e desligamentos.</p>
    </div>
    <a href="<?= $baseUrl ?>modules/contratos/novo.php" class="bg-slate-700 hover:bg-slate-800 text-white px-5 py-2.5 rounded-xl shadow-lg transition-all flex items-center font-semibold">
        <i class="fas fa-file-contract mr-2"></i> Novo Contrato
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50 text-gray-500 text-xs font-bold uppercase tracking-wider">
            <tr>
                <th class="px-6 py-4 text-left">Estagiário / Instituição</th>
                <th class="px-6 py-4 text-left">Vigência / Carga H.</th>
                <th class="px-6 py-4 text-left">Valores (Bolsa/Aux)</th>
                <th class="px-6 py-4 text-center">Status</th>
                <th class="px-6 py-4 text-center">Ações</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-100">
            <?php if (empty($contratos)): ?>
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                        <i class="fas fa-file-signature text-4xl mb-4 block"></i>
                        Nenhum contrato ativo ou encerrado.
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach($contratos as $c): ?>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-bold text-gray-900"><?= htmlspecialchars($c['estagiario']) ?></div>
                            <div class="text-xs text-gray-500"><?= htmlspecialchars($c['instituicao']) ?></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-700">
                                <?= date('d/m/Y', strtotime($c['data_inicio'])) ?> - <?= date('d/m/Y', strtotime($c['data_fim'])) ?>
                            </div>
                            <div class="text-xs font-bold text-slate-500 uppercase"><?= htmlspecialchars($c['carga_horaria']) ?></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-bold text-gray-900">R$ <?= number_format($c['valor_bolsa'], 2, ',', '.') ?></div>
                            <div class="text-xs text-gray-500">Aux: R$ <?= number_format($c['valor_transporte'], 2, ',', '.') ?></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span class="px-2.5 py-1 text-xs font-bold rounded-full 
                                <?= $c['status'] == 'Ativo' ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-700' ?>">
                                <?= $c['status'] ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <button class="text-slate-600 hover:text-slate-900 mx-2" title="Visualizar/Imprimir"><i class="fas fa-print"></i></button>
                            <button class="text-red-600 hover:text-red-900 mx-2" title="Encerrar Contrato"><i class="fas fa-user-slash"></i></button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php
require_once __DIR__ . '/../../includes/footer.php';
?>
