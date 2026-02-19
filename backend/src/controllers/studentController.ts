import { Request, Response } from 'express';
import { supabase } from '../config/supabase';

export const createStudent = async (req: Request, res: Response) => {
    const {
        nome,
        cpf,
        curso,
        semestre,
        previsao_formatura,
        dados_bancarios,
        comprovante_matricula_path,
    } = req.body;

    if (!nome || !cpf) {
        return res.status(400).json({ message: 'Incomplete data. Name and CPF are required.' });
    }

    try {
        const { data, error } = await supabase
            .from('students')
            .insert([
                {
                    nome,
                    cpf,
                    curso,
                    semestre,
                    previsao_formatura,
                    dados_bancarios,
                    comprovante_matricula_path,
                },
            ]);

        if (error) {
            throw error;
        }

        res.status(201).json({ message: 'Student created successfully.', data });
    } catch (error) {
        res.status(503).json({ message: 'Unable to create student.', error: (error as Error).message });
    }
};

export const getAllStudents = async (req: Request, res: Response) => {
    try {
        const { data, error } = await supabase.from('students').select('*');

        if (error) {
            throw error;
        }

        res.status(200).json(data);
    } catch (error) {
        res.status(503).json({ message: 'Unable to fetch students.', error: (error as Error).message });
    }
};
