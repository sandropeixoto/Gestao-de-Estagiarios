<?php
require_once __DIR__ . '/../../config/database.php';
$db = Database::getConnection();

// Buscar Unidades distintas
$unidades = $db->query("SELECT DISTINCT unidade FROM lotacoes WHERE unidade IS NOT NULL AND unidade != '' ORDER BY unidade")->fetchAll();

// Buscar todas as lotações para o filtro via JS
$todasLotacoes = $db->query("SELECT id, subunidade, unidade FROM lotacoes ORDER BY subunidade")->fetchAll();

require_once __DIR__ . '/../../includes/header.php';
?>

<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="bg-emerald-600 px-8 py-6 text-white">
            <h2 class="text-2xl font-bold flex items-center">
                <i class="fas fa-user-tie mr-3"></i> Cadastro de Supervisor
            </h2>
            <p class="text-emerald-100 mt-1">Registre os responsáveis pelo acompanhamento dos estagiários.</p>
        </div>
        
        <form action="save.php" method="POST" class="p-8 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700">Nome Completo</label>
                    <input type="text" name="nome" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700">Cargo / Função</label>
                    <input type="text" name="cargo" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700">E-mail Corporativo</label>
                    <input type="email" name="email" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700">Telefone / Ramal</label>
                    <input type="text" name="telefone_ramal" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 outline-none" placeholder="(00) 0000-0000">
                </div>

                <!-- Seleção de Lotação em Dois Níveis -->
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700">Unidade</label>
                    <select id="unidade_select" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 outline-none" onchange="filtrarSubunidades()">
                        <option value="">Selecione a Unidade</option>
                        <?php foreach($unidades as $u): ?>
                            <option value="<?= htmlspecialchars($u['unidade']) ?>"><?= htmlspecialchars($u['unidade']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700">Subunidade</label>
                    <select id="subunidade_select" name="lotacao_id" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 outline-none" disabled>
                        <option value="">Selecione primeiro a unidade</option>
                    </select>
                </div>
            </div>

            <div class="pt-6 border-t border-gray-100 flex justify-end space-x-4">
                <a href="index.php" class="px-6 py-2.5 rounded-lg text-gray-600 hover:bg-gray-100 transition-all font-medium">Cancelar</a>
                <button type="submit" class="px-8 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg shadow-lg font-bold">Salvar Supervisor</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Dados das lotações injetados pelo PHP
    const lotacoes = <?= json_encode($todasLotacoes) ?>;

    function filtrarSubunidades() {
        const unidadeSelecionada = document.getElementById('unidade_select').value;
        const subunidadeSelect = document.getElementById('subunidade_select');
        
        // Limpar opções atuais
        subunidadeSelect.innerHTML = '<option value="">Selecione a Subunidade</option>';
        
        if (unidadeSelecionada) {
            const filtradas = lotacoes.filter(l => l.unidade === unidadeSelecionada);
            
            filtradas.forEach(l => {
                const option = document.createElement('option');
                option.value = l.id;
                option.textContent = l.subunidade;
                subunidadeSelect.appendChild(option);
            });
            
            subunidadeSelect.disabled = false;
        } else {
            subunidadeSelect.disabled = true;
            subunidadeSelect.innerHTML = '<option value="">Selecione primeiro a unidade</option>';
        }
    }
</script>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
