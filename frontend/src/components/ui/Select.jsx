import React from 'react';

const Select = ({ label, id, error, options = [], ...props }) => {
    return (
        <div className="mb-4">
            {label && (
                <label htmlFor={id} className="block text-sm font-medium text-gray-700 mb-1">
                    {label}
                </label>
            )}
            <select
                id={id}
                className={`w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 transition-colors appearance-none bg-white
                    ${error
                        ? 'border-red-500 focus:ring-red-200'
                        : 'border-gray-200 focus:border-primary focus:ring-primary/20'
                    } disabled:bg-gray-50 disabled:text-gray-500`}
                {...props}
            >
                <option value="" disabled>Selecione...</option>
                {options.map((opt) => (
                    <option key={opt.value} value={opt.value}>
                        {opt.label}
                    </option>
                ))}
            </select>
            {error && <p className="mt-1 text-sm text-red-500">{error}</p>}
        </div>
    );
};

export default Select;
