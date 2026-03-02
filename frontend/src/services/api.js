import axios from 'axios';

const api = axios.create({
    baseURL: import.meta.env.VITE_API_URL || '/api',
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

export const updateStudent = async (id, data) => {
    return api.put(`/student/${id}`, data);
};

export const deleteStudent = async (id) => {
    return api.delete(`/student/${id}`);
};

// Institution
export const createInstitution = async (data) => {
    return api.post('/institution/create', data);
};

export const listInstitutions = async () => {
    return api.get('/institution/list');
};

export const updateInstitution = async (id, data) => {
    return api.put(`/institution/${id}`, data);
};

export const deleteInstitution = async (id) => {
    return api.delete(`/institution/${id}`);
};

// Supervisor & Contract
export const createSupervisor = async (data) => {
    return api.post('/supervisor/create', data);
};

export const listSupervisors = async () => {
    return api.get('/supervisor/list');
};

export const updateSupervisor = async (id, data) => {
    return api.put(`/supervisor/${id}`, data);
};

export const deleteSupervisor = async (id) => {
    return api.delete(`/supervisor/${id}`);
};

// Lotacoes
export const listLotacoes = async () => {
    return api.get('/lotacao');
};

// Positions
export const createPosition = async (data) => {
    return api.post('/position/create', data);
};

export const listPositions = async () => {
    return api.get('/position/list');
};

export const updatePosition = async (id, data) => {
    return api.put(`/position/${id}`, data);
};

export const deletePosition = async (id) => {
    return api.delete(`/position/${id}`);
};

export const createContract = async (data) => {
    return api.post('/contract/create', data);
};

export const listContracts = async () => {
    return api.get('/contract/list');
};

export const updateContract = async (id, data) => {
    return api.put(`/contract/${id}`, data);
};

export const deleteContract = async (id) => {
    return api.delete(`/contract/${id}`);
};

// Dashboard
export const getManagerDashboardData = async () => {
    return api.get('/dashboard/manager');
};

export default api;
