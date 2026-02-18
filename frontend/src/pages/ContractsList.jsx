import React, { useState, useEffect } from 'react';
import { listContracts } from '../services/api';
import { Link } from 'react-router-dom';
import { Plus } from 'lucide-react';

const ContractsList = () => {
    const [contracts, setContracts] = useState([]);

    useEffect(() => {
        listContracts().then(res => setContracts(res.data)).catch(console.error);
    }, []);

    return (
        <div className="space-y-6">
            <div className="flex justify-between items-center">
                <h2 className="text-2xl font-bold text-gray-800">Contratos de Estágio</h2>
                <Link to="/contract/new" className="bg-primary text-white px-4 py-2 rounded-lg flex items-center hover:bg-primary/90 transition-colors">
                    <Plus className="w-5 h-5 mr-2" /> Novo Contrato
                </Link>
            </div>
            <div className="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <table className="min-w-full divide-y divide-gray-200">
                    <thead className="bg-gray-50">
                        <tr>
                            <th className="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Estudante</th>
                            <th className="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Instituição</th>
                            <th className="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Vigência</th>
                            <th className="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
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
