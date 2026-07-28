import type { MainColor } from "./MainColor";

export interface Budget {
    id: number,
    bdt_use_id?: number,
    name: string,
    limit: number|string,
    color: MainColor,
    create_at?: string|number,
    updated_at?: string|number,
    amountSpent?: string,
    remainingValue?: string,
    percentage?: number
}