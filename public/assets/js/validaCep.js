document.getElementById('errorCep').style.display = 'none';

document.getElementById('inputCep').addEventListener('blur', async function () {
    const cep = this.value.replace(/\D/g, '');

    if (cep.length !== 8) {
        document.getElementById('errorCep').style.display = 'block';
    } else {
        document.getElementById('errorCep').style.display = 'none';
    }

    try {
        const response = await fetch(`https://brasilapi.com.br/api/cep/v1/${cep}`);
        if (!response.ok) throw new Error('Erro ao consultar CEP');

        const data = await response.json()

        document.getElementById('inputLogradouro').value = data.street || '';
        document.getElementById('inputCidade').value = data.city || '';
        document.getElementById('inputEstado').value = data.state || '';
        document.getElementById('inputBairro').value = data.neighborhood || '';
        document.getElementById('inputLogradouro').value = data.street || '';
    } catch (error) {
        alert('Erro ao buscar o CEP: ' + error.message);
    }
});


