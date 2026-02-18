import { useState } from 'react';

const FinancialModule = () => {
    const [month, setMonth] = useState(new Date().toISOString().slice(0, 7));
    const [receiptData, setReceiptData] = useState(null);

    const handleGenerateReceipt = () => {
        // Mock data generation
        // in real app, fetch from backend based on contract and attendance
        const mockData = {
            studentName: "João Silva",
            bolsa: 1200.00,
            transporte: 220.00,
            month: month,
            total: 1420.00
        };
        setReceiptData(mockData);
    };

    const handlePrint = () => {
        window.print();
    };

    return (
        <div className="min-h-screen bg-gray-50 py-10 px-4 flex flex-col items-center">
            <h1 className="text-3xl font-bold text-gray-800 mb-8 d-print-none">Financeiro - Recibo de Bolsa</h1>

            <div className="w-full max-w-md bg-white rounded-xl shadow-lg p-6 mb-6 d-print-none">
                <label className="block text-sm font-medium text-gray-700 mb-2">Selecione o Mês</label>
                <div className="flex gap-4">
                    <input
                        type="month"
                        value={month}
                        onChange={(e) => setMonth(e.target.value)}
                        className="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-gray-50 p-2"
                    />
                    <button
                        onClick={handleGenerateReceipt}
                        className="bg-indigo-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-indigo-700"
                    >
                        Gerar
                    </button>
                </div>
            </div>

            {receiptData && (
                <div className="w-full max-w-2xl bg-white border border-gray-200 p-8 shadow-sm print:shadow-none print:border-none print:w-full">
                    <div className="text-center border-b pb-4 mb-6">
                        <h2 className="text-2xl font-bold text-gray-800">Recibo de Pagamento de Bolsa-Estágio</h2>
                        <p className="text-gray-500">{receiptData.month}</p>
                    </div>

                    <div className="space-y-4 mb-8">
                        <div className="flex justify-between">
                            <span className="font-semibold text-gray-700">Estagiário:</span>
                            <span>{receiptData.studentName}</span>
                        </div>
                        <div className="flex justify-between">
                            <span className="font-semibold text-gray-700">Bolsa-Auxílio:</span>
                            <span>R$ {receiptData.bolsa.toFixed(2)}</span>
                        </div>
                        <div className="flex justify-between">
                            <span className="font-semibold text-gray-700">Auxílio Transporte:</span>
                            <span>R$ {receiptData.transporte.toFixed(2)}</span>
                        </div>

                        <div className="border-t pt-2 mt-4 flex justify-between items-center bg-gray-50 p-2 rounded">
                            <span className="font-bold text-gray-800 text-lg">Líquido a Receber:</span>
                            <span className="font-bold text-green-600 text-lg">R$ {receiptData.total.toFixed(2)}</span>
                        </div>
                        <p className="text-xs text-gray-500 mt-1">* Isento de descontos de INSS e FGTS conforme Lei 11.788/2008.</p>
                    </div>

                    <div className="mt-12 pt-8 border-t border-gray-300 flex justify-between text-sm text-gray-500">
                        <div className="text-center w-1/3">
                            <div className="border-b border-gray-400 mb-2 h-8"></div>
                            Assinatura da Empresa
                        </div>
                        <div className="text-center w-1/3">
                            <div className="border-b border-gray-400 mb-2 h-8"></div>
                            Assinatura do Estagiário
                        </div>
                    </div>

                    <div className="mt-8 text-center d-print-none">
                        <button
                            onClick={handlePrint}
                            className="bg-gray-800 text-white px-6 py-2 rounded-lg font-semibold hover:bg-gray-900"
                        >
                            Imprimir Recibo
                        </button>
                    </div>
                </div>
            )}

            <style>{`
                @media print {
                    .d-print-none { display: none !important; }
                    body { background-color: white; }
                    .shadow-lg, .shadow-sm { box-shadow: none !important; }
                }
            `}</style>
        </div>
    );
};

export default FinancialModule;
