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

export const updateInstitution = async (req: Request, res: Response) => {
    const { id } = req.params;

    if (!id) {
        return res.status(400).json({ message: 'Institution ID is required.' });
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
            return res.status(404).json({ message: 'Institution not found.' });
        }

        res.status(200).json({ message: 'Institution updated successfully.', data: data[0] });
    } catch (error) {
        res.status(503).json({ message: 'Unable to update institution.', error: (error as Error).message });
    }
};

export const deleteInstitution = async (req: Request, res: Response) => {
    const { id } = req.params;

    if (!id) {
        return res.status(400).json({ message: 'Institution ID is required.' });
    }

    try {
        const { error } = await supabase
            .from(TABLE_NAME)
            .delete()
            .eq('id', id);

        if (error) {
            throw error;
        }

        res.status(200).json({ message: 'Institution deleted successfully.' });
    } catch (error) {
        res.status(503).json({ message: 'Unable to delete institution.', error: (error as Error).message });
    }
};
