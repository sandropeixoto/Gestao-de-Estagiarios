import { Router } from 'express';
import { getAllLotacoes, getLotacaoById } from '../controllers/lotacaoController';

const router = Router();

router.get('/', getAllLotacoes);
router.get('/:id', getLotacaoById);

export default router;
