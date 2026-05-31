import type { ResponseApi } from "../interfaces/ResponseApi";
import type { NewGoalData } from "../pages/Goals";
import { getMessageError } from "../utils/getMessageError";
import api from "./api";


export const goal = {

    async create(data: NewGoalData): Promise<ResponseApi>  
    {

        try {
            const response = await api.post("/goals/create", data);

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
            const response = await api.post("/goals/get", {id});

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