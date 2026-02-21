import { Router } from 'express';
import { createInstitution, getAllInstitutions, updateInstitution, deleteInstitution } from '../controllers/institutionController';

const router = Router();

router.post('/create', createInstitution);
router.get('/list', getAllInstitutions);
router.put('/:id', updateInstitution);
router.delete('/:id', deleteInstitution);

export default router;
