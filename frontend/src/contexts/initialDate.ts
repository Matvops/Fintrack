import type { Date } from "../types/Date";

const date = new Date();
const mes = date.toLocaleDateString('pt-BR', { month: 'long' });
const ano = date.toLocaleDateString('pt-BR', { year: 'numeric' });

export const initialDate: Date = {
    date: date.getTime(),
    formattedDate: mes.charAt(0).toUpperCase() + mes.slice(1) + ' ' + ano
}