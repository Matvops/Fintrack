import type { ResponseApi } from '../interfaces/ResponseApi';
import api from './api';

export const auth = {

    async login(data: object): Promise<ResponseApi>
    {

        await api.get('/sanctum/csrf-cookie'); 

        const response = await api.post("/login", data);
        
        return response.data;
    },

    async register(data: object): Promise<ResponseApi>
    {

        await api.get('/sanctum/csrf-cookie'); 

        const response = await api.post("/register", data);

        return response.data;
    },

    async logOut(data: object): Promise<ResponseApi>
    {
        const response = await api.post("/logout", data);

        return response.data;
    }

}