document.addEventListener('DOMContentLoaded', function () {
    // Delegación de eventos a los links de paginación
    document.addEventListener('click', function (e) {
      if (e.target.closest('.pagination a')) {
        e.preventDefault();

        const url = e.target.closest('a').getAttribute('href');
        
        fetch(url, {
          headers: {
            'X-Requested-With': 'XMLHttpRequest'
          }
        })
        .then(res => res.text())
        .then(html => {
          // Extrae solo el contenido nuevo de las cards y paginación
          const parser = new DOMParser();
          const doc = parser.parseFromString(html, 'text/html');

          const newCards = doc.querySelector('#contenedor-paginacion');
          const newPagination = doc.querySelector('.pagination');

          if (newCards && newPagination) {
            document.querySelector('#contenedor-paginacion').innerHTML = newCards.innerHTML;
            document.querySelector('.pagination').innerHTML = newPagination.innerHTML;
          }
        })
        .catch(err => console.error(err));
      }
    });
});