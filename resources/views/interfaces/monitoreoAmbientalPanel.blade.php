<div id="contenedor-tarjetas" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-4">
    <!-- Tarjetas dinámicas -->
</div>

<script>
  async function cargarDatosAmbientales() {
    await fetch('/api/registros-ambientales-ultimos',{
      headers: {
        'Accept': 'application/json'
      }
    })
      .then(res => res.json())
      .then(data => {
        const contenedor = document.getElementById('contenedor-tarjetas');
        contenedor.innerHTML = '';

        data.forEach(reg => {
          const tarjeta = document.createElement('div');
          tarjeta.className = 'bg-white dark:bg-gray-800 shadow rounded p-4';

          tarjeta.innerHTML = `
            <h2 class="text-xl font-bold mb-2">🦜 Categoría: ${reg.categoria?.nombre || 'Sin nombre'}</h2>
            <p>🌡️ Temp: ${reg.temperatura} °C</p>
            <p>💧 Humedad: ${reg.humedad} %</p>
            <p class="text-sm text-gray-500">⏱️ ${new Date(reg.registrado_en).toLocaleTimeString()}</p>
          `;

          contenedor.appendChild(tarjeta);
        });
      })
      .catch(err => console.error('Error al cargar datos:', err));
  }

  // Carga inicial y cada 5 segundos
  cargarDatosAmbientales();
  setInterval(cargarDatosAmbientales, 5000);
</script>
