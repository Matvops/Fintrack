import type { NewTransationData } from "../pages/Transactions";
import { getMessageError } from "../utils/getMessageError";
import api from "./api";


export const transaction = {

    async create (data: NewTransationData){

        try {
            const response = await api.post("/transactions/create", data);

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

    async get (id: number, date: number){

        try {
            const response = await api.post("/transactions/get", {id, date});

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