import React, { useState } from 'react';
import { useLocation, Link, useNavigate } from 'react-router-dom';
import {
    LayoutDashboard,
    Users,
    Building2,
    FileText,
    LogOut,
    Menu,
    X
} from 'lucide-react';

const Layout = ({ children }) => {
    const [sidebarOpen, setSidebarOpen] = useState(false);
    const [isCollapsed, setIsCollapsed] = useState(false);
    const location = useLocation();
    const navigate = useNavigate();

    const menuItems = [
        { icon: LayoutDashboard, label: 'Dashboard', path: '/dashboard' },
        { icon: Users, label: 'Estudantes', path: '/students' },
        { icon: Building2, label: 'Empresas', path: '/institutions' },
        { icon: Users, label: 'Supervisores', path: '/supervisors' },
        { icon: FileText, label: 'Contratos', path: '/contracts' },
    ];

    const handleLogout = () => {
        localStorage.removeItem('user');
        navigate('/login');
    };

    return (
        <div className="flex h-screen bg-background overflow-hidden font-sans text-brandText">
            {/* Mobile Sidebar Overlay */}
            {sidebarOpen && (
                <div
                    className="fixed inset-0 z-20 bg-black bg-opacity-50 lg:hidden transition-opacity"
                    onClick={() => setSidebarOpen(false)}
                ></div>
            )}

            {/* Sidebar */}
            <aside
                className={`fixed inset-y-0 left-0 z-30 bg-white border-r border-gray-200 transform transition-all duration-300 ease-in-out 
                    lg:static lg:inset-0 ${sidebarOpen ? 'translate-x-0' : '-translate-x-full'} 
                    ${isCollapsed ? 'lg:w-20' : 'lg:w-64'} w-64`}
            >
                <div className={`flex items-center h-16 border-b border-gray-100 ${isCollapsed ? 'justify-center' : 'justify-between px-6'}`}>
                    {!isCollapsed && (
                        <h1 className="text-xl font-bold text-primary truncate">
                            Estágio<span className="text-secondary">Plus</span>
                        </h1>
                    )}
                    {isCollapsed && (
                        <span className="text-xl font-bold text-primary">E<span className="text-secondary">+</span></span>
                    )}

                    {/* Desktop Collapse Toggle */}
                    <button
                        onClick={() => setIsCollapsed(!isCollapsed)}
                        className="p-1 rounded-md text-gray-400 hover:text-primary hover:bg-gray-100 hidden lg:block transition-colors"
                    >
                        {isCollapsed ? <Menu className="w-5 h-5" /> : <Menu className="w-5 h-5" />}
                    </button>
                    <button
                        onClick={() => setSidebarOpen(false)}
                        className="lg:hidden text-gray-500 focus:outline-none"
                    >
                        <X className="w-6 h-6" />
                    </button>
                </div>

                <nav className="flex-1 px-4 py-6 space-y-2 overflow-y-auto overflow-x-hidden">
                    {menuItems.map((item) => {
                        const Icon = item.icon;
                        const isActive = location.pathname === item.path;

                        return (
                            <Link
                                key={item.path}
                                to={item.path}
                                title={isCollapsed ? item.label : ''}
                                className={`flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 group relative
                                    ${isActive
                                        ? 'bg-primary text-white shadow-md shadow-primary/30'
                                        : 'text-gray-600 hover:bg-gray-50 hover:text-primary'
                                    } ${isCollapsed ? 'justify-center' : ''}`}
                            >
                                <Icon className={`w-5 h-5 transition-colors flex-shrink-0 ${!isCollapsed ? 'mr-3' : ''} ${isActive ? 'text-white' : 'text-gray-400 group-hover:text-primary'}`} />
                                {!isCollapsed && <span className="truncate">{item.label}</span>}
                            </Link>
                        );
                    })}
                </nav>

                <div className="p-4 border-t border-gray-100">
                    <button
                        onClick={handleLogout}
                        title={isCollapsed ? 'Sair' : ''}
                        className={`flex items-center w-full px-4 py-2 text-sm font-medium text-gray-600 rounded-lg hover:bg-red-50 hover:text-red-500 transition-colors ${isCollapsed ? 'justify-center' : ''}`}
                    >
                        <LogOut className={`w-5 h-5 flex-shrink-0 ${!isCollapsed ? 'mr-3' : ''}`} />
                        {!isCollapsed && <span>Sair</span>}
                    </button>
                </div>
            </aside>

            {/* Main Content */}
            <div className="flex flex-col flex-1 overflow-hidden transition-all duration-300">
                {/* Header */}
                <header className="flex items-center justify-between h-16 px-6 bg-white border-b border-gray-100 lg:px-8">
                    <button
                        className="text-gray-500 focus:outline-none lg:hidden"
                        onClick={() => setSidebarOpen(true)}
                    >
                        <Menu className="w-6 h-6" />
                    </button>

                    <div className="flex items-center ml-auto space-x-4">
                        <div className="relative">
                            <span className="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
                            <button className="p-1 text-gray-400 hover:text-primary transition-colors">
                                <span className="sr-only">Notificações</span>
                                <svg className="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                            </button>
                        </div>

                        <div className="flex items-center space-x-2">
                            <div className="w-8 h-8 rounded-full bg-secondary/20 flex items-center justify-center text-primary font-bold">
                                AD
                            </div>
                            <span className="text-sm font-medium text-gray-700 hidden md:block">Admin</span>
                        </div>
                    </div>
                </header>

                {/* Page Content */}
                <main className="flex-1 overflow-x-hidden overflow-y-auto bg-background p-6">
                    {children}
                </main>
            </div>
        </div>
    );
};

export default Layout;
