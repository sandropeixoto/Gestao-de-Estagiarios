import React, { useState, useEffect } from 'react';
import { listContracts, deleteContract } from '../services/api';
import { Link, useNavigate } from 'react-router-dom';
import { Plus, Pencil, Trash2 } from 'lucide-react';
import PageHeader from '../components/ui/PageHeader';
import Button from '../components/ui/Button';

const ContractsList = () => {
    const [contracts, setContracts] = useState([]);

    const navigate = useNavigate();

    const fetchContracts = () => {
        listContracts().then(res => setContracts(res.data)).catch(console.error);
    };

    useEffect(() => {
        fetchContracts();
    }, []);

    const handleDelete = async (id) => {
        if (window.confirm('Tem certeza que deseja excluir este contrato?')) {
            try {
                await deleteContract(id);
                fetchContracts();
            } catch (error) {
                console.error('Failed to delete contract', error);
                alert('Erro ao excluir contrato.');
            }
        }
    };

    return (
        <div className="space-y-6">
            <PageHeader
                title="Contratos de Estágio"
                action={
                    <Link to="/contract/new">
                        <Button>
                            <Plus className="w-4 h-4 mr-2" />
                            Novo Contrato
                        </Button>
                    </Link>
                }
            />
            <div className="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <table className="min-w-full divide-y divide-gray-200">
                    <thead className="bg-gray-50">
                        <tr>
                            <th className="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Estudante</th>
                            <th className="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Unidade / Subunidade</th>
                            <th className="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Vigência</th>
                            <th className="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Status</th>
                            <th className="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Ações</th>
                        </tr>
                    </thead>
                    <tbody className="bg-white divide-y divide-gray-200">
                        {contracts.map(c => (
                            <tr key={c.id} className="hover:bg-gray-50 transition-colors">
                                <td className="px-6 py-4 whitespace-nowrap">
                                    <div className="text-sm font-bold text-brandText">{c.students?.nome || 'Não informado'}</div>
                                    <div className="text-[10px] text-muted uppercase tracking-wider">{c.institutions?.razao_social}</div>
                                </td>
                                <td className="px-6 py-4 whitespace-nowrap">
                                    <div className="text-xs font-bold text-primary">{c.positions?.lotacoes?.unidade}</div>
                                    <div className="text-[10px] text-gray-400">{c.positions?.lotacoes?.subunidade}</div>
                                </td>
                                <td className="px-6 py-4 whitespace-nowrap text-xs text-gray-600 font-medium">
                                    {c.data_inicio ? new Date(c.data_inicio).toLocaleDateString('pt-BR') : '-'} até <br/>
                                    {c.data_fim ? new Date(c.data_fim).toLocaleDateString('pt-BR') : '-'}
                                </td>
                                <td className="px-6 py-4 whitespace-nowrap text-center">
                                    <span className={`px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest ${
                                        c.status === 'Ativo' ? 'bg-emerald-50 text-emerald-600' : 'bg-red-50 text-red-600'
                                    }`}>
                                        {c.status}
                                    </span>
                                </td>
                                <td className="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button onClick={() => navigate(`/contract/edit/${c.id}`)} className="text-indigo-600 hover:text-indigo-900 mr-4">
                                        <Pencil className="w-4 h-4 inline" />
                                    </button>
                                    <button onClick={() => handleDelete(c.id)} className="text-red-600 hover:text-red-900">
                                        <Trash2 className="w-4 h-4 inline" />
                                    </button>
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
                {contracts.length === 0 && <div className="p-6 text-center text-gray-500">Nenhum contrato encontrado.</div>}
            </div>
        </div>
    );
};

export default ContractsList;
