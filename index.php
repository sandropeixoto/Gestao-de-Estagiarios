<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - EstagiárioPlus</title>
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
                    <a href="index.php" class="bg-blue-700 px-3 py-2 rounded-md text-sm font-medium">Dashboard</a>
                    <a href="modules/estudantes/index.php" class="hover:text-blue-200 px-3 py-2 rounded-md text-sm font-medium">Estudantes</a>
                    <a href="modules/instituicoes/index.php" class="hover:text-blue-200 px-3 py-2 rounded-md text-sm font-medium">Instituições</a>
                    <a href="modules/supervisores/index.php" class="hover:text-blue-200 px-3 py-2 rounded-md text-sm font-medium">Supervisores</a>
                    <a href="modules/vagas/index.php" class="hover:text-blue-200 px-3 py-2 rounded-md text-sm font-medium">Vagas</a>
                    <a href="modules/contratos/index.php" class="hover:text-blue-200 px-3 py-2 rounded-md text-sm font-medium">Contratos</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content Area -->
    <main class="flex-grow container mx-auto px-4 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Dashboard</h1>
            <p class="text-gray-500">Visão geral da gestão de estagiários.</p>
        </div>

        <!-- Dashboard Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center">
                <div class="p-3 bg-blue-100 text-blue-600 rounded-lg mr-4">
                    <i class="fas fa-file-signature text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium uppercase tracking-wider">Contratos Ativos</p>
                    <p class="text-2xl font-bold text-gray-800">0</p>
                </div>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center">
                <div class="p-3 bg-indigo-100 text-indigo-600 rounded-lg mr-4">
                    <i class="fas fa-briefcase text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium uppercase tracking-wider">Vagas Abertas</p>
                    <p class="text-2xl font-bold text-gray-800">0</p>
                </div>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center">
                <div class="p-3 bg-emerald-100 text-emerald-600 rounded-lg mr-4">
                    <i class="fas fa-university text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium uppercase tracking-wider">Instituições</p>
                    <p class="text-2xl font-bold text-gray-800">0</p>
                </div>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center">
                <div class="p-3 bg-amber-100 text-amber-600 rounded-lg mr-4">
                    <i class="fas fa-user-graduate text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium uppercase tracking-wider">Estagiários</p>
                    <p class="text-2xl font-bold text-gray-800">0</p>
                </div>
            </div>
        </div>

        <!-- Quick Access -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Ações Rápidas</h3>
                <div class="grid grid-cols-2 gap-4">
                    <a href="modules/contratos/novo.php" class="flex flex-col items-center justify-center p-4 bg-gray-50 rounded-xl hover:bg-blue-50 hover:text-blue-600 transition-all border border-transparent hover:border-blue-100">
                        <i class="fas fa-file-contract text-2xl mb-2"></i>
                        <span class="text-sm font-medium">Novo Contrato</span>
                    </a>
                    <a href="modules/estudantes/novo.php" class="flex flex-col items-center justify-center p-4 bg-gray-50 rounded-xl hover:bg-blue-50 hover:text-blue-600 transition-all border border-transparent hover:border-blue-100">
                        <i class="fas fa-user-plus text-2xl mb-2"></i>
                        <span class="text-sm font-medium">Novo Estudante</span>
                    </a>
                    <a href="modules/vagas/novo.php" class="flex flex-col items-center justify-center p-4 bg-gray-50 rounded-xl hover:bg-blue-50 hover:text-blue-600 transition-all border border-transparent hover:border-blue-100">
                        <i class="fas fa-plus-square text-2xl mb-2"></i>
                        <span class="text-sm font-medium">Nova Vaga</span>
                    </a>
                    <a href="modules/instituicoes/novo.php" class="flex flex-col items-center justify-center p-4 bg-gray-50 rounded-xl hover:bg-blue-50 hover:text-blue-600 transition-all border border-transparent hover:border-blue-100">
                        <i class="fas fa-building text-2xl mb-2"></i>
                        <span class="text-sm font-medium">Nova Instituição</span>
                    </a>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Avisos e Lembretes</h3>
                <div class="space-y-4">
                    <div class="flex items-start p-3 bg-blue-50 rounded-lg text-blue-700 text-sm">
                        <i class="fas fa-info-circle mt-0.5 mr-3"></i>
                        <p>Bem-vindo à nova versão do EstagiárioPlus! Migração para PHP concluída.</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 py-6 mt-12">
        <div class="max-w-7xl mx-auto px-4 text-center text-gray-500 text-sm">
            &copy; 2026 EstagiárioPlus - Sistema de Gestão de Estágios.
        </div>
    </footer>
</body>
</html>
