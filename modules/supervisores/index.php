<?php
require_once __DIR__ . '/../../src/Models/Supervisor.php';
use App\Models\Supervisor;

$supervisorModel = new Supervisor();
$supervisores = $supervisorModel->allWithLotacao();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supervisores - EstagiárioPlus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">
    <!-- Navbar -->
    <nav class="bg-emerald-800 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="../../index.php" class="text-xl font-bold tracking-tight flex items-center">
                        <i class="fas fa-graduation-cap mr-2"></i>EstagiárioPlus
                    </a>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="../../index.php" class="hover:text-emerald-200 px-3 py-2 rounded-md text-sm font-medium">Dashboard</a>
                    <a href="../estudantes/index.php" class="hover:text-emerald-200 px-3 py-2 rounded-md text-sm font-medium">Estudantes</a>
                    <a href="index.php" class="bg-emerald-900 px-3 py-2 rounded-md text-sm font-medium">Supervisores</a>
                    <a href="../vagas/index.php" class="hover:text-emerald-200 px-3 py-2 rounded-md text-sm font-medium">Vagas</a>
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-grow container mx-auto px-4 py-8">
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Supervisores</h1>
                <p class="text-gray-500">Gestores responsáveis pelos estagiários em cada lotação.</p>
            </div>
            <a href="novo.php" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-xl shadow-lg transition-all flex items-center font-semibold">
                <i class="fas fa-plus mr-2"></i> Novo Supervisor
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50 text-gray-500 text-xs font-bold uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-4 text-left">Supervisor / Cargo</th>
                        <th class="px-6 py-4 text-left">Contato</th>
                        <th class="px-6 py-4 text-left">Lotação / Município</th>
                        <th class="px-6 py-4 text-center">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    <?php if (empty($supervisores)): ?>
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-400">
                                <i class="fas fa-user-tie text-4xl mb-4 block"></i>
                                Nenhum supervisor cadastrado.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($supervisores as $s): ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-gray-900"><?= htmlspecialchars($s['nome']) ?></div>
                                    <div class="text-xs text-gray-500"><?= htmlspecialchars($s['cargo'] ?: 'N/A') ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-600"><?= htmlspecialchars($s['email']) ?></div>
                                    <div class="text-xs text-gray-500 font-medium"><?= htmlspecialchars($s['telefone_ramal'] ?: 'Sem ramal') ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-700 font-bold"><?= htmlspecialchars($s['unidade'] ?: 'N/A') ?></div>
                                    <div class="text-xs text-gray-500"><?= htmlspecialchars($s['municipio'] ?: 'N/A') ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <button class="text-emerald-600 hover:text-emerald-900 mx-2"><i class="fas fa-edit"></i></button>
                                    <button class="text-red-600 hover:text-red-900 mx-2"><i class="fas fa-trash-alt"></i></button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
