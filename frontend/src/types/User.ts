import type { MainColor } from "./MainColor";


export interface User {
    id: number|null,
    name: string,
    email: string,
    plan: 'Free',
    mainColor: MainColor,
    hiddenData: boolean
}