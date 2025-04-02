function validaSeha() {
  let senha = document.getElementById('senha').value;
  let confirmaSenha = document.getElementById('confirmaSenha').value;
  let mensagemErro = document.getElementById('mensagemErro');

  if (senha !== confirmaSenha) {
    mensagemErro.textContent = "As senha não coincidem!";
  } else {
    mensagemErro.textContent = "";
  }
}


document.getElementById('senha').addEventListener('input', validaSeha);
document.getElementById('configmaSenha').addEventListener('input', validaSeha);

