import React, { useState, useEffect } from 'react';
import { useNavigate, useParams } from 'react-router-dom';
import Layout from '../components/Layout';
import PageHeader from '../components/ui/PageHeader';
import Input from '../components/ui/Input';
import Select from '../components/ui/Select';
import Button from '../components/ui/Button';
import { createContract, updateContract, listContracts, listStudents, listInstitutions, listSupervisors } from '../services/api';

const ContractForm = () => {
    const navigate = useNavigate();
    const { id } = useParams();
    const isEditing = !!id;
    const [isLoading, setIsLoading] = useState(false);
    const [loadingDeps, setLoadingDeps] = useState(true);

    // Dependencies
    const [students, setStudents] = useState([]);
    const [institutions, setInstitutions] = useState([]);
    const [supervisors, setSupervisors] = useState([]);

    const [formData, setFormData] = useState({
        student_id: '',
        institution_id: '',
        supervisor_id: '',
        data_inicio: '',
        data_fim: '',
        valor_bolsa: '',
        valor_transporte: '',
        apolice_seguro: '',
        status: 'Ativo'
    });
    const [error, setError] = useState('');

    useEffect(() => {
        const fetchDependencies = async () => {
            try {
                const [studentsRes, institutionsRes, supervisorsRes, contractsRes] = await Promise.all([
                    listStudents(),
                    listInstitutions(),
                    listSupervisors(),
                    isEditing ? listContracts() : Promise.resolve({ data: [] })
                ]);
                setStudents(studentsRes.data);
                setInstitutions(institutionsRes.data);
                setSupervisors(supervisorsRes.data);

                if (isEditing) {
                    const contract = contractsRes.data.find(c => String(c.id) === String(id));
                    if (contract) {
                        setFormData({
                            student_id: contract.student_id || '',
                            institution_id: contract.institution_id || '',
                            supervisor_id: contract.supervisor_id || '',
                            data_inicio: contract.data_inicio || '',
                            data_fim: contract.data_fim || '',
                            valor_bolsa: contract.valor_bolsa || '',
                            valor_transporte: contract.valor_transporte || '',
                            apolice_seguro: contract.apolice_seguro || '',
                            status: contract.status || 'Ativo'
                        });
                    } else {
                        setError('Contrato não encontrado.');
                    }
                }

            } catch (err) {
                console.error("Failed to load dependencies", err);
                setError('Erro ao carregar dados necessários.');
            } finally {
                setLoadingDeps(false);
            }
        };

        fetchDependencies();
    }, []);

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
                await updateContract(id, formData);
            } else {
                await createContract(formData);
            }
            navigate('/contracts');
        } catch (err) {
            console.error(err);
            setError(`Erro ao ${isEditing ? 'atualizar' : 'criar'} contrato. Verifique os dados e tente novamente.`);
        } finally {
            setIsLoading(false);
        }
    };

    if (loadingDeps) {
        return (
            <div className="flex justify-center items-center h-64">
                <div className="animate-spin rounded-full h-8 w-8 border-b-2 border-primary"></div>
            </div>
        );
    }

    return (
        <>
            <PageHeader
                title={isEditing ? "Editar Contrato" : "Novo Contrato"}
                backUrl="/contracts"
            />

            <div className="bg-white rounded-lg shadow-sm border border-gray-100 p-6 max-w-3xl mx-auto">
                {error && (
                    <div className="mb-4 p-4 bg-red-50 text-red-600 rounded-lg text-sm">
                        {error}
                    </div>
                )}

                <form onSubmit={handleSubmit}>
                    <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <Select
                            id="student_id"
                            label="Estudante *"
                            value={formData.student_id}
                            onChange={handleChange}
                            required
                            options={students.map(s => ({ value: s.id, label: s.nome }))}
                        />
                        <Select
                            id="institution_id"
                            label="Empresa *"
                            value={formData.institution_id}
                            onChange={handleChange}
                            required
                            options={institutions.map(i => ({ value: i.id, label: i.razao_social }))}
                        />
                    </div>

                    <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <Select
                            id="supervisor_id"
                            label="Supervisor *"
                            value={formData.supervisor_id}
                            onChange={handleChange}
                            required
                            options={supervisors.map(s => ({ value: s.id, label: s.nome }))}
                        />
                        <Select
                            id="status"
                            label="Status do Contrato"
                            value={formData.status}
                            onChange={handleChange}
                            options={[
                                { value: 'Ativo', label: 'Ativo' },
                                { value: 'Encerrado', label: 'Encerrado' }
                            ]}
                        />
                    </div>

                    <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <Input
                            id="data_inicio"
                            label="Data Início *"
                            type="date"
                            value={formData.data_inicio}
                            onChange={handleChange}
                            required
                        />
                        <Input
                            id="data_fim"
                            label="Data Fim *"
                            type="date"
                            value={formData.data_fim}
                            onChange={handleChange}
                            required
                        />
                    </div>

                    <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <Input
                            id="valor_bolsa"
                            label="Valor Bolsa (R$)"
                            type="number" step="0.01"
                            value={formData.valor_bolsa}
                            onChange={handleChange}
                            placeholder="0.00"
                        />
                        <Input
                            id="valor_transporte"
                            label="Valor Transporte (R$)"
                            type="number" step="0.01"
                            value={formData.valor_transporte}
                            onChange={handleChange}
                            placeholder="0.00"
                        />
                    </div>

                    <Input
                        id="apolice_seguro"
                        label="Apólice de Seguro"
                        value={formData.apolice_seguro}
                        onChange={handleChange}
                        placeholder="Número da apólice e Seguradora"
                    />

                    <div className="flex justify-end mt-6">
                        <Button type="button" variant="secondary" className="mr-3" onClick={() => navigate('/contracts')}>
                            Cancelar
                        </Button>
                        <Button type="submit" isLoading={isLoading} disabled={isLoading}>
                            {isEditing ? "Atualizar Contrato" : "Criar Contrato"}
                        </Button>
                    </div>
                </form>
            </div>
        </>
    );
};

export default ContractForm;
