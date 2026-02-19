import { Request, Response } from 'express';
import { supabase } from '../config/supabase';

export const getManagerStats = async (req: Request, res: Response) => {
    try {
        // Helper function to get count
        const getCount = async (table: string) => {
            const { count, error } = await supabase.from(table).select('*', { count: 'exact', head: true });
            if (error) throw error;
            return count;
        };

        const [studentsCount, supervisorsCount, contractsCount] = await Promise.all([
            getCount('students'),
            getCount('supervisors'),
            getCount('contracts')
        ]);

        res.status(200).json({
            students: studentsCount,
            supervisors: supervisorsCount,
            contracts: contractsCount
        });
    } catch (error) {
        res.status(503).json({ message: 'Error fetching dashboard stats', error: (error as Error).message });
    }
};
