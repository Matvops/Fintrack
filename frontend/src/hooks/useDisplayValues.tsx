import { useContext } from "react";
import { UserContext } from "../contexts/UserContext";

export function useFormatToReal() {

    const { user } = useContext(UserContext);

    return (valor: string): string => {
        if (user.hiddenData) {
            return '••••'; 
        }

        const apenasNumeros = valor.replace(/\D/g, '');

        let valorNumerico = Number(apenasNumeros);
        if (valor.includes('.') || valor.includes(',')) {
            valorNumerico /= 100;
        }

        return new Intl.NumberFormat('pt-BR', {
            style: 'currency',
            currency: 'BRL',
        }).format(valorNumerico);
    };
}

