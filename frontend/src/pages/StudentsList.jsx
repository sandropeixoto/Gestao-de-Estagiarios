import React, { useState, useEffect } from 'react';
import { listStudents, deleteStudent } from '../services/api';
import { Link, useNavigate } from 'react-router-dom';
import { Plus, Pencil, Trash2 } from 'lucide-react';
import PageHeader from '../components/ui/PageHeader';
import Button from '../components/ui/Button';

const StudentsList = () => {
    const [students, setStudents] = useState([]);

    const navigate = useNavigate();

    const fetchStudents = () => {
        listStudents().then(res => setStudents(res.data)).catch(console.error);
    };

    useEffect(() => {
        fetchStudents();
    }, []);

    const handleDelete = async (id) => {
        if (window.confirm('Tem certeza que deseja excluir este estudante?')) {
            try {
                await deleteStudent(id);
                fetchStudents();
            } catch (error) {
                console.error('Failed to delete student', error);
                alert('Erro ao excluir estudante.');
            }
        }
    };

    return (
        <div className="space-y-6">
            <PageHeader
                title="Estudantes"
                action={
                    <Link to="/student/new">
                        <Button>
                            <Plus className="w-4 h-4 mr-2" />
                            Novo Estudante
                        </Button>
                    </Link>
                }
            />

            <div className="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <table className="min-w-full divide-y divide-gray-200">
                    <thead className="bg-gray-50">
                        <tr>
                            <th className="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Nome</th>
                            <th className="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">CPF</th>
                            <th className="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Curso</th>
                            <th className="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Ações</th>
                        </tr>
                    </thead>
                    <tbody className="bg-white divide-y divide-gray-200">
                        {students.map(s => (
                            <tr key={s.id} className="hover:bg-gray-50 transition-colors">
                                <td className="px-6 py-4 whitespace-nowrap text-gray-900 font-medium">{s.nome}</td>
                                <td className="px-6 py-4 whitespace-nowrap text-gray-500">{s.cpf}</td>
                                <td className="px-6 py-4 whitespace-nowrap text-gray-500">{s.curso}</td>
                                <td className="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button onClick={() => navigate(`/student/edit/${s.id}`)} className="text-indigo-600 hover:text-indigo-900 mr-4">
                                        <Pencil className="w-4 h-4 inline" />
                                    </button>
                                    <button onClick={() => handleDelete(s.id)} className="text-red-600 hover:text-red-900">
                                        <Trash2 className="w-4 h-4 inline" />
                                    </button>
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
                {students.length === 0 && <div className="p-6 text-center text-gray-500">Nenhum estudante encontrado.</div>}
            </div>
        </div>
    );
};

export default StudentsList;
