import { Request, Response } from 'express';
import { supabase } from '../config/supabase';

const TABLE_NAME = 'contracts';

import { getActiveInternsCount } from './supervisorController';

export const createContract = async (req: Request, res: Response) => {
    try {
        const { supervisor_id, data_inicio, data_fim, ...rest } = req.body;

        // Validate Supervisor Limit
        const activeInterns = await getActiveInternsCount(supervisor_id);
        if (activeInterns >= 10) {
            return res.status(400).json({ message: 'Limite legal de 10 estagiários por supervisor excedido' });
        }

        // Validate Contract Duration (Max 2 years)
        const start = new Date(data_inicio);
        const end = new Date(data_fim);
        const diffTime = Math.abs(end.getTime() - start.getTime());
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

        // Approximate 2 years as 730 days
        if (diffDays > 730) {
            return res.status(400).json({ message: 'Contrato não pode exceder 2 anos.' });
        }

        const { data, error } = await supabase.from(TABLE_NAME).insert([{
            supervisor_id,
            data_inicio,
            data_fim,
            status: 'Ativo',
            ...rest
        }]);

        if (error) throw error;
        res.status(201).json({ message: 'Contract created.', data });
    } catch (error) {
        res.status(503).json({ message: 'Error creating contract', error: (error as Error).message });
    }
};

export const getAllContracts = async (req: Request, res: Response) => {
    try {
        const { data, error } = await supabase
            .from(TABLE_NAME)
            .select('*, students(nome), institutions(razao_social), supervisors(nome)');

        if (error) throw error;
        res.status(200).json(data);
    } catch (error) {
        res.status(503).json({ message: 'Error fetching contracts', error: (error as Error).message });
    }
};

export const checkExpiringContracts = async (req: Request, res: Response) => {
    try {
        const today = new Date();
        const next30Days = new Date();
        next30Days.setDate(today.getDate() + 30);

        const { data, error } = await supabase
            .from(TABLE_NAME)
            .select('*, students(nome)')
            .eq('status', 'Ativo')
            .lte('data_fim', next30Days.toISOString())
            .gte('data_fim', today.toISOString());

        if (error) throw error;
        res.status(200).json(data);
    } catch (error) {
        res.status(503).json({ message: 'Error fetching expiring contracts', error: (error as Error).message });
    }
};
