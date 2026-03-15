import { Request, Response } from 'express';
import { supabase } from '../config/supabase';

export const checkStatus = async (req: Request, res: Response) => {
    try {
        const { data, error } = await supabase.from('students').select('*').limit(1);

        if (error) {
            throw error;
        }

        res.status(200).json({ message: 'Database connection successful', data });
    } catch (error) {
        res.status(503).json({ message: 'Database connection failed', error: (error as Error).message });
    }
};
