import { Request, Response } from 'express';
import { supabase } from '../config/supabase';

const TABLE_NAME = 'lotacoes';

export const getAllLotacoes = async (req: Request, res: Response) => {
    try {
        const { data, error } = await supabase
            .from(TABLE_NAME)
            .select('*')
            .order('unidade', { ascending: true })
            .order('subunidade', { ascending: true });
            
        if (error) throw error;
        res.status(200).json(data);
    } catch (error) {
        res.status(500).json({ message: 'Error fetching lotacoes', error: (error as Error).message });
    }
};

export const getLotacaoById = async (req: Request, res: Response) => {
    const { id } = req.params;
    try {
        const { data, error } = await supabase
            .from(TABLE_NAME)
            .select('*')
            .eq('id', id)
            .single();
            
        if (error) throw error;
        res.status(200).json(data);
    } catch (error) {
        res.status(500).json({ message: 'Error fetching lotacao', error: (error as Error).message });
    }
};
