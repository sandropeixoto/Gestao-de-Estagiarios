import React, { useState, useEffect } from 'react';
import { useNavigate, useParams } from 'react-router-dom';
import Layout from '../components/Layout';
import PageHeader from '../components/ui/PageHeader';
import Input from '../components/ui/Input';
import Button from '../components/ui/Button';
import { createSupervisor, updateSupervisor, listSupervisors } from '../services/api';

const SupervisorForm = () => {
    const navigate = useNavigate();
    const { id } = useParams();
    const isEditing = !!id;
    const [isLoading, setIsLoading] = useState(false);
    const [formData, setFormData] = useState({
        nome: '',
        cargo: '',
        area: ''
    });
    const [error, setError] = useState('');

    useEffect(() => {
        if (isEditing) {
            setIsLoading(true);
            listSupervisors()
                .then(res => {
                    const supervisor = res.data.find(s => String(s.id) === String(id));
                    if (supervisor) {
                        setFormData({
                            nome: supervisor.nome || '',
                            cargo: supervisor.cargo || '',
                            area: supervisor.area || ''
                        });
                    } else {
                        setError('Supervisor não encontrado.');
                    }
                })
                .catch(err => {
                    console.error(err);
                    setError('Erro ao carregar dados do supervisor.');
                })
                .finally(() => setIsLoading(false));
        }
    }, [id, isEditing]);

    const handleChange = (e) => {
        const { id, value } = e.target;
        setFormData(prev => ({ ...prev, [id]: value }));
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        setIsLoading(true);
        setError('');

        try {
            if (isEditing) {
                await updateSupervisor(id, formData);
            } else {
                await createSupervisor(formData);
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
