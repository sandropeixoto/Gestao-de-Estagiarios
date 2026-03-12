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
                    <a href="index.php" class="hover:text-blue-200 px-3 py-2 rounded-md text-sm font-medium">Dashboard</a>
                    <a href="estudantes.php" class="hover:text-blue-200 px-3 py-2 rounded-md text-sm font-medium">Estudantes</a>
                    <a href="instituicoes.php" class="hover:text-blue-200 px-3 py-2 rounded-md text-sm font-medium">Instituições</a>
                    <a href="vagas.php" class="hover:text-blue-200 px-3 py-2 rounded-md text-sm font-medium">Vagas</a>
                    <a href="contratos.php" class="hover:text-blue-200 px-3 py-2 rounded-md text-sm font-medium border-b-2 border-white">Contratos</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content Area -->
    <main class="flex-grow container mx-auto px-4 py-8">
        <div class="mb-8 flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-800">Contratos de Estágio</h1>
            <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow-md transition-all flex items-center">
                <i class="fas fa-plus mr-2"></i> Novo Contrato
            </button>
        </div>

        <!-- Dashboard Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center">
                <div class="p-3 bg-blue-100 text-blue-600 rounded-lg mr-4">
                    <i class="fas fa-file-signature text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium uppercase tracking-wider">Ativos</p>
                    <p class="text-2xl font-bold text-gray-800">24</p>
                </div>
            </div>
            <!-- More cards... -->
        </div>

        <!-- Table Placeholder based on DB Schema -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estagiário</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Instituição</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Período</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Carga H.</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <!-- Dynamic Rows will be here -->
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">João Silva</div>
                            <div class="text-sm text-gray-500">Nível Superior</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Universidade Federal</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">01/01/2026 - 31/12/2026</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">6 Horas</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Ativo</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="#" class="text-blue-600 hover:text-blue-900 mr-3"><i class="fas fa-edit"></i></a>
                            <a href="#" class="text-red-600 hover:text-red-900"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 py-6">
        <div class="max-w-7xl mx-auto px-4 text-center text-gray-500 text-sm">
            &copy; 2026 EstagiárioPlus - Sistema de Gestão de Estágios.
        </div>
    </footer>
</body>
</html>
