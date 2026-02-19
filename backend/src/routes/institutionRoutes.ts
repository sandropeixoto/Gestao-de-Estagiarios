import { Router } from 'express';
import { createInstitution, getAllInstitutions } from '../controllers/institutionController';

const router = Router();

router.post('/create', createInstitution);
router.get('/list', getAllInstitutions);

export default router;
