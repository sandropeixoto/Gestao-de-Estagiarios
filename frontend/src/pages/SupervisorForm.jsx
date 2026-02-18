import { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { createSupervisor } from '../services/api';

const SupervisorForm = () => {
    const navigate = useNavigate();
    const [formData, setFormData] = useState({
        nome: '',
        cargo: '',
        area: ''
    });

    const handleSubmit = async (e) => {
        e.preventDefault();
        try {
            await createSupervisor(formData);
            alert('Supervisor cadastrado com sucesso!');
            navigate('/manager-dashboard');
        } catch (error) {
            alert('Erro ao cadastrar supervisor');
        }
    };

    return (
        <div className="min-h-screen bg-gray-50 flex items-center justify-center p-4">
            <div className="bg-white p-8 rounded-xl shadow-md w-full max-w-md">
                <h2 className="text-2xl font-bold mb-6 text-gray-800">Novo Supervisor</h2>
                <form onSubmit={handleSubmit} className="space-y-4">
                    <div>
                        <label className="block text-sm font-medium text-gray-700">Nome Completo</label>
                        <input type="text" required className="w-full border p-2 rounded"
                            onChange={e => setFormData({ ...formData, nome: e.target.value })} />
                    </div>
                    <div>
                        <label className="block text-sm font-medium text-gray-700">Cargo</label>
                        <input type="text" required className="w-full border p-2 rounded"
                            onChange={e => setFormData({ ...formData, cargo: e.target.value })} />
                    </div>
                    <div>
                        <label className="block text-sm font-medium text-gray-700">Área</label>
                        <input type="text" required className="w-full border p-2 rounded"
                            onChange={e => setFormData({ ...formData, area: e.target.value })} />
                    </div>
                    <button type="submit" className="w-full bg-indigo-600 text-white p-2 rounded hover:bg-indigo-700">Salvar</button>
                    <button type="button" onClick={() => navigate('/manager-dashboard')} className="w-full bg-gray-200 text-gray-700 p-2 rounded hover:bg-gray-300">Cancelar</button>
                </form>
            </div>
        </div>
    );
};
export default SupervisorForm;
