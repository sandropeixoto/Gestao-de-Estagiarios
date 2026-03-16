<?php
require_once __DIR__ . '/../../config/database.php';
$db = Database::getConnection();

// Buscar dados para as seleções
$estudantes = $db->query("SELECT id, nome FROM students ORDER BY nome")->fetchAll();
$instituicoes = $db->query("SELECT id, razao_social FROM institutions WHERE status_convenio = 'Ativo' ORDER BY razao_social")->fetchAll();
$supervisores = $db->query("SELECT id, nome FROM supervisors ORDER BY nome")->fetchAll();
$vagas = $db->query("SELECT p.id, l.subunidade 
                     FROM positions p 
                     JOIN lotacoes l ON p.lotacao_id = l.id 
                     WHERE p.status = 'Aberta'")->fetchAll();
$cargas = $db->query("SELECT id, descricao FROM cargas_horarias")->fetchAll();
$niveis = $db->query("SELECT id, descricao FROM niveis_escolaridade")->fetchAll();

require_once __DIR__ . '/../../includes/header.php';
?>

<div class="max-w-5xl mx-auto">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="bg-slate-700 px-8 py-6 text-white text-center">
            <h2 class="text-2xl font-bold flex justify-center items-center">
                <i class="fas fa-file-signature mr-3"></i> Formalização de Contrato
            </h2>
            <p class="text-slate-300 mt-1">Vincule o estagiário à vaga e defina as condições do estágio.</p>
        </div>
        
        <form action="save.php" method="POST" class="p-8 space-y-8">
            <!-- Seção 1: Partes do Contrato -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-4">
                    <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wider border-b pb-2">Partes Envolvidas</h3>
                    
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Estagiário</label>
                        <select name="student_id" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-slate-500 outline-none">
                            <option value="">Selecione o Aluno</option>
                            <?php foreach($estudantes as $e): ?>
                                <option value="<?= $e['id'] ?>"><?= htmlspecialchars($e['nome']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Instituição de Ensino</label>
                        <select name="institution_id" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-slate-500 outline-none">
                            <option value="">Selecione a Instituição</option>
                            <?php foreach($instituicoes as $i): ?>
                                <option value="<?= $i['id'] ?>"><?= htmlspecialchars($i['razao_social']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="space-y-4">
                    <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wider border-b pb-2">Alocação</h3>
                    
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Vaga de Origem</label>
                        <select name="position_id" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-slate-500 outline-none">
                            <option value="">Selecione a Vaga Aberta</option>
                            <?php foreach($vagas as $v): ?>
                                <option value="<?= $v['id'] ?>"><?= htmlspecialchars($v['subunidade']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Supervisor Responsável</label>
                        <select name="supervisor_id" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-slate-500 outline-none">
                            <option value="">Selecione o Supervisor</option>
                            <?php foreach($supervisores as $s): ?>
                                <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['nome']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Seção 2: Termos do Estágio -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-3 text-sm font-bold text-slate-500 uppercase tracking-wider border-b pb-2">Condições e Vigência</div>
                
                <div class="space-y-1">
                    <label class="text-sm font-semibold text-gray-700">Nível de Escolaridade</label>
                    <select name="nivel_escolaridade_id" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-slate-500 outline-none">
                        <option value="">Selecione o Nível</option>
                        <?php foreach($niveis as $n): ?>
                            <option value="<?= $n['id'] ?>"><?= $n['descricao'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="space-y-1">
                    <label class="text-sm font-semibold text-gray-700">Carga Horária</label>
                    <select name="carga_horaria_id" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-slate-500 outline-none">
                        <?php foreach($cargas as $ch): ?>
                            <option value="<?= $ch['id'] ?>"><?= $ch['descricao'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="space-y-1">
                    <label class="text-sm font-semibold text-gray-700">Data de Início</label>
                    <input type="date" name="data_inicio" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-slate-500 outline-none">
                </div>

                <div class="space-y-1">
                    <label class="text-sm font-semibold text-gray-700">Data de Fim (Previsão)</label>
                    <input type="date" name="data_fim" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-slate-500 outline-none">
                </div>

                <div class="space-y-1">
                    <label class="text-sm font-semibold text-gray-700">Valor da Bolsa (R$)</label>
                    <input type="number" step="0.01" name="valor_bolsa" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-slate-500 outline-none" placeholder="0.00">
                </div>

                <div class="space-y-1">
                    <label class="text-sm font-semibold text-gray-700">Auxílio Transporte (R$)</label>
                    <input type="number" step="0.01" name="valor_transporte" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-slate-500 outline-none" placeholder="0.00">
                </div>

                <div class="space-y-1">
                    <label class="text-sm font-semibold text-gray-700">Status Inicial</label>
                    <select name="status" class="w-full px-4 py-2 rounded-lg border border-gray-300 bg-gray-50 outline-none">
                        <option value="Ativo">Ativo</option>
                    </select>
                </div>
            </div>

            <div class="pt-8 border-t border-gray-100 flex justify-end space-x-4">
                <a href="index.php" class="px-6 py-3 rounded-xl text-gray-600 hover:bg-gray-100 transition-all font-medium">Cancelar</a>
                <button type="submit" class="px-10 py-3 bg-slate-700 hover:bg-slate-800 text-white rounded-xl shadow-xl shadow-slate-200 transition-all font-bold">Gerar Contrato</button>
            </div>
        </form>
    </div>
</div>

<?php
require_once __DIR__ . '/../../includes/footer.php';
?>
