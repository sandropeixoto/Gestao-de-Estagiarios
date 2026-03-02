import { Request, Response } from 'express';
import { supabase } from '../config/supabase';

const TABLE_NAME = 'contracts';

import { getActiveInternsCount } from './supervisorController';

export const createContract = async (req: Request, res: Response) => {
    try {
        const { 
            student_id, 
            institution_id, 
            supervisor_id, 
            position_id, 
            data_inicio, 
            data_fim, 
            valor_bolsa, 
            valor_transporte, 
            apolice_seguro,
            status 
        } = req.body;

        if (!position_id) {
            return res.status(400).json({ message: 'ID da vaga é obrigatório.' });
        }

        // Validate Supervisor Limit
        const activeInterns = await getActiveInternsCount(supervisor_id);
        if (activeInterns >= 10) {
            return res.status(400).json({ message: 'Limite legal de 10 estagiários por supervisor excedido' });
        }

        // Validate Contract Duration (Max 2 years)
        const start = new Date(data_inicio);
        const end = new Date(data_fim);
        const diffTime = Math.abs(end.getTime() - start.getTime());
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

        if (diffDays > 730) {
            return res.status(400).json({ message: 'Contrato não pode exceder 2 anos.' });
        }

        // Check Position Capacity
        const { data: posData, error: posError } = await supabase
            .from('positions')
            .select('quantidade')
            .eq('id', position_id)
            .single();
        
        if (posError || !posData) {
            console.error('Erro ao buscar vaga:', posError);
            return res.status(400).json({ message: 'Vaga não encontrada.' });
        }

        const { count: currentOccupancy } = await supabase
            .from('contracts')
            .select('*', { count: 'exact', head: true })
            .eq('position_id', position_id)
            .eq('status', 'Ativo');

        if ((currentOccupancy || 0) >= posData.quantidade) {
            return res.status(400).json({ message: 'Esta vaga já atingiu o limite de ocupação.' });
        }

        const { data, error } = await supabase.from(TABLE_NAME).insert([{
            student_id,
            institution_id,
            supervisor_id,
            position_id,
            data_inicio,
            data_fim,
            valor_bolsa,
            valor_transporte,
            apolice_seguro,
            status: status || 'Ativo'
        }]).select();

        if (error) throw error;

        if ((currentOccupancy || 0) + 1 >= posData.quantidade) {
            await supabase.from('positions').update({ status: 'Ocupada' }).eq('id', position_id);
        }

        res.status(201).json({ message: 'Contract created.', data: data[0] });
    } catch (error) {
        console.error('ERRO CRÍTICO NO BACKEND (createContract):', error);
        res.status(500).json({ message: 'Erro interno ao criar contrato', error: (error as Error).message });
    }
};

export const getAllContracts = async (req: Request, res: Response) => {
    try {
        const { data, error } = await supabase
            .from(TABLE_NAME)
            .select(`
                *,
                students (nome),
                institutions (razao_social),
                supervisors (nome),
                positions (
                    id,
                    lotacoes (
                        unidade,
                        subunidade
                    )
                )
            `);

        if (error) throw error;
        res.status(200).json(data);
    } catch (error) {
        console.error('Erro ao buscar contratos:', error);
        res.status(500).json({ message: 'Erro ao buscar contratos', error: (error as Error).message });
    }
};

export const checkExpiringContracts = async (req: Request, res: Response) => {
    try {
        const today = new Date();
        const next30Days = new Date();
        next30Days.setDate(today.getDate() + 30);

        const { data, error } = await supabase
            .from(TABLE_NAME)
            .select('*, students(nome)')
            .eq('status', 'Ativo')
            .lte('data_fim', next30Days.toISOString())
            .gte('data_fim', today.toISOString());

        if (error) throw error;
        res.status(200).json(data);
    } catch (error) {
        res.status(503).json({ message: 'Error fetching expiring contracts', error: (error as Error).message });
    }
};

export const updateContract = async (req: Request, res: Response) => {
    const { id } = req.params;

    if (!id) {
        return res.status(400).json({ message: 'Contract ID is required.' });
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
            return res.status(404).json({ message: 'Contract not found.' });
        }

        res.status(200).json({ message: 'Contract updated successfully.', data: data[0] });
    } catch (error) {
        res.status(503).json({ message: 'Unable to update contract.', error: (error as Error).message });
    }
};

export const deleteContract = async (req: Request, res: Response) => {
    const { id } = req.params;

    if (!id) {
        return res.status(400).json({ message: 'Contract ID is required.' });
    }

    try {
        const { error } = await supabase
            .from(TABLE_NAME)
            .delete()
            .eq('id', id);

        if (error) {
            throw error;
        }

        res.status(200).json({ message: 'Contract deleted successfully.' });
    } catch (error) {
        res.status(503).json({ message: 'Unable to delete contract.', error: (error as Error).message });
    }
};
