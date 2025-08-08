@vite(['resources/js/app.js'])

<div class="w-full max-w-7xl mx-auto px-4 mt-2 flex flex-col items-center">

  <!-- Título y botón -->
  <div class="w-full max-w-6xl px-4">
    <div class="p-4 flex flex-row justify-between items-center w-full max-w-6xl">
      <h3 class="text-xl font-semibold text-white">Control de Nutrición</h3>
      <div x-data="{ showAdd: false }">
        <button @click="showAdd = true"
          class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded shadow transition">
          Añadir Registro
        </button>

        <!-- Modal Añadir Registro -->
        <div 
          x-show="showAdd"
          class="fixed inset-0 bg-gray-900 bg-opacity-80 flex items-center justify-center z-50"
          x-cloak
          @click.outside="showAdd = false"
        >
          <div class="bg-gray-800 rounded-lg shadow-lg p-6 w-full max-w-md border border-gray-700">
            <h2 class="text-lg font-semibold mb-4 text-white">Añadir Registro de Crianza</h2>
            <form>
              <!-- Animal -->
              <div class="mb-4">
                <label class="block text-gray-300 font-medium mb-2">Animal</label>
                <select required
                  class="block w-full bg-gray-700 text-white rounded border-gray-600 focus:ring-blue-200 focus:border-blue-500">
                  <option value="">Seleccionar Animal</option>
                </select>
              </div>

              <!-- Descripción -->
              <div class="mb-4">
                <label class="block text-gray-300 font-medium mb-2">Descripción</label>
                <textarea rows="2" required
                  class="w-full bg-gray-700 text-white rounded border-gray-600 focus:ring-blue-200 focus:border-blue-500"></textarea>
              </div>

              <!-- Fecha -->
              <div class="mb-4">
                <label class="block text-gray-300 font-medium mb-2">Fecha</label>
                <input type="date" required
                  class="w-full bg-gray-700 text-white rounded border-gray-600 focus:ring-blue-200 focus:border-blue-500">
              </div>

              <!-- Responsable -->
              <div class="mb-4">
                <label class="block text-gray-300 font-medium mb-2">Responsable</label>
                <select required
                  class="block w-full bg-gray-700 text-white rounded border-gray-600 focus:ring-blue-200 focus:border-blue-500">
                  <option value="">Seleccionar Responsable</option>
                </select>
              </div>

              <button type="submit"
                class="w-full bg-green-700 hover:bg-green-800 text-white font-semibold py-2 px-4 rounded shadow transition">
                Guardar
              </button>
              <button @click="showAdd = false" type="button"
                class="mt-4 w-full bg-red-700 hover:bg-red-800 text-white font-semibold py-2 px-4 rounded shadow transition">
                Cancelar
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>

    

    <!-- Cards Crianza -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
      <!-- Ejemplo de card -->
      <div class="shadow-md rounded-lg overflow-hidden">
        <div class="bg-gray-600 rounded shadow p-3 space-y-3">
          <h5 class="text-xl font-bold mb-2 text-white">Nombre del Animal</h5>
          <p class="text-sm text-gray-200">
            <strong>Descripción:</strong> Texto de ejemplo...<br>
            <strong>Fecha:</strong> 06/08/2025<br>
            <strong>Responsable:</strong> Juan Pérez
          </p>
          <div class="flex gap-2 mt-2">
            <button class="bg-green-500 hover:bg-green-600 text-white text-sm px-4 py-1 rounded">Editar</button>
            <button class="bg-red-500 hover:bg-red-600 text-white text-sm px-4 py-1 rounded">Eliminar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>