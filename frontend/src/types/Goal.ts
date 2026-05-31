import type { MainColor } from "./MainColor";


export interface Goal {
    gls_balance: string,
    gls_balance_target: string,
    gls_color: MainColor,
    gls_id: number,
    gls_name: string,
    gls_use_id?: number,
    missing?: string,
    percentage?: number,
    created_at?: string|number,
    updated_at?: string|number,
}