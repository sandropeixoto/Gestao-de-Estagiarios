import React, { useState, useEffect } from 'react';
import { listPositions, deletePosition } from '../services/api';
import { Link, useNavigate } from 'react-router-dom';
import { Plus, Pencil, Trash2, Briefcase } from 'lucide-react';
import PageHeader from '../components/ui/PageHeader';
import Button from '../components/ui/Button';

const PositionsList = () => {
    const [positions, setPositions] = useState([]);
    const [isLoading, setIsLoading] = useState(true);
    const navigate = useNavigate();

    const fetchPositions = async () => {
        setIsLoading(true);
        try {
            const res = await listPositions();
            setPositions(res.data);
        } catch (error) {
            console.error('Failed to fetch positions', error);
        } finally {
            setIsLoading(false);
        }
    };

    useEffect(() => {
        fetchPositions();
    }, []);

    const handleDelete = async (id) => {
        if (window.confirm('Tem certeza que deseja excluir esta vaga?')) {
            try {
                await deletePosition(id);
                fetchPositions();
            } catch (error) {
                console.error('Failed to delete position', error);
                alert('Erro ao excluir vaga.');
            }
        }
    };

    return (
        <div className="space-y-6">
            <PageHeader
                title="Vagas de Estágio"
                action={
                    <Link to="/position/new">
                        <Button>
                            <Plus className="w-4 h-4 mr-2" />
                            Nova Vaga
                        </Button>
                    </Link>
                }
            />

            <div className="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                {isLoading ? (
                    <div className="p-12 text-center text-gray-400">Carregando vagas...</div>
                ) : (
                    <table className="min-w-full divide-y divide-gray-200">
                        <thead className="bg-gray-50">
                            <tr>
                                <th className="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Unidade / Subunidade</th>
                                <th className="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Qtd.</th>
                                <th className="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Ocupação</th>
                                <th className="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                                <th className="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Ações</th>
                            </tr>
                        </thead>
                        <tbody className="bg-white divide-y divide-gray-200">
                            {positions.map(p => (
                                <tr key={p.id} className="hover:bg-gray-50 transition-colors">
                                    <td className="px-6 py-4">
                                        <div className="flex flex-col">
                                            <span className="text-sm font-bold text-brandText">{p.lotacoes?.unidade}</span>
                                            <span className="text-xs text-muted">{p.lotacoes?.subunidade}</span>
                                        </div>
                                    </td>
                                    <td className="px-6 py-4 text-center text-sm text-gray-600 font-medium">
                                        {p.quantidade}
                                    </td>
                                    <td className="px-6 py-4 text-center">
                                        <div className="flex flex-col items-center gap-1">
                                            <span className="text-xs font-bold text-gray-700">
                                                {p.occupied_slots} / {p.quantidade}
                                            </span>
                                            <div className="w-20 bg-gray-100 rounded-full h-1.5 overflow-hidden">
                                                <div 
                                                    className={`h-full rounded-full transition-all duration-500 ${
                                                        (p.occupied_slots / p.quantidade) >= 1 ? 'bg-red-500' : 'bg-primary'
                                                    }`}
                                                    style={{ width: `${Math.min((p.occupied_slots / p.quantidade) * 100, 100)}%` }}
                                                />
                                            </div>
                                        </div>
                                    </td>
                                    <td className="px-6 py-4 text-center">
                                        <span className={`px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest ${
                                            p.status === 'Aberta' ? 'bg-emerald-50 text-emerald-600' : 
                                            p.status === 'Ocupada' ? 'bg-amber-50 text-amber-600' : 'bg-gray-50 text-gray-600'
                                        }`}>
                                            {p.status}
                                        </span>
                                    </td>
                                    <td className="px-6 py-4 text-right text-sm font-medium">
                                        <button onClick={() => navigate(`/position/edit/${p.id}`)} className="text-primary hover:text-brandText mr-4 transition-colors">
                                            <Pencil className="w-4 h-4 inline" />
                                        </button>
                                        <button onClick={() => handleDelete(p.id)} className="text-red-400 hover:text-red-600 transition-colors">
                                            <Trash2 className="w-4 h-4 inline" />
                                        </button>
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                )}
                {!isLoading && positions.length === 0 && (
                    <div className="p-12 text-center flex flex-col items-center gap-4">
                        <Briefcase className="w-12 h-12 text-gray-200" />
                        <p className="text-gray-500 font-medium">Nenhuma vaga cadastrada no momento.</p>
                        <Link to="/position/new">
                            <Button variant="secondary" size="sm">Cadastrar Primeira Vaga</Button>
                        </Link>
                    </div>
                )}
            </div>
        </div>
    );
};

export default PositionsList;
