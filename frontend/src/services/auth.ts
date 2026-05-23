import api from './api';

export const auth = {

    async login(data: object) {

        await api.get('/sanctum/csrf-cookie'); 

        const response = await api.post("/login", data);
        
        return response.data;
    },

    async register(data: object) {

        await api.get('/sanctum/csrf-cookie'); 

        const response = await api.post("/register", data);

        return response.data;
    },

    async logOut(data: object) {
        const response = await api.post("/logout", data);

        return response.data;
    }

}