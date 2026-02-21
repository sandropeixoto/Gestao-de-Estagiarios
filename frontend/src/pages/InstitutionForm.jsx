import React, { useState, useEffect } from 'react';
import { useNavigate, useParams } from 'react-router-dom';
import Layout from '../components/Layout';
import PageHeader from '../components/ui/PageHeader';
import Input from '../components/ui/Input';
import Select from '../components/ui/Select';
import Button from '../components/ui/Button';
import { createInstitution, updateInstitution, listInstitutions } from '../services/api';

const InstitutionForm = () => {
    const navigate = useNavigate();
    const { id } = useParams();
    const isEditing = !!id;
    const [isLoading, setIsLoading] = useState(false);
    const [formData, setFormData] = useState({
        razao_social: '',
        cnpj: '',
        coordenador_responsavel: '',
        status_convenio: 'Ativo'
    });
    const [error, setError] = useState('');

    useEffect(() => {
        if (isEditing) {
            setIsLoading(true);
            listInstitutions()
                .then(res => {
                    const institution = res.data.find(i => String(i.id) === String(id));
                    if (institution) {
                        setFormData({
                            razao_social: institution.razao_social || '',
                            cnpj: institution.cnpj || '',
                            coordenador_responsavel: institution.coordenador_responsavel || '',
                            status_convenio: institution.status_convenio || 'Ativo'
                        });
                    } else {
                        setError('Instituição não encontrada.');
                    }
                })
                .catch(err => {
                    console.error(err);
                    setError('Erro ao carregar dados da instituição.');
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
                await updateInstitution(id, formData);
            } else {
                await createInstitution(formData);
            }
            navigate('/institutions');
        } catch (err) {
            console.error(err);
            setError(`Erro ao ${isEditing ? 'atualizar' : 'cadastrar'} empresa. Verifique os dados e tente novamente.`);
        } finally {
            setIsLoading(false);
        }
    };

    return (
        <>
            <PageHeader
                title={isEditing ? "Editar Empresa" : "Nova Empresa"}
                backUrl="/institutions"
            />

            <div className="bg-white rounded-lg shadow-sm border border-gray-100 p-6 max-w-2xl mx-auto">
                {error && (
                    <div className="mb-4 p-4 bg-red-50 text-red-600 rounded-lg text-sm">
                        {error}
                    </div>
                )}

                <form onSubmit={handleSubmit}>
                    <Input
                        id="razao_social"
                        label="Razão Social *"
                        value={formData.razao_social}
                        onChange={handleChange}
                        required
                        placeholder="Ex: Tech Solutions Ltda"
                    />

                    <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <Input
                            id="cnpj"
                            label="CNPJ *"
                            value={formData.cnpj}
                            onChange={handleChange}
                            required
                            placeholder="00.000.000/0000-00"
                        />
                        <Select
                            id="status_convenio"
                            label="Status do Convênio"
                            value={formData.status_convenio}
                            onChange={handleChange}
                            options={[
                                { value: 'Ativo', label: 'Ativo' },
                                { value: 'Inativo', label: 'Inativo' }
                            ]}
                        />
                    </div>

                    <Input
                        id="coordenador_responsavel"
                        label="Coordenador Responsável"
                        value={formData.coordenador_responsavel}
                        onChange={handleChange}
                        placeholder="Nome do responsável pelo estágio na empresa"
                    />

                    <div className="flex justify-end mt-6">
                        <Button type="button" variant="secondary" className="mr-3" onClick={() => navigate('/institutions')}>
                            Cancelar
                        </Button>
                        <Button type="submit" isLoading={isLoading} disabled={isLoading}>
                            {isEditing ? "Atualizar Empresa" : "Salvar Empresa"}
                        </Button>
                    </div>
                </form>
            </div>
        </>
    );
};

export default InstitutionForm;
