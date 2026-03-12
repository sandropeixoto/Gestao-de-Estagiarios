<?php
require_once __DIR__ . '/../../src/Models/Student.php';
require_once __DIR__ . '/../../config/database.php';
use App\Models\Student;

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: index.php?status=error&message=ID não fornecido.');
    exit;
}

$studentModel = new Student();
$estudante = $studentModel->find($id);

if (!$estudante) {
    header('Location: index.php?status=error&message=Estudante não encontrado.');
    exit;
}

$db = Database::getConnection();
$institutions = $db->query("SELECT id, razao_social FROM institutions ORDER BY razao_social")->fetchAll();
$niveis = $db->query("SELECT id, descricao FROM niveis_escolaridade ORDER BY descricao")->fetchAll();

require_once __DIR__ . '/../../includes/header.php';
?>

<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="bg-blue-600 px-8 py-6">
            <h2 class="text-2xl font-bold text-white flex items-center">
                <i class="fas fa-edit mr-3"></i> Editar Estudante: <?= htmlspecialchars($estudante['nome']) ?>
            </h2>
        </div>
        
        <form action="update.php" method="POST" class="p-8 space-y-6">
            <input type="hidden" name="id" value="<?= $estudante['id'] ?>">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700">Nome Completo</label>
                    <input type="text" name="nome" value="<?= htmlspecialchars($estudante['nome']) ?>" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700">CPF</label>
                    <input type="text" name="cpf" value="<?= htmlspecialchars($estudante['cpf']) ?>" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700">Instituição de Ensino</label>
                    <select name="institution_id" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 outline-none">
                        <?php foreach($institutions as $inst): ?>
                            <option value="<?= $inst['id'] ?>" <?= $inst['id'] == $estudante['institution_id'] ? 'selected' : '' ?>><?= $inst['razao_social'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700">Nível de Escolaridade</label>
                    <div class="flex space-x-4 mt-2">
                        <?php foreach($niveis as $nivel): ?>
                            <label class="flex items-center space-x-2">
                                <input type="radio" name="nivel_escolaridade_id" value="<?= $nivel['id'] ?>" <?= $nivel['id'] == $estudante['nivel_escolaridade_id'] ? 'checked' : '' ?> class="text-blue-600 focus:ring-blue-500">
                                <span class="text-sm text-gray-600"><?= $nivel['descricao'] ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700">Curso</label>
                    <input type="text" name="curso" value="<?= htmlspecialchars($estudante['curso']) ?>" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700">Semestre Atual</label>
                    <input type="number" name="semestre" value="<?= $estudante['semestre'] ?>" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
            </div>

            <div class="pt-6 border-t border-gray-100 flex justify-end space-x-4">
                <a href="index.php" class="px-6 py-2.5 rounded-lg text-gray-600 hover:bg-gray-100 transition-all font-medium">Cancelar</a>
                <button type="submit" class="px-8 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow-lg font-bold">Salvar Alterações</button>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
