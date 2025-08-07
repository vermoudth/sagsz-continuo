window.editarCrianza = function () {
    return {
        abierto: false,
        formData: {
            id: null,
            animal_id: '',
            descripcion: '',
            fecha: '',
            responsable_id: ''
        },
        abrirModal(data) {
            this.formData = {
                ...data,
                animal_id: String(data.animal),
                fecha: this.formatearFecha(data.fecha)
            };
            this.abierto = true;
        },
        cerrarModal() {
            this.abierto = false;
        },
        formatearFecha(fechaCompleta) {
            return fechaCompleta?.split(' ')[0] || '';
        }
    };
};

/*window.crianzaFunciones = {
    filtrarCategoria() {
        const categoriaId = document.getElementById('filtro-categoria').value;
        const url = `/crianza?categoria_id=${categoriaId}`;

        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(html => {
            document.getElementById('contenedor-crianza-panel').innerHTML = html;
        });
    }
};*/

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

          const newCards = doc.querySelector('#contenedor-crianza');
          const newPagination = doc.querySelector('.pagination');

          if (newCards && newPagination) {
            document.querySelector('#contenedor-crianza').innerHTML = newCards.innerHTML;
            document.querySelector('.pagination').innerHTML = newPagination.innerHTML;
          }
        })
        .catch(err => console.error(err));
      }
    });
});

