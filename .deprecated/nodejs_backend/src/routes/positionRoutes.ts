import { Router } from 'express';
import { createPosition, getAllPositions, updatePosition, deletePosition } from '../controllers/positionController';

const router = Router();

router.post('/create', createPosition);
router.get('/list', getAllPositions);
router.put('/:id', updatePosition);
router.delete('/:id', deletePosition);

export default router;
