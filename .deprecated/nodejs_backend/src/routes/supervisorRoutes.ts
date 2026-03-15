import { Router } from 'express';
import { createSupervisor, getAllSupervisors, updateSupervisor, deleteSupervisor } from '../controllers/supervisorController';

const router = Router();

router.post('/create', createSupervisor);
router.get('/list', getAllSupervisors);
router.put('/:id', updateSupervisor);
router.delete('/:id', deleteSupervisor);

export default router;
