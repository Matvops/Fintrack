export const formatToReal = (valor: string): string => {

    const apenasNumeros = valor.replace(/\D/g, '');

    let valorNumerico = Number(apenasNumeros);
    if(valor.includes('.') || valor.includes(',')) {
        valorNumerico /=  100;
    }

    return new Intl.NumberFormat('pt-BR', {
        style: 'currency',
        currency: 'BRL',
    }).format(valorNumerico);
};