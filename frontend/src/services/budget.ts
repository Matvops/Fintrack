import type { ResponseApi } from "../interfaces/ResponseApi";
import type { NewBudgetData } from "../pages/Budgets";
import type { Budget } from "../types/Budget";
import { getMessageError } from "../utils/getMessageError";
import api from "./api";


export const budget = {

    async create(data: NewBudgetData): Promise<ResponseApi>  
    {

        try {
            const response = await api.post("/budgets/create", data);

            return response.data;
        } catch (error: unknown) {

            const message = getMessageError(error);

            return {
                status: false,
                message: message,
                data: {}
            };
        }
    },

    async edit(data: Budget): Promise<ResponseApi>  
    {

        try {
            const response = await api.post("/budgets/edit", data);

            return response.data;
        } catch (error: unknown) {

            const message = getMessageError(error);

            return {
                status: false,
                message: message,
                data: {}
            };
        }
    },

    async delete(id: number): Promise<ResponseApi>  
    {

        try {
            const response = await api.post("/budgets/delete", {id});

            return response.data;
        } catch (error: unknown) {

            const message = getMessageError(error);

            return {
                status: false,
                message: message,
                data: {}
            };
        }
    },

    async get(id: number|null): Promise<ResponseApi> 
    {

        try {
            const response = await api.post("/budgets/get", {id});

            return response.data;
        } catch (error: unknown) {

            const message = getMessageError(error);

            return {
                status: false,
                message: message,
                data: {}
            };
        }
    }
}