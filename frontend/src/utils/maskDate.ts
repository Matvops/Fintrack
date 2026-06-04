export function maskDate(value: string): string {
  let valor = value;

  valor = valor.replace(/\D/g, "");

  valor = valor.slice(0, 8);

  if (valor.length > 6) {
    return valor.replace(/^(\d{4})(\d{2})(\d{1,2})$/, '$1-$2-$3');
  } else if (valor.length > 4) {
    return valor.replace(/^(\d{4})(\d{1,2})$/, '$1-$2');
  }

  return value;
}