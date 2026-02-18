import { useState, useEffect } from 'react'
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';
import axios from 'axios';

import InternDashboard from './pages/InternDashboard';
import ManagerDashboard from './pages/ManagerDashboard';
import Login from './pages/Login';
import FinancialModule from './pages/FinancialModule';
import StudentForm from './pages/StudentForm';
import InstitutionForm from './pages/InstitutionForm';
import SupervisorForm from './pages/SupervisorForm';
import ContractForm from './pages/ContractForm';

function App() {
  const [dbStatus, setDbStatus] = useState({ status: 'checking', message: 'Connecting...' });

  useEffect(() => {
    // Check DB status on load
    axios.get('http://localhost:8000/status')
      .then(res => setDbStatus(res.data))
      .catch(err => setDbStatus({ status: 'offline', message: 'Connection Failed' }));
  }, []);

  return (
    <Router>
      <div className="min-h-screen bg-gray-100 font-sans text-gray-900 flex flex-col">
        <div className="flex-grow">
          <Routes>
            <Route path="/" element={<Login />} />
            <Route path="/intern" element={<InternDashboard />} />
            <Route path="/manager" element={<ManagerDashboard />} />
            <Route path="/financial" element={<FinancialModule />} />
            <Route path="/student/new" element={<StudentForm />} />
            <Route path="/institution/new" element={<InstitutionForm />} />
            <Route path="/supervisor/new" element={<SupervisorForm />} />
            <Route path="/contract/new" element={<ContractForm />} />
          </Routes>
        </div>
        <footer className={`p-2 text-center text-xs font-mono text-white ${dbStatus.status === 'online' ? 'bg-green-600' : 'bg-red-600'}`}>
          DB Status: {dbStatus.status ? dbStatus.status.toUpperCase() : 'OFFLINE'} - {dbStatus.message}
        </footer>
      </div>
    </Router>
  )
}

export default App
