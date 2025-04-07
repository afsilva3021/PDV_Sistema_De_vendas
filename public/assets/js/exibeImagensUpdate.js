// Função para mostrar as imagens carregadas
document.getElementById('imageInput').addEventListener('change', function (event) {
  var files = event.target.files;
  var container = document.getElementById('image-container');
  container.innerHTML = ''; // Limpa o container antes de adicionar as novas imagens

  // Loop através dos arquivos selecionados
  for (var i = 0; i < files.length; i++) {
    var file = files[i];
    var reader = new FileReader();

    // Quando o arquivo for carregado, ele será exibido
    reader.onload = function (e) {
      var imgElement = document.createElement('img');
      imgElement.src = e.target.result;

      var divElement = document.createElement('div');
      divElement.classList.add('image-item');
      divElement.appendChild(imgElement);

      // Adiciona a nova imagem no container
      container.appendChild(divElement);
    };

    reader.readAsDataURL(file); // Converte a imagem em uma URL utilizável
  }
});