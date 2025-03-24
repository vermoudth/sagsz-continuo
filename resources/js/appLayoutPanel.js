

function cargarSeccion(ruta) {
  fetch(ruta)
      .then(response => response.text())
      .then(html => {
          document.getElementById('contenido-dinamico').innerHTML = html;
      })
      .catch(error => console.error('Error al cargar la sección:', error));
}

document.addEventListener('DOMContentLoaded', function() {
  document.getElementById('crianza-link').addEventListener('click', function(e) {
      e.preventDefault();
      cargarSeccion(routePanelAnimales);
      document.getElementById('homePanel').style.display = 'none';
  });
});