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

                    previsao_formatura: previsao_formatura && previsao_formatura.length === 7 ? `${previsao_formatura}-01` : previsao_formatura,
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

export const updateStudent = async (req: Request, res: Response) => {
    const { id } = req.params;
    const {
        nome,
        cpf,
        curso,
        semestre,
        previsao_formatura,
        dados_bancarios,
        comprovante_matricula_path,
    } = req.body;

    if (!id) {
        return res.status(400).json({ message: 'Student ID is required.' });
    }

    try {
        const { data, error } = await supabase
            .from('students')
            .update({
                nome,
                cpf,
                curso,
                semestre,
                previsao_formatura: previsao_formatura && previsao_formatura.length === 7 ? `${previsao_formatura}-01` : previsao_formatura,
                dados_bancarios,
                comprovante_matricula_path,
            })
            .eq('id', id)
            .select();

        if (error) {
            throw error;
        }

        if (!data || data.length === 0) {
            return res.status(404).json({ message: 'Student not found.' });
        }

        res.status(200).json({ message: 'Student updated successfully.', data: data[0] });
    } catch (error) {
        res.status(503).json({ message: 'Unable to update student.', error: (error as Error).message });
    }
};

export const deleteStudent = async (req: Request, res: Response) => {
    const { id } = req.params;

    if (!id) {
        return res.status(400).json({ message: 'Student ID is required.' });
    }

    try {
        const { error } = await supabase
            .from('students')
            .delete()
            .eq('id', id);

        if (error) {
            throw error;
        }

        res.status(200).json({ message: 'Student deleted successfully.' });
    } catch (error) {
        res.status(503).json({ message: 'Unable to delete student.', error: (error as Error).message });
    }
};
