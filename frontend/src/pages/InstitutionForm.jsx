import { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { createInstitution } from '../services/api';

const InstitutionForm = () => {
    const navigate = useNavigate();
    const [formData, setFormData] = useState({
        razao_social: '',
        cnpj: '',
        coordenador_responsavel: ''
    });

    const handleSubmit = async (e) => {
        e.preventDefault();
        try {
            await createInstitution(formData);
            alert('Instituição cadastrada com sucesso!');
            navigate('/manager-dashboard');
        } catch (error) {
            alert('Erro ao cadastrar instituição');
        }
    };

    return (
        <div className="min-h-screen bg-gray-50 flex items-center justify-center p-4">
            <div className="bg-white p-8 rounded-xl shadow-md w-full max-w-md">
                <h2 className="text-2xl font-bold mb-6 text-gray-800">Nova Instituição</h2>
                <form onSubmit={handleSubmit} className="space-y-4">
                    <div>
                        <label className="block text-sm font-medium text-gray-700">Razão Social</label>
                        <input type="text" required className="w-full border p-2 rounded"
                            onChange={e => setFormData({ ...formData, razao_social: e.target.value })} />
                    </div>
                    <div>
                        <label className="block text-sm font-medium text-gray-700">CNPJ</label>
                        <input type="text" required className="w-full border p-2 rounded"
                            onChange={e => setFormData({ ...formData, cnpj: e.target.value })} />
                    </div>
                    <div>
                        <label className="block text-sm font-medium text-gray-700">Coordenador Responsável</label>
                        <input type="text" className="w-full border p-2 rounded"
                            onChange={e => setFormData({ ...formData, coordenador_responsavel: e.target.value })} />
                    </div>
                    <button type="submit" className="w-full bg-indigo-600 text-white p-2 rounded hover:bg-indigo-700">Salvar</button>
                    <button type="button" onClick={() => navigate('/manager-dashboard')} className="w-full bg-gray-200 text-gray-700 p-2 rounded hover:bg-gray-300">Cancelar</button>
                </form>
            </div>
        </div>
    );
};
export default InstitutionForm;
