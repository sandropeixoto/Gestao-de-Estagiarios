import React from 'react';
import { Loader2 } from 'lucide-react';

const Button = ({ children, variant = 'primary', isLoading, className = '', ...props }) => {
    const baseStyles = "inline-flex items-center justify-center px-4 py-2 font-medium rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed";

    const variants = {
        primary: "bg-primary text-white hover:bg-primary/90 focus:ring-primary/50 shadow-md shadow-primary/30",
        secondary: "bg-white text-gray-700 border border-gray-200 hover:bg-gray-50 focus:ring-gray-200",
        danger: "bg-red-500 text-white hover:bg-red-600 focus:ring-red-500/50 shadow-md shadow-red-500/30",
        ghost: "text-gray-600 hover:bg-gray-100 hover:text-gray-900"
    };

    return (
        <button
            className={`${baseStyles} ${variants[variant]} ${className}`}
            disabled={isLoading || props.disabled}
            {...props}
        >
            {isLoading && <Loader2 className="w-4 h-4 mr-2 animate-spin" />}
            {children}
        </button>
    );
};

export default Button;
