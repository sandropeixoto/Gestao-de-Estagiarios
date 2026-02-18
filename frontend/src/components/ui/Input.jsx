import React from 'react';

const Input = ({ label, id, error, ...props }) => {
    return (
        <div className="mb-4">
            {label && (
                <label htmlFor={id} className="block text-sm font-medium text-gray-700 mb-1">
                    {label}
                </label>
            )}
            <input
                id={id}
                className={`w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 transition-colors
                    ${error
                        ? 'border-red-500 focus:ring-red-200'
                        : 'border-gray-200 focus:border-primary focus:ring-primary/20'
                    } disabled:bg-gray-50 disabled:text-gray-500`}
                {...props}
            />
            {error && <p className="mt-1 text-sm text-red-500">{error}</p>}
        </div>
    );
};

export default Input;
