import { Request, Response } from 'express';
import { supabase } from '../config/supabase';

const TABLE_NAME = 'institutions';

export const createInstitution = async (req: Request, res: Response) => {
    try {
        const { data, error } = await supabase.from(TABLE_NAME).insert([req.body]);
        if (error) throw error;
        res.status(201).json({ message: 'Institution created.', data });
    } catch (error) {
        res.status(503).json({ message: 'Error creating institution', error: (error as Error).message });
    }
};

export const getAllInstitutions = async (req: Request, res: Response) => {
    try {
        const { data, error } = await supabase.from(TABLE_NAME).select('*');
        if (error) throw error;
        res.status(200).json(data);
    } catch (error) {
        res.status(503).json({ message: 'Error fetching institutions', error: (error as Error).message });
    }
};
