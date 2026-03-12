<?php
require_once __DIR__ . '/../../src/Models/Student.php';
use App\Models\Student;

$studentModel = new Student();
$estudantes = $studentModel->allWithDetails();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estudantes - EstagiárioPlus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">
    <!-- Navbar -->
    <nav class="bg-blue-800 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="../../index.php" class="text-xl font-bold tracking-tight flex items-center">
                        <i class="fas fa-graduation-cap mr-2"></i>EstagiárioPlus
                    </a>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="../../index.php" class="hover:text-blue-200 px-3 py-2 rounded-md text-sm font-medium">Dashboard</a>
                    <a href="index.php" class="bg-blue-900 px-3 py-2 rounded-md text-sm font-medium">Estudantes</a>
                    <a href="../instituicoes/index.php" class="hover:text-blue-200 px-3 py-2 rounded-md text-sm font-medium">Instituições</a>
                    <a href="../vagas/index.php" class="hover:text-blue-200 px-3 py-2 rounded-md text-sm font-medium">Vagas</a>
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-grow container mx-auto px-4 py-8">
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
                                    <button class="text-blue-600 hover:text-blue-900 mx-2" title="Editar"><i class="fas fa-edit"></i></button>
                                    <button class="text-red-600 hover:text-red-900 mx-2" title="Excluir"><i class="fas fa-trash-alt"></i></button>
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
