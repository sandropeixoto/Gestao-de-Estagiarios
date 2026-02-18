import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import Layout from '../components/Layout';
import PageHeader from '../components/ui/PageHeader';
import Input from '../components/ui/Input';
import Button from '../components/ui/Button';
import { createSupervisor } from '../services/api';

const SupervisorForm = () => {
    const navigate = useNavigate();
    const [isLoading, setIsLoading] = useState(false);
    const [formData, setFormData] = useState({
        nome: '',
        cargo: '',
        area: ''
    });
    const [error, setError] = useState('');

    const handleChange = (e) => {
        const { id, value } = e.target;
        setFormData(prev => ({ ...prev, [id]: value }));
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        setIsLoading(true);
        setError('');

        try {
            await createSupervisor(formData);
            navigate('/supervisors');
        } catch (err) {
            console.error(err);
            setError('Erro ao cadastrar supervisor. Verifique os dados e tente novamente.');
        } finally {
            setIsLoading(false);
        }
    };

    return (
        <>
            <PageHeader
                title="Novo Supervisor"
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
                        <Button type="submit" isLoading={isLoading}>
                            Salvar Supervisor
                        </Button>
                    </div>
                </form>
            </div>
        </>
    );
};

export default SupervisorForm;
