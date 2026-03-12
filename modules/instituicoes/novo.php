<?php
require_once __DIR__ . '/../../includes/header.php';
?>

<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="bg-blue-600 px-8 py-6 text-white">
            <h2 class="text-2xl font-bold flex items-center">
                <i class="fas fa-university mr-3"></i> Cadastro de Instituição de Ensino
            </h2>
            <p class="text-blue-100 mt-1">Gerencie os convênios com as instituições parceiras.</p>
        </div>
        
        <form action="save.php" method="POST" class="p-8 space-y-8">
            <!-- Informações Principais -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700">Razão Social</label>
                    <input type="text" name="razao_social" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700">CNPJ</label>
                    <input type="text" name="cnpj" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 outline-none" placeholder="00.000.000/0000-00">
                </div>
            </div>

            <!-- Gestão: Diretor e Coordenador -->
            <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2 text-sm font-bold text-gray-500 uppercase tracking-wider mb-2">Contatos de Gestão (Opcional)</div>
                
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700">Nome do Diretor</label>
                    <input type="text" name="nome_diretor" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700">E-mail do Diretor</label>
                    <input type="email" name="email_diretor" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700">Nome do Coordenador</label>
                    <input type="text" name="nome_coordenador" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700">E-mail do Coordenador</label>
                    <input type="email" name="email_coordenador" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
            </div>

            <div class="pt-6 border-t border-gray-100 flex justify-end space-x-4">
                <a href="index.php" class="px-6 py-2.5 rounded-lg text-gray-600 hover:bg-gray-100 transition-all font-medium">Cancelar</a>
                <button type="submit" class="px-8 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow-lg font-bold">Salvar Instituição</button>
            </div>
        </form>
    </div>
</div>

<?php
require_once __DIR__ . '/../../includes/footer.php';
?>
