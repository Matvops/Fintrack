import type { MainColor } from "./MainColor";

export interface Budget {
    bdt_id: number,
    bdt_use_id: number,
    bdt_name: string,
    bdt_limit: number,
    bdt_color: MainColor,
    create_at?: string|number,
    updated_at?: string|number
}