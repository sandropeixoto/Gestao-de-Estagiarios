import { Router } from 'express';
import { registerTime } from '../controllers/timesheetController';

const router = Router();

router.post('/register', registerTime);

export default router;
