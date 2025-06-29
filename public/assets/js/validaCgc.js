document.getElementById('cgc').addEventListener('blur', function validaCGC() {
    const valor = this.value;
    const valido = validarCpfCnpj(valor);

    const errorInvalido = document.getElementById('error')

    if (!valido) {
        errorInvalido.style.display = "inline";
    } else {
        errorInvalido.style.display = "none";
    }
});


function validarCpfCnpj(valor) {
    const str = valor.replace(/\D/g, '');

    if (str.length === 11) return validaCPF(str);
    if (str.length === 14) return validaCNPJ(str);
    return false;
}


function validaCPF(cpf) {
    if (/^(\d)\1+$/.test(cpf)) return false;
    let soma = 0;
    for (let i = 0; i < 9; i++) soma += +cpf[i] * (10 - i);
    let dig1 = (soma * 10) % 11;
    if (dig1 === 10) dig1 = 0;
    if (dig1 !== +cpf[9]) return false;
    soma = 0;
    for (let i = 0; i < 10; i++) soma += +cpf[i] * (11 - i);
    let dig2 = (soma * 10) % 11;
    if (dig2 === 10) dig2 = 0;
    return dig2 === +cpf[10];

}


function validaCNPJ(cnpj) {
    if (/^(\d)\1+$/.test(cnpj)) return false;
    let calc = (base, peso) => {
        let soma = 0;
        for (let i = 0; i < base.length; i++) soma += +base[i] * peso[i];
        let resto = soma % 11;
        return resto < 2 ? 0 : 11 - resto;
    };
    const base = cnpj.slice(0, 12);
    const peso1 = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
    const peso2 = [6].concat(peso1);
    const dig1 = calc(base, peso1);
    const dig2 = calc(base + dig1, peso2);
    return cnpj.endsWith(`${dig1}${dig2}`);
}