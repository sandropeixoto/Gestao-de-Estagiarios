import { useState, useEffect } from 'react'
import { BrowserRouter as Router, Routes, Route, Navigate } from 'react-router-dom';
import axios from 'axios';

import InternDashboard from './pages/InternDashboard';
import Login from './pages/Login';
import FinancialModule from './pages/FinancialModule';

// New Components
import Layout from './components/Layout';
import DashboardOverview from './pages/DashboardOverview';
import StudentsList from './pages/StudentsList';
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
      <Routes>
        <Route path="/" element={<Login />} />

        {/* Intern Route - Keep as is for now */}
        <Route path="/intern" element={<InternDashboard />} />

        {/* Manager Routes - Wrapped in Layout */}
        <Route path="/dashboard" element={<Layout><DashboardOverview /></Layout>} />
        <Route path="/students" element={<Layout><StudentsList /></Layout>} />
        <Route path="/institutions" element={<Layout><InstitutionsList /></Layout>} />
        <Route path="/supervisors" element={<Layout><SupervisorsList /></Layout>} />
        <Route path="/contracts" element={<Layout><ContractsList /></Layout>} />

        {/* Forms - Wrapped in Layout for consistency */}
        <Route path="/student/new" element={<Layout><StudentForm /></Layout>} />
        <Route path="/institution/new" element={<Layout><InstitutionForm /></Layout>} />
        <Route path="/supervisor/new" element={<Layout><SupervisorForm /></Layout>} />
        <Route path="/contract/new" element={<Layout><ContractForm /></Layout>} />
        <Route path="/financial" element={<Layout><FinancialModule /></Layout>} />

        {/* Redirect legacy /manager to /dashboard */}
        <Route path="/manager" element={<Navigate to="/dashboard" replace />} />
      </Routes>
    </Router>
  )
}

export default App
