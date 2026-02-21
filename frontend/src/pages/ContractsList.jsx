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
                            <th className="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Instituição</th>
                            <th className="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Vigência</th>
                            <th className="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                            <th className="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Ações</th>
                        </tr>
                    </thead>
                    <tbody className="bg-white divide-y divide-gray-200">
                        {contracts.map(c => (
                            <tr key={c.id} className="hover:bg-gray-50 transition-colors">
                                <td className="px-6 py-4 whitespace-nowrap text-gray-900 font-medium">{c.student_name}</td>
                                <td className="px-6 py-4 whitespace-nowrap text-gray-500">{c.institution_name}</td>
                                <td className="px-6 py-4 whitespace-nowrap text-gray-500">{c.data_inicio} - {c.data_fim}</td>
                                <td className="px-6 py-4 whitespace-nowrap">
                                    <span className={`px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${c.status === 'Ativo' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}`}>
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
