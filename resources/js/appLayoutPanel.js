function cargarSeccion(ruta) {
  const contenedor = document.getElementById('contenido-dinamico');
  const homePanel = document.getElementById('homePanel');

  if (contenedor.dataset.loading === "true") return;

  if (ruta === '/homePanel') {
    // Mostrar homePanel y limpiar contenido dinámico
    homePanel.style.display = 'block';
    contenedor.innerHTML = '';
    window.history.pushState({ ruta }, '', ruta);
    return;
  }

  // Para otras rutas ocultamos homePanel y cargamos contenido dinámico
  homePanel.style.display = 'none';
  contenedor.dataset.loading = "true";
  contenedor.innerHTML = '<div class="text-center p-4">Cargando...</div>';

  fetch(ruta, {
    headers: {
      'X-Requested-With': 'XMLHttpRequest'
    }
  })
  .then(response => {
    if (!response.ok) throw new Error(`Error ${response.status}: ${response.statusText}`);
    return response.text();
  })
  .then(html => {
    contenedor.innerHTML = html;
    Alpine.initTree(contenedor);
    contenedor.dataset.loading = "false";

    if (window.location.pathname !== ruta) {
      window.history.pushState({ ruta }, '', ruta);
    }
  })
  .catch(error => {
    console.error(error);
    contenedor.dataset.loading = "false";
    contenedor.innerHTML = `
      <div class="text-center text-red-500 p-4">
        <p>Error al cargar la sección.</p>
        <p class="text-sm">${error.message}</p>
      </div>`;
  });
}

// Hacemos la función visible desde HTML
window.cargarSeccion = cargarSeccion;

// Manejo del historial del navegador (back/forward)
window.addEventListener("popstate", () => {
  const ruta = window.location.pathname;
  cargarSeccion(ruta);
});

document.addEventListener('DOMContentLoaded', function() {
  const breadcrumbOl = document.getElementById('breadcrumb-ol');

  // Manejo de clics en enlaces del sidebar y en Inicio
  document.querySelectorAll('[data-ruta], #inicio-link').forEach(link => {
    link.addEventListener('click', function(e) {
      e.preventDefault();

      // Ruta a cargar (para Inicio usamos '/homePanel')
      const ruta = this.getAttribute('data-ruta') || '/homePanel';
      cargarSeccion(ruta);

      // Actualizar breadcrumb
      if (breadcrumbOl) {
        if (ruta === '/homePanel') {
          breadcrumbOl.innerHTML = '';
          document.getElementById('homePanel').style.display = 'block';
        } else {
          const titulo = this.getAttribute('data-titulo') || 'Sección';
          breadcrumbOl.innerHTML = `
            <li><a href="/homePanel" class="hover:underline">Panel de Inicio</a></li>
            <li>/</li>
            <li class="text-white-500 dark:text-white-300">${titulo}</li>
          `;
          document.getElementById('homePanel').style.display = 'none';
        }
      }
    });
  });

  // Al cargar la página, si la ruta es válida, cargar contenido o mostrar homePanel
  const rutasValidas = {
    '/traslados': 'Traslados',
    '/crianza': 'Crianza',
    '/laboratorio': 'Laboratorio',
    '/nutricion': 'Nutrición',
  };

  const path = window.location.pathname;

  if (rutasValidas[path]) {
    cargarSeccion(path);

    if (breadcrumbOl) {
      breadcrumbOl.innerHTML = `
        <li><a href="/homePanel" class="hover:underline">Panel de Inicio</a></li>
        <li>/</li>
        <li class="text-white-500 dark:text-white-300">${rutasValidas[path]}</li>
      `;
    }

    document.getElementById('homePanel').style.display = 'none';
  } else if (path === '/homePanel' || path === '/') {
    // Mostrar homePanel si estamos en la raíz o en /homePanel
    document.getElementById('homePanel').style.display = 'block';
    if (breadcrumbOl) breadcrumbOl.innerHTML = '';
  }
});


