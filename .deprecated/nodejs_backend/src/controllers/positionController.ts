import { Request, Response } from 'express';
import { supabase } from '../config/supabase';

const TABLE_NAME = 'positions';

export const createPosition = async (req: Request, res: Response) => {
    try {
        const { data, error } = await supabase.from(TABLE_NAME).insert([req.body]).select();
        if (error) throw error;
        res.status(201).json({ message: 'Position created.', data: data[0] });
    } catch (error) {
        res.status(500).json({ message: 'Error creating position', error: (error as Error).message });
    }
};

export const getAllPositions = async (req: Request, res: Response) => {
    try {
        const { data, error } = await supabase
            .from(TABLE_NAME)
            .select(`
                *,
                lotacoes (
                    id,
                    unidade,
                    subunidade,
                    lotacao,
                    municipio
                )
            `)
            .order('created_at', { ascending: false });
            
        if (error) throw error;

        // Adicionar contagem de ocupação
        const positionsWithUsage = await Promise.all(data.map(async (pos) => {
            const { count } = await supabase
                .from('contracts')
                .select('*', { count: 'exact', head: true })
                .eq('position_id', pos.id)
                .eq('status', 'Ativo');
            
            return { ...pos, occupied_slots: count || 0 };
        }));

        res.status(200).json(positionsWithUsage);
    } catch (error) {
        res.status(500).json({ message: 'Error fetching positions', error: (error as Error).message });
    }
};

export const updatePosition = async (req: Request, res: Response) => {
    const { id } = req.params;
    try {
        const { data, error } = await supabase
            .from(TABLE_NAME)
            .update(req.body)
            .eq('id', id)
            .select();

        if (error) throw error;
        res.status(200).json({ message: 'Position updated.', data: data[0] });
    } catch (error) {
        res.status(500).json({ message: 'Error updating position', error: (error as Error).message });
    }
};

export const deletePosition = async (req: Request, res: Response) => {
    const { id } = req.params;
    try {
        const { error } = await supabase.from(TABLE_NAME).delete().eq('id', id);
        if (error) throw error;
        res.status(200).json({ message: 'Position deleted.' });
    } catch (error) {
        res.status(500).json({ message: 'Error deleting position', error: (error as Error).message });
    }
};
