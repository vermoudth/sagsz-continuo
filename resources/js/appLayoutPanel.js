function cargarSeccion(ruta) {
  const contenedor = document.getElementById('contenido-dinamico');
  contenedor.innerHTML = '<div class="text-center p-4">Cargando...</div>';

  fetch(ruta, {
    headers: {
      'X-Requested-With': 'XMLHttpRequest' // Laravel detecta esto como AJAX
    }
  })
  .then(response => {
      if (!response.ok) throw new Error('Error al cargar la sección');
      return response.text();
    })
    .then(html => {
      contenedor.innerHTML = html;
      Alpine.initTree(contenedor);

      window.history.pushState({ ruta }, '', ruta);
    })
    .catch(error => {
      console.error(error);
      contenedor.innerHTML = '<div class="text-center text-red-500 p-4">Error al cargar la sección.</div>';
    });

}

// Volver atrás con botones del navegador
window.addEventListener('popstate', (event) => {
  if (event.state?.ruta) {
    cargarSeccion(event.state.ruta);
  }
});


// Esperar a que el DOM esté completamente cargado antes de agregar los event listeners
// y asignar los manejadores de eventos a los enlaces del sidebar
document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('.sidebar-link').forEach(link => {
    link.addEventListener('click', function(e) {
      e.preventDefault();
      const ruta = this.dataset.ruta;

      cargarSeccion(ruta);
      document.getElementById('homePanel').style.display = 'none';
    });
  });
});

// Carga dinamica de secciones al hacer clic en enlaces con data-ruta
// y actualizar el breadcrumb
document.addEventListener('DOMContentLoaded', function () {
  const enlaces = document.querySelectorAll('[data-ruta]');

  enlaces.forEach(link => {
    link.addEventListener('click', function (e) {
      e.preventDefault();

      const ruta = this.getAttribute('data-ruta');
      const titulo = this.getAttribute('data-titulo') || 'Sección';


      cargarSeccion(ruta);

      // Actualizar breadcrumb
      const breadcrumbOl = document.getElementById('breadcrumb-ol');
      if (breadcrumbOl) {
        breadcrumbOl.innerHTML = `
          <li>
            <a href="/homePanel" class="hover:underline">Panel de Inicio</a>
          </li>
          <li>/</li>
          <li class="text-white-500 dark:text-white-300">${titulo}</li>
        `;
      }
    });
  });
});

document.addEventListener('DOMContentLoaded', function () {
  const path = window.location.pathname;

  // Lista de rutas válidas
  const rutasValidas = {
    '/trasladosPanel': 'Traslados',
    '/crianza': 'Crianza',
    '/laboratorio': 'Laboratorio',
    '/crianza': 'Crianza',
    // Agrega aquí más si lo necesitas
  };

  if (rutasValidas[path]) {
    cargarSeccion(path);

    // Actualizar breadcrumb también
    const breadcrumbOl = document.getElementById('breadcrumb-ol');
    if (breadcrumbOl) {
      breadcrumbOl.innerHTML = `
        <li>
          <a href="/homePanel" class="hover:underline">Panel de Inicio</a>
        </li>
        <li>/</li>
        <li class="text-white-500 dark:text-white-300">${rutasValidas[path]}</li>
      `;
    }

    document.getElementById('homePanel').style.display = 'block'; // o como manejes la visibilidad
  }
});
