import React from 'react';
import { Link } from 'react-router-dom';
import { ChevronLeft } from 'lucide-react';
import Button from './Button';

const PageHeader = ({ title, backUrl, action }) => {
    return (
        <div className="flex items-center justify-between mb-6">
            <div className="flex items-center space-x-4">
                {backUrl && (
                    <Link to={backUrl}>
                        <Button variant="ghost" className="p-2 aspect-square">
                            <ChevronLeft className="w-5 h-5" />
                        </Button>
                    </Link>
                )}
                <h1 className="text-2xl font-bold text-gray-900">{title}</h1>
            </div>
            {action}
        </div>
    );
};

export default PageHeader;
