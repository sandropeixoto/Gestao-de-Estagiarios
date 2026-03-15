import { Router } from 'express';
import { checkStatus } from '../controllers/statusController';

const router = Router();

router.get('/', checkStatus);

export default router;
