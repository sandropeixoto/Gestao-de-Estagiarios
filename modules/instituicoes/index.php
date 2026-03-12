<?php
require_once __DIR__ . '/../../src/Models/Institution.php';
use App\Models\Institution;

$instModel = new Institution();
$instituicoes = $instModel->all();

require_once __DIR__ . '/../../includes/header.php';
?>

<div class="mb-8 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Instituições de Ensino</h1>
        <p class="text-gray-500">Convênios e contatos das instituições parceiras.</p>
    </div>
    <a href="novo.php" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl shadow-lg transition-all flex items-center font-semibold">
        <i class="fas fa-plus mr-2"></i> Nova Instituição
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50 text-gray-500 text-xs font-bold uppercase tracking-wider">
            <tr>
                <th class="px-6 py-4 text-left">Razão Social / CNPJ</th>
                <th class="px-6 py-4 text-left">Diretor / Coordenador</th>
                <th class="px-6 py-4 text-center">Status</th>
                <th class="px-6 py-4 text-center">Ações</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-100">
            <?php if (empty($instituicoes)): ?>
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center text-gray-400">
                        <i class="fas fa-university text-4xl mb-4 block"></i>
                        Nenhuma instituição cadastrada.
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach($instituicoes as $i): ?>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-bold text-gray-900"><?= htmlspecialchars($i['razao_social']) ?></div>
                            <div class="text-xs text-gray-500"><?= htmlspecialchars($i['cnpj']) ?></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-700 font-medium">Dir: <?= htmlspecialchars($i['nome_diretor'] ?: 'N/A') ?></div>
                            <div class="text-xs text-gray-500">Coord: <?= htmlspecialchars($i['nome_coordenador'] ?: 'N/A') ?></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span class="px-2.5 py-1 text-xs font-bold rounded-full <?= $i['status_convenio'] == 'Ativo' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>">
                                <?= $i['status_convenio'] ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <a href="editar.php?id=<?= $i['id'] ?>" class="text-blue-600 hover:text-blue-900 mx-2"><i class="fas fa-edit"></i></a>
                            <a href="delete.php?id=<?= $i['id'] ?>" onclick="return confirm('Excluir esta instituição?')" class="text-red-600 hover:text-red-900 mx-2"><i class="fas fa-trash-alt"></i></a>
                        </td>                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php
require_once __DIR__ . '/../../includes/footer.php';
?>
