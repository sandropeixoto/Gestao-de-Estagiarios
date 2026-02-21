import { Router } from 'express';
import { createStudent, getAllStudents, updateStudent, deleteStudent } from '../controllers/studentController';

const router = Router();

router.post('/create', createStudent);
router.get('/list', getAllStudents);
router.put('/:id', updateStudent);
router.delete('/:id', deleteStudent);

export default router;
