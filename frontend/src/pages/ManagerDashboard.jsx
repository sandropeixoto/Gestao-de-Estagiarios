import { useState, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import {
    getManagerDashboardData,
    listStudents,
    listInstitutions,
    listSupervisors,
    listContracts
} from '../services/api';

const ManagerDashboard = () => {
    const navigate = useNavigate();
    const [activeTab, setActiveTab] = useState('overview');
    const [stats, setStats] = useState({ expiringContracts: [], evaluationsPending: [] });

    const [students, setStudents] = useState([]);
    const [institutions, setInstitutions] = useState([]);
    const [supervisors, setSupervisors] = useState([]);
    const [contracts, setContracts] = useState([]);

    const [loading, setLoading] = useState(false);

    useEffect(() => {
        loadOverview();
    }, []);

    const loadOverview = async () => {
        setLoading(true);
        try {
            const response = await getManagerDashboardData();
            setStats(response.data);
        } catch (error) {
            console.error("Error loading dashboard", error);
        }
        setLoading(false);
    };

    const loadStudents = async () => {
        try {
            const res = await listStudents();
            setStudents(res.data);
        } catch (e) { console.error(e); }
    };

    const loadInstitutions = async () => {
        try {
            const res = await listInstitutions();
            setInstitutions(res.data);
        } catch (e) { console.error(e); }
    };

    const loadSupervisors = async () => {
        try {
            const res = await listSupervisors();
            setSupervisors(res.data);
        } catch (e) { console.error(e); }
    };

    const loadContracts = async () => {
        try {
            const res = await listContracts();
            setContracts(res.data);
        } catch (e) { console.error(e); }
    };

    const handleTabChange = (tab) => {
        setActiveTab(tab);
        if (tab === 'students') loadStudents();
        if (tab === 'institutions') loadInstitutions();
        if (tab === 'supervisors') loadSupervisors();
        if (tab === 'contracts') loadContracts();
    };

    return (
        <div className="min-h-screen bg-gray-50 flex flex-col">
            <header className="bg-indigo-600 text-white shadow-lg p-4">
                <div className="container mx-auto flex justify-between items-center">
                    <h1 className="text-2xl font-bold">Painel de Gestão - SGE</h1>
                    <nav className="space-x-2 sm:space-x-4 text-sm sm:text-base">
                        <button onClick={() => handleTabChange('overview')} className={`px-3 py-2 rounded ${activeTab === 'overview' ? 'bg-indigo-800' : 'hover:bg-indigo-500'}`}>Visão Geral</button>
                        <button onClick={() => handleTabChange('students')} className={`px-3 py-2 rounded ${activeTab === 'students' ? 'bg-indigo-800' : 'hover:bg-indigo-500'}`}>Estudantes</button>
                        <button onClick={() => handleTabChange('institutions')} className={`px-3 py-2 rounded ${activeTab === 'institutions' ? 'bg-indigo-800' : 'hover:bg-indigo-500'}`}>Instituições</button>
                        <button onClick={() => handleTabChange('supervisors')} className={`px-3 py-2 rounded ${activeTab === 'supervisors' ? 'bg-indigo-800' : 'hover:bg-indigo-500'}`}>Supervisores</button>
                        <button onClick={() => handleTabChange('contracts')} className={`px-3 py-2 rounded ${activeTab === 'contracts' ? 'bg-indigo-800' : 'hover:bg-indigo-500'}`}>Contratos</button>
                    </nav>
                </div>
            </header>

            <main className="container mx-auto p-6 flex-grow">
                {activeTab === 'overview' && (
                    <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div className="bg-white rounded-xl shadow p-6">
                            <h2 className="text-xl font-semibold mb-4 text-gray-700 border-b pb-2">Semáforo de Avaliações</h2>
                            {stats.evaluationsPending && stats.evaluationsPending.length === 0 ? (
                                <p className="text-gray-500">Todas as avaliações em dia.</p>
                            ) : (
                                <ul className="space-y-3">
                                    {(stats.evaluationsPending || []).map(item => (
                                        <li key={item.id} className="flex items-center justify-between p-3 bg-yellow-50 rounded-lg">
                                            <span className="font-medium text-gray-800">{item.student_name}</span>
                                            <span className="flex items-center text-yellow-600 font-bold">Pendente</span>
                                        </li>
                                    ))}
                                </ul>
                            )}
                        </div>

                        <div className="bg-white rounded-xl shadow p-6">
                            <h2 className="text-xl font-semibold mb-4 text-gray-700 border-b pb-2">Contratos Vencendo (30 dias)</h2>
                            {stats.expiringContracts && stats.expiringContracts.length === 0 ? (
                                <p className="text-green-600 font-medium">Nenhum contrato próximo do vencimento.</p>
                            ) : (
                                <ul className="space-y-3">
                                    {(stats.expiringContracts || []).map(contract => (
                                        <li key={contract.id} className="flex items-center justify-between p-3 bg-red-50 rounded-lg">
                                            <div>
                                                <p className="font-medium text-gray-800">{contract.student_name}</p>
                                                <p className="text-sm text-gray-500">Vence em: {contract.data_fim}</p>
                                            </div>
                                            <button className="px-3 py-1 bg-white border border-red-200 text-red-600 text-sm rounded hover:bg-red-50">Renovar</button>
                                        </li>
                                    ))}
                                </ul>
                            )}
                        </div>
                    </div>
                )}

                {activeTab === 'students' && (
                    <div className="bg-white rounded-xl shadow p-6">
                        <div className="flex justify-between mb-4">
                            <h2 className="text-xl font-semibold text-gray-700">Gerenciar Estudantes</h2>
                            <button onClick={() => navigate('/student/new')} className="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Novo Estudante</button>
                        </div>
                        <div className="overflow-x-auto">
                            <table className="min-w-full divide-y divide-gray-200">
                                <thead className="bg-gray-50">
                                    <tr>
                                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CPF</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Curso</th>
                                    </tr>
                                </thead>
                                <tbody className="bg-white divide-y divide-gray-200">
                                    {students.map(s => (
                                        <tr key={s.id}>
                                            <td className="px-6 py-4 whitespace-nowrap">{s.nome}</td>
                                            <td className="px-6 py-4 whitespace-nowrap">{s.cpf}</td>
                                            <td className="px-6 py-4 whitespace-nowrap">{s.curso}</td>
                                        </tr>
                                    ))}
                                    {students.length === 0 && <tr><td colSpan="3" className="px-6 py-4 text-center text-gray-500">Nenhum estudante cadastrado.</td></tr>}
                                </tbody>
                            </table>
                        </div>
                    </div>
                )}

                {activeTab === 'institutions' && (
                    <div className="bg-white rounded-xl shadow p-6">
                        <div className="flex justify-between mb-4">
                            <h2 className="text-xl font-semibold text-gray-700">Instituições de Ensino</h2>
                            <button onClick={() => navigate('/institution/new')} className="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Nova IES</button>
                        </div>
                        <div className="overflow-x-auto">
                            <table className="min-w-full divide-y divide-gray-200">
                                <thead className="bg-gray-50">
                                    <tr>
                                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Razão Social</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CNPJ</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    </tr>
                                </thead>
                                <tbody className="bg-white divide-y divide-gray-200">
                                    {institutions.map(i => (
                                        <tr key={i.id}>
                                            <td className="px-6 py-4 whitespace-nowrap">{i.razao_social}</td>
                                            <td className="px-6 py-4 whitespace-nowrap">{i.cnpj}</td>
                                            <td className="px-6 py-4 whitespace-nowrap">{i.status_convenio}</td>
                                        </tr>
                                    ))}
                                    {institutions.length === 0 && <tr><td colSpan="3" className="px-6 py-4 text-center text-gray-500">Nenhuma instituição cadastrada.</td></tr>}
                                </tbody>
                            </table>
                        </div>
                    </div>
                )}

                {activeTab === 'supervisors' && (
                    <div className="bg-white rounded-xl shadow p-6">
                        <div className="flex justify-between mb-4">
                            <h2 className="text-xl font-semibold text-gray-700">Supervisores</h2>
                            <button onClick={() => navigate('/supervisor/new')} className="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Novo Supervisor</button>
                        </div>
                        <div className="overflow-x-auto">
                            <table className="min-w-full divide-y divide-gray-200">
                                <thead className="bg-gray-50">
                                    <tr>
                                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cargo</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Área</th>
                                    </tr>
                                </thead>
                                <tbody className="bg-white divide-y divide-gray-200">
                                    {supervisors.map(s => (
                                        <tr key={s.id}>
                                            <td className="px-6 py-4 whitespace-nowrap">{s.nome}</td>
                                            <td className="px-6 py-4 whitespace-nowrap">{s.cargo}</td>
                                            <td className="px-6 py-4 whitespace-nowrap">{s.area}</td>
                                        </tr>
                                    ))}
                                    {supervisors.length === 0 && <tr><td colSpan="3" className="px-6 py-4 text-center text-gray-500">Nenhum supervisor cadastrado.</td></tr>}
                                </tbody>
                            </table>
                        </div>
                    </div>
                )}
                {activeTab === 'contracts' && (
                    <div className="bg-white rounded-xl shadow p-6">
                        <div className="flex justify-between mb-4">
                            <h2 className="text-xl font-semibold text-gray-700">Contratos de Estágio</h2>
                            <button onClick={() => navigate('/contract/new')} className="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Novo Contrato</button>
                        </div>
                        <div className="overflow-x-auto">
                            <table className="min-w-full divide-y divide-gray-200">
                                <thead className="bg-gray-50">
                                    <tr>
                                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estudante</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Empresa/IES</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Supervisor</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vigência</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    </tr>
                                </thead>
                                <tbody className="bg-white divide-y divide-gray-200">
                                    {contracts.map(c => (
                                        <tr key={c.id}>
                                            <td className="px-6 py-4 whitespace-nowrap">{c.student_name}</td>
                                            <td className="px-6 py-4 whitespace-nowrap">{c.institution_name}</td>
                                            <td className="px-6 py-4 whitespace-nowrap">{c.supervisor_name}</td>
                                            <td className="px-6 py-4 whitespace-nowrap">{c.data_inicio} a {c.data_fim}</td>
                                            <td className="px-6 py-4 whitespace-nowrap">
                                                <span className={`px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${c.status === 'Ativo' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}`}>
                                                    {c.status}
                                                </span>
                                            </td>
                                        </tr>
                                    ))}
                                    {contracts.length === 0 && <tr><td colSpan="5" className="px-6 py-4 text-center text-gray-500">Nenhum contrato cadastrado.</td></tr>}
                                </tbody>
                            </table>
                        </div>
                    </div>
                )}
            </main>
        </div>
    );
};

export default ManagerDashboard;
