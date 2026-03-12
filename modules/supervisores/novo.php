<?php
require_once __DIR__ . '/../config/database.php';
$db = Database::getConnection();
$lotacoes = $db->query("SELECT id, subunidade, municipio FROM lotacoes ORDER BY subunidade")->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Supervisor - EstagiárioPlus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto py-12 px-4">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
            <div class="bg-emerald-600 px-8 py-6 text-white">
                <h2 class="text-2xl font-bold flex items-center">
                    <i class="fas fa-user-tie mr-3"></i> Cadastro de Supervisor
                </h2>
                <p class="text-emerald-100 mt-1">Registre os responsáveis pelo acompanhamento dos estagiários.</p>
            </div>
            
            <form action="save_supervisor.php" method="POST" class="p-8 space-y-6">
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
                    <div class="md:col-span-2 space-y-2">
                        <label class="text-sm font-semibold text-gray-700">Lotação de Trabalho</label>
                        <select name="lotacao_id" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 outline-none">
                            <?php foreach($lotacoes as $l): ?>
                                <option value="<?= $l['id'] ?>"><?= $l['subunidade'] ?> (<?= $l['municipio'] ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="pt-6 border-t border-gray-100 flex justify-end space-x-4">
                    <a href="supervisores.php" class="px-6 py-2.5 rounded-lg text-gray-600 hover:bg-gray-100 transition-all font-medium">Cancelar</a>
                    <button type="submit" class="px-8 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg shadow-lg font-bold">Salvar Supervisor</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
