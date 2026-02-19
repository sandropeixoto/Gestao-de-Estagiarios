import { Request, Response } from 'express';
import { supabase } from '../config/supabase';

const TABLE_NAME = 'timesheets';

export const registerTime = async (req: Request, res: Response) => {
    try {
        const { hora_entrada, hora_saida, is_dia_prova, ...rest } = req.body;

        // Calculate hours
        // Assuming hh:mm format
        const [h1, m1] = hora_entrada.split(':').map(Number);
        const [h2, m2] = hora_saida.split(':').map(Number);

        const start = new Date(); start.setHours(h1, m1, 0);
        const end = new Date(); end.setHours(h2, m2, 0);

        // Handle crossing midnight if needed (simplification: assume same day for intern times)
        const diffMs = end.getTime() - start.getTime();
        const hours = diffMs / (1000 * 60 * 60);

        const limit = is_dia_prova ? 3 : 6;

        if (hours > limit) {
            return res.status(400).json({ message: `Carga horária excede o limite diário de ${limit} horas.` });
        }

        const { data, error } = await supabase.from(TABLE_NAME).insert([{
            hora_entrada,
            hora_saida,
            is_dia_prova,
            ...rest
        }]);

        if (error) throw error;
        res.status(201).json({ message: 'Time registered.', data });
    } catch (error) {
        res.status(503).json({ message: 'Error registering time', error: (error as Error).message });
    }
};
