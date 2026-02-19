import { Router } from 'express';
import { createStudent, getAllStudents } from '../controllers/studentController';

const router = Router();

router.post('/create', createStudent);
router.get('/list', getAllStudents);

export default router;
