import { Request, Response } from 'express';
import { supabase } from '../config/supabase';

// Assuming you have a supervisors table. Adjust table name if needed.
const TABLE_NAME = 'supervisors';

export const createSupervisor = async (req: Request, res: Response) => {
    // Add logic similar to student create, adapting fields
    // For now, basic implementation
    try {
        const { data, error } = await supabase.from(TABLE_NAME).insert([req.body]);
        if (error) throw error;
        res.status(201).json({ message: 'Supervisor created.', data });
    } catch (error) {
        res.status(503).json({ message: 'Error creating supervisor', error: (error as Error).message });
    }
};

export const getAllSupervisors = async (req: Request, res: Response) => {
    try {
        const { data, error } = await supabase.from(TABLE_NAME).select('*');
        if (error) throw error;
        res.status(200).json(data);
    } catch (error) {
        res.status(503).json({ message: 'Error fetching supervisors', error: (error as Error).message });
    }
};

export const getActiveInternsCount = async (supervisorId: string | number): Promise<number> => {
    const { count, error } = await supabase
        .from('contracts')
        .select('*', { count: 'exact', head: true })
        .eq('supervisor_id', supervisorId)
        .eq('status', 'Ativo');

    if (error) throw error;
    return count || 0;
};

export const updateSupervisor = async (req: Request, res: Response) => {
    const { id } = req.params;

    if (!id) {
        return res.status(400).json({ message: 'Supervisor ID is required.' });
    }

    try {
        const { data, error } = await supabase
            .from(TABLE_NAME)
            .update(req.body)
            .eq('id', id)
            .select();

        if (error) {
            throw error;
        }

        if (!data || data.length === 0) {
            return res.status(404).json({ message: 'Supervisor not found.' });
        }

        res.status(200).json({ message: 'Supervisor updated successfully.', data: data[0] });
    } catch (error) {
        res.status(503).json({ message: 'Unable to update supervisor.', error: (error as Error).message });
    }
};

export const deleteSupervisor = async (req: Request, res: Response) => {
    const { id } = req.params;

    if (!id) {
        return res.status(400).json({ message: 'Supervisor ID is required.' });
    }

    try {
        const { error } = await supabase
            .from(TABLE_NAME)
            .delete()
            .eq('id', id);

        if (error) {
            throw error;
        }

        res.status(200).json({ message: 'Supervisor deleted successfully.' });
    } catch (error) {
        res.status(503).json({ message: 'Unable to delete supervisor.', error: (error as Error).message });
    }
};
