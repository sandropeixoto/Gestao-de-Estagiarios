import axios from 'axios';

const api = axios.create({
    baseURL: 'http://localhost:8000',
});

// Student & Intern
export const registerTimeSheet = async (data) => {
    return api.post('/timesheet/register', data);
};

export const createStudent = async (data) => {
    return api.post('/student/create', data);
};

export const listStudents = async () => {
    return api.get('/student/list');
};

// Institution
export const createInstitution = async (data) => {
    return api.post('/institution/create', data);
};

export const listInstitutions = async () => {
    return api.get('/institution/list');
};

// Supervisor & Contract
export const createSupervisor = async (data) => {
    return api.post('/supervisor/create', data);
};

export const listSupervisors = async () => {
    return api.get('/supervisor/list');
};

export const createContract = async (data) => {
    return api.post('/contract/create', data);
};

export const listContracts = async () => {
    return api.get('/contract/list');
};

// Dashboard
export const getManagerDashboardData = async () => {
    return api.get('/dashboard/manager');
};

export default api;
