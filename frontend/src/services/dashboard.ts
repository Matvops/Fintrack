import type { ResponseApi } from "../interfaces/ResponseApi";
import { getMessageError } from "../utils/getMessageError";
import api from "./api";


export const dashboard = {


    async get(id: number|null, date: number): Promise<ResponseApi> 
    {

        try {
            const response = await api.post("/dashboard/get", {id, date});

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