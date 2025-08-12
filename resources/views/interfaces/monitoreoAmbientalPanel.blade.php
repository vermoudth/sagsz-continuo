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
  
  function obtenerClaseTexto(valor, min, max) {
    if (valor < min || valor > max) {
      return 'text-red-600 dark:text-red-400 font-semibold';
    }
    return 'text-green-600 dark:text-green-400 font-semibold';
  }

  async function cargarDatosAmbientales() {
    try {
      const res = await fetch('/api/registros-ambientales-ultimos');
      const data = await res.json();

      for (const cat in mapeoCategorias) {
        const card = document.getElementById(mapeoCategorias[cat]);
        card.innerHTML = `<h2 class="text-xl font-bold mb-2">🦜 Categoría: ${cat}</h2><p class="text-gray-400 italic">Sin datos</p>`;
      }

      data.forEach(reg => {
        const nombreCategoria = reg.categoria_nombre;
        const cardId = mapeoCategorias[nombreCategoria];
        if (cardId) {
          const card = document.getElementById(cardId);

          const claseTemp = obtenerClaseTexto(reg.temperatura, reg.temperatura_min, reg.temperatura_max);
          const claseHum = obtenerClaseTexto(reg.humedad, reg.humedad_min, reg.humedad_max);

          card.className = `bg-white dark:bg-gray-800 shadow rounded p-4`; // Fijo, no cambia
          card.innerHTML = `
            <h2 class="text-xl font-bold mb-2">🦜 Categoría: ${nombreCategoria}</h2>
            <p class="${claseTemp}">🌡️ Temp: ${reg.temperatura} °C</p>
            <p class="${claseHum}">💧 Humedad: ${reg.humedad} %</p>
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

