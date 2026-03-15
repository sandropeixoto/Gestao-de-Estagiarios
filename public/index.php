<?php
require_once __DIR__ . '/../src/Models/Contract.php';
require_once __DIR__ . '/../config/database.php';

use App\Models\Contract;

$contractModel = new Contract();
$contratos = $contractModel->allWithDetails();

// KPI Data
$db = Database::getConnection();
$totalAtivos = $db->query("SELECT COUNT(*) FROM contracts WHERE status = 'Ativo'")->fetchColumn();
$totalEstudantes = $db->query("SELECT COUNT(*) FROM students")->fetchColumn();
$totalInstituicoes = $db->query("SELECT COUNT(*) FROM institutions WHERE status_convenio = 'Ativo'")->fetchColumn();
$totalVagas = $db->query("SELECT COUNT(*) FROM positions WHERE status = 'Aberta'")->fetchColumn();

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Estagiários - EstagiárioPlus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1e40af',
                        secondary: '#1e293b',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">
    <!-- Navbar -->
    <nav class="bg-primary text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <span class="text-xl font-bold tracking-tight"><i class="fas fa-graduation-cap mr-2"></i>EstagiárioPlus</span>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="index.php" class="hover:text-blue-200 px-3 py-2 rounded-md text-sm font-medium border-b-2 border-white">Dashboard</a>
                    <a href="modules/estudantes/index.php" class="hover:text-blue-200 px-3 py-2 rounded-md text-sm font-medium">Estudantes</a>
                    <a href="modules/instituicoes/index.php" class="hover:text-blue-200 px-3 py-2 rounded-md text-sm font-medium">Instituições</a>
                    <a href="modules/vagas/index.php" class="hover:text-blue-200 px-3 py-2 rounded-md text-sm font-medium">Vagas</a>
                    <a href="modules/contratos/index.php" class="hover:text-blue-200 px-3 py-2 rounded-md text-sm font-medium">Contratos</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content Area -->
    <main class="flex-grow container mx-auto px-4 py-8">
        <div class="mb-8 flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-800">Painel de Controle</h1>
            <a href="modules/contratos/novo.php" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow-md transition-all flex items-center">
                <i class="fas fa-plus mr-2"></i> Novo Contrato
            </a>
        </div>

        <!-- Dashboard Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center">
                <div class="p-3 bg-blue-100 text-blue-600 rounded-lg mr-4">
                    <i class="fas fa-file-signature text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium uppercase tracking-wider">Contratos Ativos</p>
                    <p class="text-2xl font-bold text-gray-800"><?= $totalAtivos ?></p>
                </div>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center">
                <div class="p-3 bg-green-100 text-green-600 rounded-lg mr-4">
                    <i class="fas fa-user-graduate text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium uppercase tracking-wider">Estudantes</p>
                    <p class="text-2xl font-bold text-gray-800"><?= $totalEstudantes ?></p>
                </div>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center">
                <div class="p-3 bg-purple-100 text-purple-600 rounded-lg mr-4">
                    <i class="fas fa-university text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium uppercase tracking-wider">Instituições</p>
                    <p class="text-2xl font-bold text-gray-800"><?= $totalInstituicoes ?></p>
                </div>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center">
                <div class="p-3 bg-orange-100 text-orange-600 rounded-lg mr-4">
                    <i class="fas fa-briefcase text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium uppercase tracking-wider">Vagas Abertas</p>
                    <p class="text-2xl font-bold text-gray-800"><?= $totalVagas ?></p>
                </div>
            </div>
        </div>

        <!-- Recent Contracts Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-lg font-bold text-gray-800">Últimos Contratos Formalizados</h3>
            </div>
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estagiário</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Instituição / Supervisor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vigência</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bolsa</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if (empty($contratos)): ?>
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-500">Nenhum contrato encontrado.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach (array_slice($contratos, 0, 10) as $c): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900"><?= htmlspecialchars($c['estagiario']) ?></div>
                                <div class="text-xs text-gray-500">ID: #<?= $c['id'] ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-700"><?= htmlspecialchars($c['instituicao']) ?></div>
                                <div class="text-xs text-gray-500">Sup: <?= htmlspecialchars($c['supervisor_name']) ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= date('d/m/Y', strtotime($c['data_inicio'])) ?> - <?= date('d/m/Y', strtotime($c['data_fim'])) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 font-medium">
                                R$ <?= number_format($c['valor_bolsa'], 2, ',', '.') ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php 
                                    $statusClass = $c['status'] == 'Ativo' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800';
                                ?>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $statusClass ?>">
                                    <?= $c['status'] ?>
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
            <div class="p-4 bg-gray-50 text-center">
                <a href="modules/contratos/index.php" class="text-sm text-blue-600 font-semibold hover:text-blue-800">Ver todos os contratos <i class="fas fa-arrow-right ml-1"></i></a>
            </div>
        </div>
    </main>

    <footer class="bg-white border-t border-gray-200 py-6">
        <div class="max-w-7xl mx-auto px-4 text-center text-gray-500 text-sm">
            &copy; 2026 EstagiárioPlus - Sistema de Gestão de Estágios. Ambientes MySQL Unificado.
        </div>
    </footer>
</body>
</html>
