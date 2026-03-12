<?php
require_once __DIR__ . '/../../src/Models/Student.php';
require_once __DIR__ . '/../../config/database.php';

$db = Database::getConnection();

// Buscar Instituições e Níveis para popular o formulário
$institutions = $db->query("SELECT id, razao_social FROM institutions ORDER BY razao_social")->fetchAll();
$niveis = $db->query("SELECT id, descricao FROM niveis_escolaridade ORDER BY descricao")->fetchAll();

require_once __DIR__ . '/../../includes/header.php';
?>

<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="bg-blue-600 px-8 py-6">
            <h2 class="text-2xl font-bold text-white flex items-center">
                <i class="fas fa-user-graduate mr-3"></i> Cadastro de Estudante
            </h2>
            <p class="text-blue-100 mt-1">Insira as informações acadêmicas e pessoais do novo estagiário.</p>
        </div>
        
        <form action="save.php" method="POST" class="p-8 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nome Completo -->
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700">Nome Completo</label>
                    <input type="text" name="nome" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all outline-none" placeholder="Ex: João Silva">
                </div>

                <!-- CPF -->
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700">CPF</label>
                    <input type="text" name="cpf" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all outline-none" placeholder="000.000.000-00">
                </div>

                <!-- Instituição de Ensino -->
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700">Instituição de Ensino</label>
                    <select name="institution_id" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="">Selecione uma Instituição</option>
                        <?php foreach($institutions as $inst): ?>
                            <option value="<?= $inst['id'] ?>"><?= $inst['razao_social'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Nível de Escolaridade -->
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700">Nível de Escolaridade</label>
                    <div class="flex space-x-4 mt-2">
                        <?php foreach($niveis as $nivel): ?>
                            <label class="flex items-center space-x-2 cursor-pointer group">
                                <input type="radio" name="nivel_escolaridade_id" value="<?= $nivel['id'] ?>" class="text-blue-600 focus:ring-blue-500">
                                <span class="text-sm text-gray-600 group-hover:text-blue-600 transition-colors"><?= $nivel['descricao'] ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Curso -->
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700">Curso</label>
                    <input type="text" name="curso" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Ex: Engenharia de Software">
                </div>

                <!-- Semestre -->
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700">Semestre Atual</label>
                    <input type="number" name="semestre" min="1" max="12" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                <!-- Previsão Formatura -->
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700">Previsão de Formatura</label>
                    <input type="date" name="previsao_formatura" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
            </div>

            <div class="pt-6 border-t border-gray-100 flex justify-end space-x-4">
                <a href="index.php" class="px-6 py-2.5 rounded-lg text-gray-600 hover:bg-gray-100 transition-all font-medium">Cancelar</a>
                <button type="submit" class="px-8 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow-lg shadow-blue-200 transition-all font-bold">Salvar Estudante</button>
            </div>
        </form>
    </div>
</div>

<?php
require_once __DIR__ . '/../../includes/footer.php';
?>
