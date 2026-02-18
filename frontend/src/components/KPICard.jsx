import React from 'react';
import { ArrowUpRight, ArrowDownRight } from 'lucide-react';

const KPICard = ({ title, value, icon: Icon, change, changeType = 'neutral', color = 'primary' }) => {
    const colorMap = {
        primary: 'bg-primary/10 text-primary',
        secondary: 'bg-secondary/10 text-secondary',
        cta: 'bg-cta/10 text-cta',
        success: 'bg-green-100 text-green-600',
        warning: 'bg-yellow-100 text-yellow-600',
        danger: 'bg-red-100 text-red-600',
    };

    const changeColor =
        changeType === 'increase' ? 'text-green-600' :
            changeType === 'decrease' ? 'text-red-600' : 'text-gray-500';

    return (
        <div className="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-200">
            <div className="flex items-center justify-between">
                <div>
                    <p className="text-sm font-medium text-gray-500 mb-1">{title}</p>
                    <h3 className="text-2xl font-bold text-gray-800">{value}</h3>
                </div>
                <div className={`p-3 rounded-lg ${colorMap[color]}`}>
                    <Icon className="w-6 h-6" />
                </div>
            </div>

            {change && (
                <div className="mt-4 flex items-center text-sm">
                    <span className={`flex items-center font-medium ${changeColor}`}>
                        {changeType === 'increase' ? <ArrowUpRight className="w-4 h-4 mr-1" /> : <ArrowDownRight className="w-4 h-4 mr-1" />}
                        {change}
                    </span>
                    <span className="text-gray-400 ml-2">vs mês anterior</span>
                </div>
            )}
        </div>
    );
};

export default KPICard;
