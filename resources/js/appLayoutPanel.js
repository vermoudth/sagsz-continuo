function cargarSeccion(ruta) {
  fetch(ruta)
    .then(response => response.text())
    .then(html => {
      if (window.Alpine) {
        Alpine.initTree(document.getElementById('contenido-dinamico'));
      }
    })
    .catch(error => console.error('Error al cargar la sección:', error));
}


document.addEventListener('DOMContentLoaded', function() {

  //Panel de Crianza
  document.getElementById('crianza-link').addEventListener('click', function(e) {
      e.preventDefault();
      cargarSeccion(routePanelCrianza);
      document.getElementById('homePanel').style.display = 'none';
  });

  //Panel de Traslados
  document.getElementById('traslados-link').addEventListener('click', function(e) {
    e.preventDefault();
    cargarSeccion(routePanelTraslados);
    document.getElementById('homePanel').style.display = 'none';
  });

});