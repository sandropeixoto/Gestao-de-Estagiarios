import { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { createStudent } from '../services/api';

const StudentForm = () => {
    const navigate = useNavigate();
    const [formData, setFormData] = useState({
        nome: '',
        cpf: '',
        curso: '',
        semestre: '',
        previsao_formatura: ''
    });

    const handleSubmit = async (e) => {
        e.preventDefault();
        try {
            await createStudent(formData);
            alert('Estudante cadastrado com sucesso!');
            navigate('/manager-dashboard');
        } catch (error) {
            alert('Erro ao cadastrar estudante');
        }
    };

    return (
        <div className="min-h-screen bg-gray-50 flex items-center justify-center p-4">
            <div className="bg-white p-8 rounded-xl shadow-md w-full max-w-md">
                <h2 className="text-2xl font-bold mb-6 text-gray-800">Novo Estudante</h2>
                <form onSubmit={handleSubmit} className="space-y-4">
                    <div>
                        <label className="block text-sm font-medium text-gray-700">Nome Completo</label>
                        <input type="text" required className="w-full border p-2 rounded"
                            onChange={e => setFormData({ ...formData, nome: e.target.value })} />
                    </div>
                    <div>
                        <label className="block text-sm font-medium text-gray-700">CPF</label>
                        <input type="text" required className="w-full border p-2 rounded"
                            onChange={e => setFormData({ ...formData, cpf: e.target.value })} />
                    </div>
                    <div>
                        <label className="block text-sm font-medium text-gray-700">Curso</label>
                        <input type="text" required className="w-full border p-2 rounded"
                            onChange={e => setFormData({ ...formData, curso: e.target.value })} />
                    </div>
                    <div className="flex gap-4">
                        <div className="w-1/2">
                            <label className="block text-sm font-medium text-gray-700">Semestre</label>
                            <input type="number" className="w-full border p-2 rounded"
                                onChange={e => setFormData({ ...formData, semestre: e.target.value })} />
                        </div>
                        <div className="w-1/2">
                            <label className="block text-sm font-medium text-gray-700">Prev. Formatura</label>
                            <input type="date" className="w-full border p-2 rounded"
                                onChange={e => setFormData({ ...formData, previsao_formatura: e.target.value })} />
                        </div>
                    </div>
                    <button type="submit" className="w-full bg-indigo-600 text-white p-2 rounded hover:bg-indigo-700">Salvar</button>
                    <button type="button" onClick={() => navigate('/manager-dashboard')} className="w-full bg-gray-200 text-gray-700 p-2 rounded hover:bg-gray-300">Cancelar</button>
                </form>
            </div>
        </div>
    );
};
export default StudentForm;
