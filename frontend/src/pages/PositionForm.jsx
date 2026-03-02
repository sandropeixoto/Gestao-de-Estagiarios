import React, { useState, useEffect } from 'react';
import { useNavigate, useParams } from 'react-router-dom';
import PageHeader from '../components/ui/PageHeader';
import Input from '../components/ui/Input';
import Button from '../components/ui/Button';
import Select from '../components/ui/Select';
import QuickSupervisorModal from '../components/QuickSupervisorModal';
import { createPosition, updatePosition, listPositions, listLotacoes, listSupervisors } from '../services/api';
import { AlertCircle, PlusCircle, CheckCircle2 } from 'lucide-react';

const PositionForm = () => {
    const navigate = useNavigate();
    const { id } = useParams();
    const isEditing = !!id;
    const [isLoading, setIsLoading] = useState(false);
    const [lotacoes, setLotacoes] = useState([]);
    const [supervisors, setSupervisors] = useState([]);
    const [selectedUnidade, setSelectedUnidade] = useState('');
    const [isModalOpen, setIsModalOpen] = useState(false);
    
    const [formData, setFormData] = useState({
        lotacao_id: '',
        quantidade: 1,
        remuneracao_base: '',
        requisitos: '',
        status: 'Aberta'
    });
    
    const [error, setError] = useState('');

    useEffect(() => {
        const fetchData = async () => {
            setIsLoading(true);
            try {
                const [lotRes, supRes] = await Promise.all([listLotacoes(), listSupervisors()]);
                setLotacoes(lotRes.data);
                setSupervisors(supRes.data);

                if (isEditing) {
                    const posRes = await listPositions();
                    const position = posRes.data.find(p => String(p.id) === String(id));
                    if (position) {
                        setFormData({
                            lotacao_id: position.lotacao_id,
                            quantidade: position.quantidade,
                            remuneracao_base: position.remuneracao_base,
                            requisitos: position.requisitos || '',
                            status: position.status
                        });
                        setSelectedUnidade(position.lotacoes?.unidade || '');
                    }
                }
            } catch (err) {
                console.error(err);
                setError('Erro ao carregar dados.');
            } finally {
                setIsLoading(false);
            }
        };
        fetchData();
    }, [id, isEditing]);

    const unidades = [...new Set(lotacoes.map(l => l.unidade))].sort().map(u => ({ value: u, label: u }));
    const subunidades = lotacoes
        .filter(l => l.unidade === selectedUnidade)
        .map(l => ({ value: l.id, label: l.subunidade }));

    // Verifica se há supervisores para a subunidade selecionada
    const hasSupervisors = formData.lotacao_id 
        ? supervisors.some(s => String(s.lotacao_id) === String(formData.lotacao_id))
        : true;

    const handleChange = (e) => {
        const { id, value } = e.target;
        setFormData(prev => ({ ...prev, [id]: value }));
    };

    const handleUnidadeChange = (e) => {
        setSelectedUnidade(e.target.value);
        setFormData(prev => ({ ...prev, lotacao_id: '' }));
    };

    const handleSupervisorCreated = async (newSupervisor) => {
        try {
            // Re-busca a lista para garantir que todos os dados (incluindo relacionamentos) estejam presentes
            const supRes = await listSupervisors();
            setSupervisors(supRes.data);
        } catch (err) {
            // Fallback para atualização manual se a busca falhar
            if (newSupervisor) {
                setSupervisors(prev => [...prev, newSupervisor]);
            }
        }
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        if (!hasSupervisors) {
            setError('Não é possível criar uma vaga sem supervisores na subunidade.');
            return;
        }

        setIsLoading(true);
        try {
            if (isEditing) {
                await updatePosition(id, formData);
            } else {
                await createPosition(formData);
            }
            navigate('/positions');
        } catch (err) {
            setError('Erro ao salvar vaga.');
        } finally {
            setIsLoading(false);
        }
    };

    return (
        <div className="max-w-3xl mx-auto space-y-6">
            <PageHeader
                title={isEditing ? "Editar Vaga" : "Nova Vaga de Estágio"}
                backUrl="/positions"
            />

            <div className="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <form onSubmit={handleSubmit} className="space-y-6">
                    {error && (
                        <div className="p-4 bg-red-50 text-red-600 rounded-xl flex items-center gap-3">
                            <AlertCircle size={20} />
                            <p className="text-sm font-medium">{error}</p>
                        </div>
                    )}

                    <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <Select
                            id="unidade"
                            label="Unidade / Regional"
                            value={selectedUnidade}
                            onChange={handleUnidadeChange}
                            options={unidades}
                            required
                        />
                        <Select
                            id="lotacao_id"
                            label="Subunidade / Setor"
                            value={formData.lotacao_id}
                            onChange={handleChange}
                            options={subunidades}
                            disabled={!selectedUnidade}
                            required
                        />
                    </div>

                    {/* Alerta de Supervisor */}
                    {formData.lotacao_id && !hasSupervisors && (
                        <div className="p-4 bg-amber-50 border border-amber-200 rounded-xl flex flex-col sm:flex-row items-center justify-between gap-4">
                            <div className="flex items-center gap-3 text-amber-700">
                                <AlertCircle size={24} />
                                <p className="text-sm font-semibold">Nenhum supervisor cadastrado para este setor.</p>
                            </div>
                            <Button 
                                type="button" 
                                size="sm" 
                                className="bg-primary text-white hover:bg-brandText border-none shrink-0"
                                onClick={() => setIsModalOpen(true)}
                            >
                                <PlusCircle size={16} className="mr-2" />
                                Cadastrar Agora
                            </Button>
                        </div>
                    )}

                    {formData.lotacao_id && hasSupervisors && (
                        <div className="p-3 bg-emerald-50 text-emerald-700 rounded-xl flex items-center gap-2 border border-emerald-100">
                            <CheckCircle2 size={18} />
                            <p className="text-xs font-bold uppercase tracking-wider">Setor apto para receber estagiários</p>
                        </div>
                    )}

                    <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <Input
                            id="quantidade"
                            label="Quantidade de Vagas"
                            type="number"
                            min="1"
                            value={formData.quantidade}
                            onChange={handleChange}
                            required
                        />
                        <Input
                            id="remuneracao_base"
                            label="Bolsa Auxílio Sugerida (R$)"
                            type="number"
                            step="0.01"
                            value={formData.remuneracao_base}
                            onChange={handleChange}
                            placeholder="Ex: 1200.00"
                        />
                    </div>

                    <div className="space-y-2">
                        <label className="block text-sm font-medium text-gray-700">Requisitos / Perfil Desejado</label>
                        <textarea
                            id="requisitos"
                            rows="4"
                            className="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all"
                            placeholder="Ex: Estudante de Administração a partir do 4º semestre..."
                            value={formData.requisitos}
                            onChange={handleChange}
                        />
                    </div>

                    <div className="flex justify-end pt-4 gap-3">
                        <Button type="button" variant="secondary" onClick={() => navigate('/positions')}>
                            Cancelar
                        </Button>
                        <Button 
                            type="submit" 
                            isLoading={isLoading} 
                            disabled={isLoading || (formData.lotacao_id && !hasSupervisors)}
                        >
                            {isEditing ? "Atualizar Vaga" : "Publicar Vaga"}
                        </Button>
                    </div>
                </form>
            </div>

            <QuickSupervisorModal
                isOpen={isModalOpen}
                onClose={() => setIsModalOpen(false)}
                onCreated={handleSupervisorCreated}
                lotacaoId={formData.lotacao_id}
            />
        </div>
    );
};

export default PositionForm;
