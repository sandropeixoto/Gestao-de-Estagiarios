import React, { useState, useEffect } from 'react';
import { Users, FileText, AlertCircle, TrendingUp } from 'lucide-react';
import { getManagerDashboardData } from '../services/api';
import KPICard from '../components/KPICard';
import { ContractsChart, StudentsPieChart } from '../components/DashboardCharts';

const DashboardOverview = () => {
    const [data, setData] = useState(null);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        const load = async () => {
            try {
                const res = await getManagerDashboardData();
                setData(res.data);
            } catch (error) {
                console.error("Dashboard error", error);
            } finally {
                setLoading(false);
            }
        };
        load();
    }, []);

    if (loading) return <div className="p-10 text-center text-primary">Carregando dashboard...</div>;
    if (!data) return <div className="p-10 text-center text-red-500">Erro ao carregar dados.</div>;

    return (
        <div className="space-y-6 animate-fade-in">
            {/* Header */}
            <div>
                <h2 className="text-2xl font-bold text-gray-800">Visão Geral</h2>
                <p className="text-gray-500">Acompanhe os indicadores chave do programa de estágio.</p>
            </div>

            {/* KPIs */}
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <KPICard
                    title="Total de Estudantes"
                    value={data.kpi?.totalStudents || 0}
                    icon={Users}
                    color="primary"
                    change="+12%"
                    changeType="increase"
                />
                <KPICard
                    title="Contratos Ativos"
                    value={data.kpi?.activeContracts || 0}
                    icon={FileText}
                    color="success"
                    change="+5%"
                    changeType="increase"
                />
                <KPICard
                    title="Avaliações Pendentes"
                    value={data.kpi?.pendingEvaluations || 0}
                    icon={AlertCircle}
                    color="warning"
                    changeType={data.kpi?.pendingEvaluations > 0 ? "decrease" : "neutral"}
                />
                <KPICard
                    title="Taxa de Efetivação"
                    value="85%"
                    icon={TrendingUp}
                    color="cta"
                    change="+2%"
                    changeType="increase"
                />
            </div>

            {/* Charts */}
            <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <ContractsChart data={data.charts?.contracts || []} />
                <StudentsPieChart data={data.charts?.courses || []} />
            </div>

            {/* Recent Alerts Section (Legacy) */}
            <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div className="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 className="text-lg font-bold text-gray-800 mb-4">Contratos a Vencer</h3>
                    {data.expiringContracts?.length === 0 ? (
                        <p className="text-green-600">Tudo certo! Nenhum contrato vencendo.</p>
                    ) : (
                        <ul className="space-y-3">
                            {data.expiringContracts.map(c => (
                                <li key={c.id} className="flex justify-between items-center bg-red-50 p-3 rounded-lg">
                                    <span className="text-gray-800 font-medium">{c.student_name}</span>
                                    <span className="text-red-500 text-sm">Vence: {c.data_fim}</span>
                                </li>
                            ))}
                        </ul>
                    )}
                </div>
                <div className="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 className="text-lg font-bold text-gray-800 mb-4">Avaliações Pendentes</h3>
                    {data.evaluationsPending?.length === 0 ? (
                        <p className="text-green-600">Todas as avaliações em dia.</p>
                    ) : (
                        <ul className="space-y-3">
                            {data.evaluationsPending.map(item => (
                                <li key={item.id} className="flex justify-between items-center bg-yellow-50 p-3 rounded-lg">
                                    <span className="text-gray-800 font-medium">{item.student_name}</span>
                                    <span className="text-yellow-600 text-sm font-bold">Pendente</span>
                                </li>
                            ))}
                        </ul>
                    )}
                </div>
            </div>
        </div>
    );
};

export default DashboardOverview;
