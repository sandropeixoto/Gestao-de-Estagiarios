<?php
require_once __DIR__ . '/../../src/Models/Student.php';
use App\Models\Student;

$studentModel = new Student();
$estudantes = $studentModel->allWithDetails();

require_once __DIR__ . '/../../includes/header.php';
?>

<div class="mb-8 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Estudantes</h1>
        <p class="text-gray-500">Gestão de alunos e estagiários cadastrados.</p>
    </div>
    <a href="novo.php" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl shadow-lg transition-all flex items-center font-semibold">
        <i class="fas fa-plus mr-2"></i> Novo Estudante
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50 text-gray-500 text-xs font-bold uppercase tracking-wider">
            <tr>
                <th class="px-6 py-4 text-left">Nome / CPF</th>
                <th class="px-6 py-4 text-left">Nível / Curso</th>
                <th class="px-6 py-4 text-left">Instituição</th>
                <th class="px-6 py-4 text-center">Ações</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-100">
            <?php if (empty($estudantes)): ?>
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center text-gray-400">
                        <i class="fas fa-user-slash text-4xl mb-4 block"></i>
                        Nenhum estudante cadastrado.
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach($estudantes as $e): ?>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-bold text-gray-900"><?= htmlspecialchars($e['nome']) ?></div>
                            <div class="text-xs text-gray-500"><?= htmlspecialchars($e['cpf']) ?></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-semibold rounded-md bg-blue-50 text-blue-700 mb-1 inline-block"><?= htmlspecialchars($e['nivel']) ?></span>
                            <div class="text-sm text-gray-600"><?= htmlspecialchars($e['curso']) ?></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 font-medium">
                            <?= htmlspecialchars($e['instituicao']) ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <a href="editar.php?id=<?= $e['id'] ?>" class="text-blue-600 hover:text-blue-900 mx-2" title="Editar"><i class="fas fa-edit"></i></a>
                            <a href="delete.php?id=<?= $e['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir este estudante?')" class="text-red-600 hover:text-red-900 mx-2" title="Excluir"><i class="fas fa-trash-alt"></i></a>
                        </td>                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php
require_once __DIR__ . '/../../includes/footer.php';
?>
