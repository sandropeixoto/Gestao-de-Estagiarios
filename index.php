<?php
require_once __DIR__ . '/includes/header.php';
?>

<div class="mb-8 flex flex-col md:flex-row md:items-end md:justify-between">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Dashboard Administrativo</h1>
        <p class="text-gray-500 mt-1">Bem-vindo ao centro de controle do EstagiárioPlus.</p>
    </div>
    <div class="mt-4 md:mt-0">
        <span class="text-sm font-medium text-gray-400">Status do Sistema: <span class="text-green-500 font-bold">Online</span></span>
    </div>
</div>

<!-- Dashboard Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center hover:shadow-md transition-shadow">
        <div class="p-4 bg-blue-100 text-blue-600 rounded-xl mr-5">
            <i class="fas fa-file-contract text-2xl"></i>
        </div>
        <div>
            <p class="text-sm text-gray-400 font-bold uppercase tracking-tighter">Contratos Ativos</p>
            <p class="text-3xl font-black text-gray-800">0</p>
        </div>
    </div>
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center hover:shadow-md transition-shadow">
        <div class="p-4 bg-indigo-100 text-indigo-600 rounded-xl mr-5">
            <i class="fas fa-briefcase text-2xl"></i>
        </div>
        <div>
            <p class="text-sm text-gray-400 font-bold uppercase tracking-tighter">Vagas Abertas</p>
            <p class="text-3xl font-black text-gray-800">0</p>
        </div>
    </div>
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center hover:shadow-md transition-shadow">
        <div class="p-4 bg-emerald-100 text-emerald-600 rounded-xl mr-5">
            <i class="fas fa-university text-2xl"></i>
        </div>
        <div>
            <p class="text-sm text-gray-400 font-bold uppercase tracking-tighter">Instituições</p>
            <p class="text-3xl font-black text-gray-800">0</p>
        </div>
    </div>
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center hover:shadow-md transition-shadow">
        <div class="p-4 bg-amber-100 text-amber-600 rounded-xl mr-5">
            <i class="fas fa-user-graduate text-2xl"></i>
        </div>
        <div>
            <p class="text-sm text-gray-400 font-bold uppercase tracking-tighter">Estagiários</p>
            <p class="text-3xl font-black text-gray-800">0</p>
        </div>
    </div>
</div>

<!-- Quick Actions & Alerts -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2 bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
        <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
            <i class="fas fa-bolt text-amber-400 mr-3"></i> Ações Rápidas
        </h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="modules/contratos/novo.php" class="group p-6 bg-gray-50 rounded-2xl hover:bg-slate-800 transition-all text-center">
                <i class="fas fa-file-signature text-2xl text-slate-400 group-hover:text-accent mb-3 block"></i>
                <span class="text-sm font-bold text-gray-600 group-hover:text-white">Novo Contrato</span>
            </a>
            <a href="modules/estudantes/novo.php" class="group p-6 bg-gray-50 rounded-2xl hover:bg-slate-800 transition-all text-center">
                <i class="fas fa-user-plus text-2xl text-slate-400 group-hover:text-accent mb-3 block"></i>
                <span class="text-sm font-bold text-gray-600 group-hover:text-white">Novo Aluno</span>
            </a>
            <a href="modules/vagas/novo.php" class="group p-6 bg-gray-50 rounded-2xl hover:bg-slate-800 transition-all text-center">
                <i class="fas fa-plus-square text-2xl text-slate-400 group-hover:text-accent mb-3 block"></i>
                <span class="text-sm font-bold text-gray-600 group-hover:text-white">Nova Vaga</span>
            </a>
            <a href="modules/instituicoes/novo.php" class="group p-6 bg-gray-50 rounded-2xl hover:bg-slate-800 transition-all text-center">
                <i class="fas fa-building text-2xl text-slate-400 group-hover:text-accent mb-3 block"></i>
                <span class="text-sm font-bold text-gray-600 group-hover:text-white">Nova Instituição</span>
            </a>
        </div>
    </div>
    
    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
        <h3 class="text-xl font-bold text-gray-800 mb-6">Informativos</h3>
        <div class="space-y-4">
            <div class="p-4 bg-blue-50 border-l-4 border-blue-500 rounded-r-xl">
                <p class="text-blue-800 font-bold text-sm">Atualização do Sistema</p>
                <p class="text-blue-600 text-xs mt-1">Sidebar e cabeçalho modularizados aplicados com sucesso.</p>
            </div>
            <div class="p-4 bg-amber-50 border-l-4 border-amber-500 rounded-r-xl">
                <p class="text-amber-800 font-bold text-sm">Lembrete</p>
                <p class="text-amber-600 text-xs mt-1">Verifique os contratos que vencem nos próximos 30 dias.</p>
            </div>
        </div>
    </div>
</div>

<?php
require_once __DIR__ . '/includes/footer.php';
?>
