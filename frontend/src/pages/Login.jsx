import { useNavigate } from 'react-router-dom';

const Login = () => {
    const navigate = useNavigate();

    return (
        <div className="min-h-screen bg-gray-100 flex items-center justify-center px-4">
            <div className="max-w-md w-full bg-white rounded-xl shadow-lg p-8">
                <div className="text-center mb-8">
                    <h1 className="text-3xl font-bold text-indigo-600">SGE Compliance</h1>
                    <p className="text-gray-500 mt-2">Sistema de Gestão de Estagiários</p>
                </div>

                <div className="space-y-4">
                    <button
                        onClick={() => navigate('/intern')}
                        className="w-full flex items-center justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 font-medium"
                    >
                        Entrar como Estagiário
                    </button>

                    <button
                        onClick={() => navigate('/manager')}
                        className="w-full flex items-center justify-center py-3 px-4 border border-gray-300 rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 font-medium"
                    >
                        Entrar como Gestor (RH)
                    </button>
                </div>
            </div>
        </div>
    );
};

export default Login;
