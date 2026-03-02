import React, { useState, useEffect } from 'react';
import { useNavigate, useParams } from 'react-router-dom';
import Layout from '../components/Layout';
import PageHeader from '../components/ui/PageHeader';
import Input from '../components/ui/Input';
import Button from '../components/ui/Button';
import Select from '../components/ui/Select';
import { createSupervisor, updateSupervisor, listSupervisors, listLotacoes } from '../services/api';

const SupervisorForm = () => {
    const navigate = useNavigate();
    const { id } = useParams();
    const isEditing = !!id;
    const [isLoading, setIsLoading] = useState(false);
    const [lotacoes, setLotacoes] = useState([]);
    const [formData, setFormData] = useState({
        nome: '',
        cargo: '',
        area: '',
        lotacao_id: ''
    });
    const [selectedUnidade, setSelectedUnidade] = useState('');
    const [error, setError] = useState('');

    useEffect(() => {
        setIsLoading(true);
        const fetchData = async () => {
            try {
                const lotacoesRes = await listLotacoes();
                setLotacoes(lotacoesRes.data);

                if (isEditing) {
                    const supervisorsRes = await listSupervisors();
                    const supervisor = supervisorsRes.data.find(s => String(s.id) === String(id));
                    if (supervisor) {
                        setFormData({
                            nome: supervisor.nome || '',
                            cargo: supervisor.cargo || '',
                            area: supervisor.area || '',
                            lotacao_id: supervisor.lotacao_id || ''
                        });
                        
                        if (supervisor.lotacao_id) {
                            const currentLotacao = lotacoesRes.data.find(l => String(l.id) === String(supervisor.lotacao_id));
                            if (currentLotacao) {
                                setSelectedUnidade(currentLotacao.unidade);
                            }
                        }
                    } else {
                        setError('Supervisor não encontrado.');
                    }
                }
            } catch (err) {
                console.error(err);
                setError('Erro ao carregar dados necessários.');
            } finally {
                setIsLoading(false);
            }
        };

        fetchData();
    }, [id, isEditing]);

    const unidades = [...new Set(lotacoes.map(l => l.unidade))].sort().map(u => ({ value: u, label: u }));
    const subunidades = lotacoes
        .filter(l => l.unidade === selectedUnidade)
        .sort((a, b) => a.subunidade.localeCompare(b.subunidade))
        .map(l => ({ value: l.id, label: l.subunidade }));

    const handleChange = (e) => {
        const { id, value } = e.target;
        setFormData(prev => ({ ...prev, [id]: value }));
    };

    const handleUnidadeChange = (e) => {
        setSelectedUnidade(e.target.value);
        setFormData(prev => ({ ...prev, lotacao_id: '' }));
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        setIsLoading(true);
        setError('');

        const dataToSave = {
            nome: formData.nome,
            cargo: formData.cargo,
            area: formData.area,
            lotacao_id: formData.lotacao_id || null
        };

        try {
            if (isEditing) {
                await updateSupervisor(id, dataToSave);
            } else {
                await createSupervisor(dataToSave);
            }
            navigate('/supervisors');
        } catch (err) {
            console.error(err);
            setError(`Erro ao ${isEditing ? 'atualizar' : 'cadastrar'} supervisor. Verifique os dados e tente novamente.`);
        } finally {
            setIsLoading(false);
        }
    };

    return (
        <>
            <PageHeader
                title={isEditing ? "Editar Supervisor" : "Novo Supervisor"}
                backUrl="/supervisors"
            />

            <div className="bg-white rounded-lg shadow-sm border border-gray-100 p-6 max-w-2xl mx-auto">
                {error && (
                    <div className="mb-4 p-4 bg-red-50 text-red-600 rounded-lg text-sm">
                        {error}
                    </div>
                )}

                <form onSubmit={handleSubmit}>
                    <Input
                        id="nome"
                        label="Nome Completo *"
                        value={formData.nome}
                        onChange={handleChange}
                        required
                        placeholder="Ex: Carlos Oliveira"
                    />

                    <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <Input
                            id="cargo"
                            label="Cargo"
                            value={formData.cargo}
                            onChange={handleChange}
                            placeholder="Ex: Gerente de TI"
                        />
                        <Input
                            id="area"
                            label="Área / Departamento"
                            value={formData.area}
                            onChange={handleChange}
                            placeholder="Ex: Tecnologia"
                        />
                    </div>

                    <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <Select
                            id="unidade"
                            label="Unidade"
                            value={selectedUnidade}
                            onChange={handleUnidadeChange}
                            options={unidades}
                        />
                        <Select
                            id="lotacao_id"
                            label="Subunidade"
                            value={formData.lotacao_id}
                            onChange={handleChange}
                            options={subunidades}
                            disabled={!selectedUnidade}
                        />
                    </div>

                    <div className="flex justify-end mt-6">
                        <Button type="button" variant="secondary" className="mr-3" onClick={() => navigate('/supervisors')}>
                            Cancelar
                        </Button>
                        <Button type="submit" isLoading={isLoading} disabled={isLoading}>
                            {isEditing ? "Atualizar Supervisor" : "Salvar Supervisor"}
                        </Button>
                    </div>
                </form>
            </div>
        </>
    );
};

export default SupervisorForm;
