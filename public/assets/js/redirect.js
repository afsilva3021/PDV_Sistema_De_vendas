const { contextBridge, ipcRenderer } = require('electron');

contextBridge.exposeInMainWorld('electron', {
  ipcRenderer: ipcRenderer,
});

document.addEventListener('DOMContentLoaded', () => {
  // Seleciona todos os elementos com a classe 'navigate-link'
  document.querySelectorAll('.navigate-link').forEach(link => {
    link.addEventListener('click', (event) => {
      event.preventDefault(); // Evita o comportamento padrão do link
      const targetPage = link.getAttribute('data-page'); // Obtém o destino da página
      if (targetPage) {
        ipcRenderer.send('navigate-to', targetPage); // Envia a mensagem ao processo principal
      }
    });
  });
})