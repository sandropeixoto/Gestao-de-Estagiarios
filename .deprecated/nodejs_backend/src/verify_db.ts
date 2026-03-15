import { createClient } from '@supabase/supabase-js';
import dotenv from 'dotenv';

dotenv.config();

const supabaseUrl = process.env.SUPABASE_URL;
const supabaseKey = process.env.SUPABASE_KEY;

if (!supabaseUrl || !supabaseKey) {
    console.error('❌ Erro: SUPABASE_URL ou SUPABASE_KEY não definidos no .env');
    process.exit(1);
}

const supabase = createClient(supabaseUrl, supabaseKey);

async function runTests() {
    console.log('🔄 Iniciando testes de conexão com Supabase...\n');

    // Teste 1: Conexão Simples (Heartbeat)
    console.log('1️⃣  Testando Conexão (Listar tabelas/Health check)...');
    try {
        // Tenta listar 1 estagiário apenas para ver se conecta e lê
        const { data, error } = await supabase.from('students').select('*').limit(1);

        if (error) {
            console.error('❌ Falha na conexão ou leitura:', error.message);
            // Detalhar se for erro de RLS ou conexão
            if (error.code === 'PGRST301') console.error('   -> Dica: Erro de Permissão (RLS). A chave pode não ter acesso de leitura.');
        } else {
            console.log('✅ Conexão e Leitura: SUCESSO');
            console.log('   Dados recebidos:', data);
        }
    } catch (err) {
        console.error('❌ Erro inesperado no Teste 1:', err);
    }

    console.log('\n---------------------------------------------------\n');

    // Teste 2: Escrita (Inserção)
    console.log('2️⃣  Testando Escrita (Inserir registro de teste)...');
    const testStudent = {
        nome: "Teste de Conexão",
        cpf: "000.000.000-00",
        curso: "Engenharia de Testes",
        semestre: "1",
        previsao_formatura: "2030-12-01",
        dados_bancarios: "Banco Teste",
        comprovante_matricula_path: "teste/path"
    };

    try {
        const { data: insertData, error: insertError } = await supabase
            .from('students')
            .insert([testStudent])
            .select();

        if (insertError) {
            console.error('❌ Falha na escrita:', insertError.message);
            console.error('   Código do erro:', insertError.code);
            console.error('   Detalhes:', insertError.details);
            if (insertError.code === '42501') console.error('   -> Dica: Erro de Permissão (RLS). A chave pública pode não ter permissão de INSERT.');
        } else {
            console.log('✅ Escrita: SUCESSO');
            console.log('   Registro criado:', insertData);

            // Limpeza (opcional)
            if (insertData && insertData.length > 0) {
                const idToDelete = insertData[0].id; // Assumindo que tem campo id
                if (idToDelete) {
                    console.log('🧹 Limpando registro de teste...');
                    const { error: deleteError } = await supabase.from('students').delete().eq('id', idToDelete);
                    if (deleteError) console.error('   Erro ao limpar:', deleteError.message);
                    else console.log('   Limpeza concluída.');
                }
            }
        }
    } catch (err) {
        console.error('❌ Erro inesperado no Teste 2:', err);
    }
}

runTests();
