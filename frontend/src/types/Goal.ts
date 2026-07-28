import type { MainColor } from "./MainColor";


export interface Goal {
    balance: string,
    balanceTarget: string,
    color: MainColor,
    id: number,
    name: string,
    userId?: number,
    missing?: string,
    percentage?: number,
    created_at?: string|number,
    updated_at?: string|number,
}