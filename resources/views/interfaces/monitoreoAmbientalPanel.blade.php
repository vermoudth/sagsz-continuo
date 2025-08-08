<div id="contenedor-tarjetas" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-4">
    <div id="card-aves" class="bg-white dark:bg-gray-800 shadow rounded p-4"></div>
    <div id="card-acuario" class="bg-white dark:bg-gray-800 shadow rounded p-4"></div>
    <div id="card-mamiferos" class="bg-white dark:bg-gray-800 shadow rounded p-4"></div>
    <div id="card-herpetofauna" class="bg-white dark:bg-gray-800 shadow rounded p-4"></div>
</div>


<script>
  const mapeoCategorias = {
    'Aves': 'card-aves',
    'Acuario': 'card-acuario',
    'Mamiferos': 'card-mamiferos',
    'Herpetofauna': 'card-herpetofauna'
  };

  async function cargarDatosAmbientales() {
    try {
      const res = await fetch('/api/registros-ambientales-ultimos', {
        headers: {
          'Accept': 'application/json'
        }
      });

      const data = await res.json();

      // Limpia los contenedores
      for (const categoria in mapeoCategorias) {
        const cardId = mapeoCategorias[categoria];
        const card = document.getElementById(cardId);
        card.innerHTML = `<h2 class="text-xl font-bold mb-2">🦜 Categoría: ${categoria}</h2><p class="text-gray-400 italic">Sin datos</p>`;
      }

      data.forEach(reg => {
        const nombreCategoria = reg.categoria?.nombre;
        const cardId = mapeoCategorias[nombreCategoria];

        if (cardId) {
          const card = document.getElementById(cardId);

          card.innerHTML = `
            <h2 class="text-xl font-bold mb-2">🦜 Categoría: ${nombreCategoria}</h2>
            <p>🌡️ Temp: ${reg.temperatura} °C</p>
            <p>💧 Humedad: ${reg.humedad} %</p>
            <p class="text-sm text-gray-500">⏱️ ${new Date(reg.registrado_en).toLocaleTimeString()}</p>
          `;
        }
      });
    } catch (err) {
      console.error('Error al cargar datos:', err);
    }
  }

  cargarDatosAmbientales();
  setInterval(cargarDatosAmbientales, 5000);
</script>

