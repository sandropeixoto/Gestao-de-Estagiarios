import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import Layout from '../components/Layout';
import PageHeader from '../components/ui/PageHeader';
import Input from '../components/ui/Input';
import Button from '../components/ui/Button';
import { createStudent } from '../services/api';

const StudentForm = () => {
    const navigate = useNavigate();
    const [isLoading, setIsLoading] = useState(false);
    const [formData, setFormData] = useState({
        nome: '',
        cpf: '',
        curso: '',
        semestre: '',
        previsao_formatura: '',
        dados_bancarios: '',
        // dados_bancarios: {
        //     banco: '',
        //     agencia: '',
        //     conta: '',
        //     pix: ''
        // } 
        // Keeping it simple as text for now as per schema
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
            await createStudent(formData);
            navigate('/students');
        } catch (err) {
            console.error(err);
            setError('Erro ao cadastrar estudante. Verifique os dados e tente novamente.');
        } finally {
            setIsLoading(false);
        }
    };

    return (
        <Layout>
            <PageHeader
                title="Novo Estudante"
                backUrl="/students"
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
                        placeholder="Ex: Ana Silva"
                    />

                    <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <Input
                            id="cpf"
                            label="CPF *"
                            value={formData.cpf}
                            onChange={handleChange}
                            required
                            placeholder="000.000.000-00"
                        />
                        <Input
                            id="curso"
                            label="Curso"
                            value={formData.curso}
                            onChange={handleChange}
                            placeholder="Ex: Engenharia Civil"
                        />
                    </div>

                    <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <Input
                            id="semestre"
                            label="Semestre"
                            type="number"
                            value={formData.semestre}
                            onChange={handleChange}
                            placeholder="Ex: 5"
                        />
                        <Input
                            id="previsao_formatura"
                            label="Previsão de Formatura"
                            type="date"
                            value={formData.previsao_formatura}
                            onChange={handleChange}
                        />
                    </div>

                    <Input
                        id="dados_bancarios"
                        label="Dados Bancários"
                        value={formData.dados_bancarios}
                        onChange={handleChange}
                        placeholder="Ex: Banco X, Ag 000, CC 000-0, PIX: chave"
                    />

                    <div className="flex justify-end mt-6">
                        <Button type="button" variant="secondary" className="mr-3" onClick={() => navigate('/students')}>
                            Cancelar
                        </Button>
                        <Button type="submit" isLoading={isLoading}>
                            Salvar Estudante
                        </Button>
                    </div>
                </form>
            </div>
        </Layout>
    );
};

export default StudentForm;
