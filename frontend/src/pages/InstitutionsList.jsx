import React, { useState, useEffect } from 'react';
import { listInstitutions, deleteInstitution } from '../services/api';
import { Link, useNavigate } from 'react-router-dom';
import { Plus, Pencil, Trash2 } from 'lucide-react';
import PageHeader from '../components/ui/PageHeader';
import Button from '../components/ui/Button';

const InstitutionsList = () => {
    const [institutions, setInstitutions] = useState([]);

    const navigate = useNavigate();

    const fetchInstitutions = () => {
        listInstitutions().then(res => setInstitutions(res.data)).catch(console.error);
    };

    useEffect(() => {
        fetchInstitutions();
    }, []);

    const handleDelete = async (id) => {
        if (window.confirm('Tem certeza que deseja excluir esta instituição?')) {
            try {
                await deleteInstitution(id);
                fetchInstitutions();
            } catch (error) {
                console.error('Failed to delete institution', error);
                alert('Erro ao excluir instituição.');
            }
        }
    };

    return (
        <div className="space-y-6">
            <PageHeader
                title="Instituições de Ensino"
                action={
                    <Link to="/institution/new">
                        <Button>
                            <Plus className="w-4 h-4 mr-2" />
                            Nova IES
                        </Button>
                    </Link>
                }
            />
            <div className="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <table className="min-w-full divide-y divide-gray-200">
                    <thead className="bg-gray-50">
                        <tr>
                            <th className="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Razão Social</th>
                            <th className="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">CNPJ</th>
                            <th className="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                            <th className="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Ações</th>
                        </tr>
                    </thead>
                    <tbody className="bg-white divide-y divide-gray-200">
                        {institutions.map(i => (
                            <tr key={i.id} className="hover:bg-gray-50 transition-colors">
                                <td className="px-6 py-4 whitespace-nowrap text-gray-900 font-medium">{i.razao_social}</td>
                                <td className="px-6 py-4 whitespace-nowrap text-gray-500">{i.cnpj}</td>
                                <td className="px-6 py-4 whitespace-nowrap">
                                    <span className="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        {i.status_convenio}
                                    </span>
                                </td>
                                <td className="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button onClick={() => navigate(`/institution/edit/${i.id}`)} className="text-indigo-600 hover:text-indigo-900 mr-4">
                                        <Pencil className="w-4 h-4 inline" />
                                    </button>
                                    <button onClick={() => handleDelete(i.id)} className="text-red-600 hover:text-red-900">
                                        <Trash2 className="w-4 h-4 inline" />
                                    </button>
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
                {institutions.length === 0 && <div className="p-6 text-center text-gray-500">Nenhuma instituição encontrada.</div>}
            </div>
        </div>
    );
};

export default InstitutionsList;
