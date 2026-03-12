<?php
require_once __DIR__ . '/../config/database.php';
$db = Database::getConnection();

$lotacoes = $db->query("SELECT id, subunidade, municipio FROM lotacoes ORDER BY subunidade")->fetchAll();
$niveis = $db->query("SELECT id, descricao FROM niveis_escolaridade")->fetchAll();
$cargas = $db->query("SELECT id, descricao FROM cargas_horarias")->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova Vaga - EstagiárioPlus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto py-12 px-4">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
            <div class="bg-indigo-600 px-8 py-6 text-white">
                <h2 class="text-2xl font-bold flex items-center">
                    <i class="fas fa-briefcase mr-3"></i> Abertura de Vaga
                </h2>
                <p class="text-indigo-100 mt-1">Defina os requisitos e a lotação para a nova oportunidade.</p>
            </div>
            
            <form action="save_position.php" method="POST" class="p-8 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Lotação -->
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-gray-700">Lotação / Unidade</label>
                        <select name="lotacao_id" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 outline-none">
                            <?php foreach($lotacoes as $l): ?>
                                <option value="<?= $l['id'] ?>"><?= $l['subunidade'] ?> (<?= $l['municipio'] ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Quantidade -->
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-gray-700">Quantidade de Vagas</label>
                        <input type="number" name="quantidade" value="1" min="1" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 outline-none">
                    </div>

                    <!-- Nível e Carga Horária -->
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-gray-700">Nível de Escolaridade</label>
                        <select name="nivel_escolaridade_id" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 outline-none">
                            <?php foreach($niveis as $n): ?>
                                <option value="<?= $n['id'] ?>"><?= $n['descricao'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-gray-700">Carga Horária</label>
                        <select name="carga_horaria_id" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 outline-none">
                            <?php foreach($cargas as $c): ?>
                                <option value="<?= $c['id'] ?>"><?= $c['descricao'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Remuneração -->
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-gray-700">Remuneração Base (R$)</label>
                        <input type="number" step="0.01" name="remuneracao_base" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="0.00">
                    </div>
                </div>

                <!-- Requisitos -->
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700">Requisitos / Observações</label>
                    <textarea name="requisitos" rows="4" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="Descreva os requisitos para a vaga..."></textarea>
                </div>

                <div class="pt-6 border-t border-gray-100 flex justify-end space-x-4">
                    <a href="vagas.php" class="px-6 py-2.5 rounded-lg text-gray-600 hover:bg-gray-100 transition-all font-medium">Cancelar</a>
                    <button type="submit" class="px-8 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg shadow-lg font-bold">Publicar Vaga</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
