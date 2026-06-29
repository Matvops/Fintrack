import { useContext } from "react";
import { UserContext } from "../contexts/UserContext";

export function useFormatToReal() {

    const { user } = useContext(UserContext);

    return (valor: string): string => {
        if (user.hiddenData) {
            return '••••'; 
        }

        const apenasNumeros = valor.replace(/\D/g, '');

        const valorNumerico = Number(apenasNumeros) / 100;

        return new Intl.NumberFormat('pt-BR', {
            style: 'currency',
            currency: 'BRL',
        }).format(valorNumerico);
    };
}

