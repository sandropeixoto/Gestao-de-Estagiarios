import { Router } from 'express';
import { getManagerStats } from '../controllers/dashboardController';

const router = Router();

router.get('/manager', getManagerStats);

export default router;
