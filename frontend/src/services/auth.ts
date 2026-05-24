import type { ResponseApi } from '../interfaces/ResponseApi';
import api from './api';
import { getMessageError } from '../utils/getMessageError';

export const auth = {

    async login(data: object): Promise<ResponseApi> {

        await api.get('/sanctum/csrf-cookie');

        try {
            const response = await api.post("/login", data);

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

    async register(data: object): Promise<ResponseApi> {

        await api.get('/sanctum/csrf-cookie');

        try {
            const response = await api.post("/register", data);

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

    async logOut(data: object): Promise<ResponseApi> {
        try {
            const response = await api.post("/logout", data);

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