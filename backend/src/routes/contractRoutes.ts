import { Router } from 'express';
import { createContract, getAllContracts, checkExpiringContracts } from '../controllers/contractController';

const router = Router();

router.post('/create', createContract);
router.get('/list', getAllContracts);
router.get('/expiring', checkExpiringContracts);

export default router;
