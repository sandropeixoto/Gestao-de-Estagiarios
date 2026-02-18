import React, { useState, useEffect } from 'react';
import { listInstitutions } from '../services/api';
import { Link } from 'react-router-dom';
import { Plus } from 'lucide-react';
import PageHeader from '../components/ui/PageHeader';
import Button from '../components/ui/Button';

const InstitutionsList = () => {
    const [institutions, setInstitutions] = useState([]);

    useEffect(() => {
        listInstitutions().then(res => setInstitutions(res.data)).catch(console.error);
    }, []);

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
