import type { ValuesPeerDataDashboard } from "./ValuesPeerDataDashboard";

export interface Dashboard {
    income: string,
    expense: string,
    balance: string,
    peerMonths: ValuesPeerDataDashboard[],
    peerBudgets?: []
}