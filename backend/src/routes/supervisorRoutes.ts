import { Router } from 'express';
import { createSupervisor, getAllSupervisors } from '../controllers/supervisorController';

const router = Router();

router.post('/create', createSupervisor);
router.get('/list', getAllSupervisors);

export default router;
