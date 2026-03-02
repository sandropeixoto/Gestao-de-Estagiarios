import React, { useState } from 'react';
import Modal from './ui/Modal';
import Input from './ui/Input';
import Button from './ui/Button';
import { createSupervisor } from '../services/api';

const QuickSupervisorModal = ({ isOpen, onClose, onCreated, lotacaoId }) => {
    const [isLoading, setIsLoading] = useState(false);
    const [error, setError] = useState('');
    const [formData, setFormData] = useState({
        nome: '',
        cargo: '',
        email: ''
    });

    const handleChange = (e) => {
        const { id, value } = e.target;
        setFormData(prev => ({ ...prev, [id]: value }));
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        setIsLoading(true);
        setError('');

        try {
            const res = await createSupervisor({
                ...formData,
                lotacao_id: lotacaoId
            });
            onCreated(res.data.data); // Dependendo do formato da resposta do controller
            setFormData({ nome: '', cargo: '', email: '' });
            onClose();
        } catch (err) {
            console.error(err);
            setError('Erro ao cadastrar supervisor rápido.');
        } finally {
            setIsLoading(false);
        }
    };

    return (
        <Modal
            isOpen={isOpen}
            onClose={onClose}
            title="Cadastrar Supervisor"
            footer={
                <div className="flex gap-3">
                    <Button variant="secondary" onClick={onClose}>Cancelar</Button>
                    <Button onClick={handleSubmit} isLoading={isLoading}>Salvar e Selecionar</Button>
                </div>
            }
        >
            <form onSubmit={handleSubmit} className="space-y-4">
                {error && (
                    <div className="p-3 bg-red-50 text-red-600 rounded-lg text-sm">
                        {error}
                    </div>
                )}
                <Input
                    id="nome"
                    label="Nome Completo"
                    value={formData.nome}
                    onChange={handleChange}
                    required
                />
                <Input
                    id="cargo"
                    label="Cargo"
                    value={formData.cargo}
                    onChange={handleChange}
                />
                <Input
                    id="email"
                    label="E-mail"
                    type="email"
                    value={formData.email}
                    onChange={handleChange}
                />
            </form>
        </Modal>
    );
};

export default QuickSupervisorModal;
