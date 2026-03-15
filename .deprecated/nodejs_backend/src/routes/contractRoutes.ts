import { Router } from 'express';
import { createContract, getAllContracts, checkExpiringContracts, updateContract, deleteContract } from '../controllers/contractController';

const router = Router();

router.post('/create', createContract);
router.get('/list', getAllContracts);
router.get('/expiring', checkExpiringContracts);
router.put('/:id', updateContract);
router.delete('/:id', deleteContract);

export default router;
