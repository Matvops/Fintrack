import type { Budget } from "./Budget";
import type { TransactionType } from "./TransactionType";

export interface Transaction {
    tra_id: number,
    tra_use_id: number,
    tra_bdt_id: number|null,
    tra_description: string,
    tra_type: TransactionType,
    tra_value: string,
    tra_date: string,
    budget?: Budget,
    created_at?: string,
    updated_at?: string
}