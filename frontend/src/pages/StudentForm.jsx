import React, { useState, useEffect } from 'react';
import { useNavigate, useParams } from 'react-router-dom';
import PageHeader from '../components/ui/PageHeader';
import Input from '../components/ui/Input';
import Button from '../components/ui/Button';
import { createStudent, updateStudent, listStudents } from '../services/api';

const StudentForm = () => {
    const navigate = useNavigate();
    const { id } = useParams();
    const isEditing = !!id;
    const [isLoading, setIsLoading] = useState(false);
    const [formData, setFormData] = useState({
        nome: '',
        cpf: '',
        curso: '',
        semestre: '',
        previsao_formatura: '',
        dados_bancarios: '',
    });
    const [error, setError] = useState('');

    useEffect(() => {
        if (isEditing) {
            setIsLoading(true);
            listStudents()
                .then(res => {
                    const student = res.data.find(s => String(s.id) === String(id));
                    if (student) {
                        setFormData({
                            nome: student.nome || '',
                            cpf: student.cpf || '',
                            curso: student.curso || '',
                            semestre: student.semestre || '',
                            previsao_formatura: student.previsao_formatura || '',
                            dados_bancarios: student.dados_bancarios || '',
                        });
                    } else {
                        setError('Estudante não encontrado.');
                    }
                })
                .catch(err => {
                    console.error(err);
                    setError('Erro ao carregar dados do estudante.');
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
                await updateStudent(id, formData);
            } else {
                await createStudent(formData);
            }
            navigate('/students');
        } catch (err) {
            console.error(err);
            setError(`Erro ao ${isEditing ? 'atualizar' : 'cadastrar'} estudante. Verifique os dados e tente novamente.`);
        } finally {
            setIsLoading(false);
        }
    };

    return (
        <>
            <PageHeader
                title={isEditing ? "Editar Estudante" : "Novo Estudante"}
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
                        <Button type="submit" isLoading={isLoading} disabled={isLoading}>
                            {isEditing ? "Atualizar Estudante" : "Salvar Estudante"}
                        </Button>
                    </div>
                </form>
            </div>
        </>
    );
};

export default StudentForm;
