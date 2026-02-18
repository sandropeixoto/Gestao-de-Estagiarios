import { useState, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import { createContract, listStudents, listInstitutions, listSupervisors } from '../services/api';

const ContractForm = () => {
    const navigate = useNavigate();
    const [students, setStudents] = useState([]);
    const [institutions, setInstitutions] = useState([]);
    const [supervisors, setSupervisors] = useState([]);

    // Load lists for dropdowns
    useEffect(() => {
        listStudents().then(res => setStudents(res.data));
        listInstitutions().then(res => setInstitutions(res.data));
        listSupervisors().then(res => setSupervisors(res.data));
    }, []);

    const [formData, setFormData] = useState({
        student_id: '',
        institution_id: '',
        supervisor_id: '',
        data_inicio: '',
        data_fim: '',
        valor_bolsa: '',
        valor_transporte: '',
        apolice_seguro: ''
    });

    const handleSubmit = async (e) => {
        e.preventDefault();
        try {
            await createContract(formData);
            alert('Contrato cadastrado com sucesso!');
            navigate('/manager-dashboard');
        } catch (error) {
            console.error(error);
            alert('Erro ao cadastrar contrato. Verifique o limite de 2 anos ou se o supervisor já possui 10 estagiários.');
        }
    };

    return (
        <div className="min-h-screen bg-gray-50 flex items-center justify-center p-4">
            <div className="bg-white p-8 rounded-xl shadow-md w-full max-w-lg">
                <h2 className="text-2xl font-bold mb-6 text-gray-800">Novo Contrato</h2>
                <form onSubmit={handleSubmit} className="space-y-4">
                    <div>
                        <label className="block text-sm font-medium text-gray-700">Estudante</label>
                        <select required className="w-full border p-2 rounded" onChange={e => setFormData({ ...formData, student_id: e.target.value })}>
                            <option value="">Selecione...</option>
                            {students.map(s => <option key={s.id} value={s.id}>{s.nome} ({s.cpf})</option>)}
                        </select>
                    </div>
                    <div>
                        <label className="block text-sm font-medium text-gray-700">Instituição</label>
                        <select required className="w-full border p-2 rounded" onChange={e => setFormData({ ...formData, institution_id: e.target.value })}>
                            <option value="">Selecione...</option>
                            {institutions.map(i => <option key={i.id} value={i.id}>{i.razao_social}</option>)}
                        </select>
                    </div>
                    <div>
                        <label className="block text-sm font-medium text-gray-700">Supervisor</label>
                        <select required className="w-full border p-2 rounded" onChange={e => setFormData({ ...formData, supervisor_id: e.target.value })}>
                            <option value="">Selecione...</option>
                            {supervisors.map(s => <option key={s.id} value={s.id}>{s.nome} ({s.area})</option>)}
                        </select>
                    </div>

                    <div className="flex gap-4">
                        <div className="w-1/2">
                            <label className="block text-sm font-medium text-gray-700">Início</label>
                            <input type="date" required className="w-full border p-2 rounded"
                                onChange={e => setFormData({ ...formData, data_inicio: e.target.value })} />
                        </div>
                        <div className="w-1/2">
                            <label className="block text-sm font-medium text-gray-700">Fim</label>
                            <input type="date" required className="w-full border p-2 rounded"
                                onChange={e => setFormData({ ...formData, data_fim: e.target.value })} />
                        </div>
                    </div>

                    <div className="flex gap-4">
                        <div className="w-1/2">
                            <label className="block text-sm font-medium text-gray-700">Bolsa (R$)</label>
                            <input type="number" step="0.01" className="w-full border p-2 rounded"
                                onChange={e => setFormData({ ...formData, valor_bolsa: e.target.value })} />
                        </div>
                        <div className="w-1/2">
                            <label className="block text-sm font-medium text-gray-700">Transporte (R$)</label>
                            <input type="number" step="0.01" className="w-full border p-2 rounded"
                                onChange={e => setFormData({ ...formData, valor_transporte: e.target.value })} />
                        </div>
                    </div>

                    <div>
                        <label className="block text-sm font-medium text-gray-700">Apólice Seguro</label>
                        <input type="text" className="w-full border p-2 rounded"
                            onChange={e => setFormData({ ...formData, apolice_seguro: e.target.value })} />
                    </div>

                    <button type="submit" className="w-full bg-indigo-600 text-white p-2 rounded hover:bg-indigo-700">Salvar Contrato</button>
                    <button type="button" onClick={() => navigate('/manager-dashboard')} className="w-full bg-gray-200 text-gray-700 p-2 rounded hover:bg-gray-300">Cancelar</button>
                </form>
            </div>
        </div>
    );
};
export default ContractForm;
