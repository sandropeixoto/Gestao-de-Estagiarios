import { useState, useEffect } from 'react';
import { registerTimeSheet } from '../services/api';

const InternDashboard = () => {
    const [location, setLocation] = useState(null);
    const [status, setStatus] = useState('');
    const [contractId, setContractId] = useState(1); // Mock contract ID
    const [vacationBalance, setVacationBalance] = useState(5.0); // Mock balance
    const [isExamDay, setIsExamDay] = useState(false);

    useEffect(() => {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    setLocation({
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    });
                },
                (error) => {
                    console.error("Error getting location", error);
                }
            );
        }
    }, []);

    const handleClockIn = async () => {
        if (!location) {
            alert("Localização necessária para bater ponto.");
            return;
        }

        const now = new Date();
        const data = {
            contract_id: contractId,
            date: now.toISOString().split('T')[0],
            hora_entrada: now.toTimeString().split(' ')[0],
            hora_saida: null, // Logic for clock out would be separate or update
            geolocalizacao: `${location.lat},${location.lng}`,
            is_dia_prova: isExamDay
        };

        // For demo, we just send entrance. Real world needs check state.
        // Assuming this is just "Register Time" action for now.
        // If we want clock-out, we'd need to fetch current state.

        // Let's simulate a full record for now or just the action
        // The backend expects entry and exit for validation in one go or update?
        // The current backend registers a FULL timesheet with entry and exit.
        // I should update backend to allow partial updates or just send entry/exit.
        // PROPOSAL: Frontend sends full timesheet after "Clock Out".
        // OR: Frontend sends entry, then update with exit.
        // Current backend: `timesheets` table has entry and exit columns. `register` method checks diff.
        // So I'll modify the frontend to simulate sending hours (e.g. 6h worked) for testing, 
        // OR I'll assume the user inputs entry and exit times manually/automatically.

        // Let's make it inputs for now for MVP validation of rules.
        alert("Ponto registrado (Simulação)");

        // Call API (will fail without real backend running on port 8000)
        /*
        try {
            await registerTimeSheet(data);
            setStatus('Ponto registrado com sucesso!');
        } catch (error) {
            setStatus('Erro ao registrar ponto: ' + (error.response?.data?.message || error.message));
        }
        */
    };

    // Quick form for testing backend logic
    const [entry, setEntry] = useState("09:00");
    const [exit, setExit] = useState("15:00");

    const handleSubmit = async (e) => {
        e.preventDefault();
        const data = {
            contract_id: contractId,
            date: new Date().toISOString().split('T')[0],
            hora_entrada: entry,
            hora_saida: exit,
            geolocalizacao: location ? `${location.lat},${location.lng}` : "0,0",
            is_dia_prova: isExamDay
        };

        try {
            const response = await registerTimeSheet(data);
            setStatus('Sucesso: ' + response.data.message);
        } catch (error) {
            setStatus('Erro: ' + (error.response?.data?.message || error.message));
        }
    };

    return (
        <div className="min-h-screen bg-gray-50 flex flex-col items-center py-10 px-4">
            <h1 className="text-3xl font-bold text-gray-800 mb-6">Painel do Estagiário</h1>

            <div className="w-full max-w-md bg-white rounded-xl shadow-lg p-6 mb-6">
                <h2 className="text-xl font-semibold mb-4 text-gray-700">Saldo de Recesso</h2>
                <div className="flex items-center justify-between">
                    <span className="text-gray-500">Dias acumulados:</span>
                    <span className="text-2xl font-bold text-green-600">{vacationBalance} dias</span>
                </div>
            </div>

            <div className="w-full max-w-md bg-white rounded-xl shadow-lg p-6 mb-6">
                <h2 className="text-xl font-semibold mb-4 text-gray-700">Registrar Ponto</h2>

                <form onSubmit={handleSubmit} className="space-y-4">
                    <div>
                        <label className="block text-sm font-medium text-gray-700">Entrada</label>
                        <input type="time" value={entry} onChange={e => setEntry(e.target.value)} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-gray-50 p-2" />
                    </div>
                    <div>
                        <label className="block text-sm font-medium text-gray-700">Saída</label>
                        <input type="time" value={exit} onChange={e => setExit(e.target.value)} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-gray-50 p-2" />
                    </div>

                    <div className="flex items-center">
                        <input id="exam-day" type="checkbox" checked={isExamDay} onChange={e => setIsExamDay(e.target.checked)} className="h-4 w-4 text-indigo-600 border-gray-300 rounded" />
                        <label htmlFor="exam-day" className="ml-2 block text-sm text-gray-900">Hoje é dia de prova (Limite 3h)</label>
                    </div>

                    <button type="submit" className="w-full bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700 transition duration-200">
                        Registrar Frequência
                    </button>
                </form>

                {status && (
                    <div className={`mt-4 p-3 rounded text-center ${status.includes('Sucesso') ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}`}>
                        {status}
                    </div>
                )}
            </div>

            <div className="w-full max-w-md bg-white rounded-xl shadow-lg p-6">
                <h2 className="text-xl font-semibold mb-4 text-gray-700">Upload de Comprovantes</h2>
                <div className="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-indigo-500 transition cursor-pointer">
                    <p className="text-gray-500">Toque para enviar atestado ou calendário de provas</p>
                </div>
            </div>
        </div>
    );
};

export default InternDashboard;
