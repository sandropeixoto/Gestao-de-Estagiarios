<?php
require_once __DIR__ . '/../../src/Models/Position.php';
use App\Models\Position;

$posModel = new Position();
$vagas = $posModel->allWithDetails();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vagas - EstagiárioPlus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">
    <!-- Navbar -->
    <nav class="bg-indigo-800 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="../../index.php" class="text-xl font-bold tracking-tight flex items-center">
                        <i class="fas fa-graduation-cap mr-2"></i>EstagiárioPlus
                    </a>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="../../index.php" class="hover:text-indigo-200 px-3 py-2 rounded-md text-sm font-medium">Dashboard</a>
                    <a href="../estudantes/index.php" class="hover:text-indigo-200 px-3 py-2 rounded-md text-sm font-medium">Estudantes</a>
                    <a href="../instituicoes/index.php" class="hover:text-indigo-200 px-3 py-2 rounded-md text-sm font-medium">Instituições</a>
                    <a href="index.php" class="bg-indigo-900 px-3 py-2 rounded-md text-sm font-medium">Vagas</a>
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-grow container mx-auto px-4 py-8">
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Vagas e Oportunidades</h1>
                <p class="text-gray-500">Controle de vagas abertas, ocupadas e suspensas.</p>
            </div>
            <a href="novo.php" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl shadow-lg transition-all flex items-center font-semibold">
                <i class="fas fa-plus mr-2"></i> Nova Vaga
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50 text-gray-500 text-xs font-bold uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-4 text-left">Lotação / Unidade</th>
                        <th class="px-6 py-4 text-left">Nível / Carga H.</th>
                        <th class="px-6 py-4 text-center">Qtd / Bolsa</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-center">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    <?php if (empty($vagas)): ?>
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-400">
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
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-800 font-medium"><?= htmlspecialchars($v['nivel']) ?></div>
                                    <div class="text-xs text-indigo-600 font-bold uppercase"><?= htmlspecialchars($v['carga_horaria']) ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="text-sm font-bold text-gray-900"><?= $v['quantidade'] ?> vaga(s)</div>
                                    <div class="text-xs text-gray-500">R$ <?= number_format($v['remuneracao_base'], 2, ',', '.') ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="px-2.5 py-1 text-xs font-bold rounded-full 
                                        <?= $v['status'] == 'Aberta' ? 'bg-blue-100 text-blue-700' : ($v['status'] == 'Ocupada' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700') ?>">
                                        <?= $v['status'] ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <button class="text-indigo-600 hover:text-indigo-900 mx-2"><i class="fas fa-edit"></i></button>
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
