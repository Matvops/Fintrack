import type { ResponseApi } from "../interfaces/ResponseApi";
import type { NewGoalData } from "../pages/Goals";
import { getMessageError } from "../utils/getMessageError";
import api from "./api";


export const goals = {

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
    }
}