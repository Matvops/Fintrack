import type { ResponseApi } from "../interfaces/ResponseApi";
import { getMessageError } from "../utils/getMessageError";
import api from "./api";


export const dashboard = {


    async get(id: number|null): Promise<ResponseApi> 
    {

        try {
            const response = await api.post("/dashboard/get", {id});

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