<?php
require_once __DIR__ . '/../../src/Models/Position.php';
use App\Models\Position;

$posModel = new Position();
$vagas = $posModel->allWithDetails();

require_once __DIR__ . '/../../includes/header.php';
?>

<div class="mb-8 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Vagas e Oportunidades</h1>
        <p class="text-gray-500">Controle de vagas abertas, ocupadas e suspensas.</p>
    </div>
    <a href="<?= $baseUrl ?>modules/vagas/novo.php" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl shadow-lg transition-all flex items-center font-semibold">
        <i class="fas fa-plus mr-2"></i> Nova Vaga
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50 text-gray-500 text-xs font-bold uppercase tracking-wider">
            <tr>
                <th class="px-6 py-4 text-left">Lotação / Unidade</th>
                <th class="px-6 py-4 text-center">Quantidade</th>
                <th class="px-6 py-4 text-center">Status</th>
                <th class="px-6 py-4 text-center">Ações</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-100">
            <?php if (empty($vagas)): ?>
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center text-gray-400">
                        <i class="fas fa-briefcase text-4xl mb-4 block"></i>
                        Nenhuma vaga registrada.
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach($vagas as $v): ?>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                            <?= htmlspecialchars($v['subunidade']) ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <div class="text-sm font-bold text-gray-900"><?= $v['quantidade'] ?> vaga(s)</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span class="px-2.5 py-1 text-xs font-bold rounded-full 
                                <?= $v['status'] == 'Aberta' ? 'bg-blue-100 text-blue-700' : ($v['status'] == 'Ocupada' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700') ?>">
                                <?= $v['status'] ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <a href="editar.php?id=<?= $v['id'] ?>" class="text-indigo-600 hover:text-indigo-900 mx-2"><i class="fas fa-edit"></i></a>
                            <a href="delete.php?id=<?= $v['id'] ?>" onclick="return confirm('Excluir esta vaga?')" class="text-red-600 hover:text-red-900 mx-2"><i class="fas fa-trash-alt"></i></a>
                        </td>                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php
require_once __DIR__ . '/../../includes/footer.php';
?>
