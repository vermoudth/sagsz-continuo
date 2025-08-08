@vite(['resources/js/app.js'])

<div class="w-full max-w-7xl mx-auto px-4 mt-2 flex flex-col items-center">

  <!-- Título y botón agregar -->
  <div class="w-full max-w-6xl px-4">
    <div class="p-4 flex justify-between items-center">
      <h3 class="text-xl font-semibold text-white">Laboratorio</h3>

      <div x-data="{ showAdd: false }">
        <button @click="showAdd = true"
          class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded shadow transition">
          Añadir Registro
        </button>

        <!-- Modal Añadir -->
        <div x-show="showAdd"
             class="fixed inset-0 bg-gray-900 bg-opacity-80 flex items-center justify-center z-50"
             x-cloak @click.outside="showAdd = false">
          <div class="bg-gray-800 rounded-lg shadow-lg p-6 w-full max-w-md border border-gray-700">
            <h2 class="text-lg font-semibold mb-4 text-white">Añadir Registro Laboratorio</h2>
            <form action="{{ route('laboratorio.store') }}" method="POST">
              @csrf

              <!-- Animal -->
              <div class="mb-4">
                <label for="animal_id" class="block text-gray-300 font-medium mb-2">Animal</label>
                <select name="animal_id" required
                  class="block w-full rounded border-gray-600 bg-gray-700 text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                  <option value="">Seleccionar Animal</option>
                  @foreach($animales as $animal)
                    <option value="{{ $animal->id }}">{{ $animal->nombre }}</option>
                  @endforeach
                </select>
              </div>

              <!-- Diagnóstico -->
              <div class="mb-4">
                <label for="diagnostico" class="block text-gray-300 font-medium mb-2">Diagnóstico</label>
                <textarea name="diagnostico" rows="3" required
                  class="block w-full rounded border-gray-600 bg-gray-700 text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"></textarea>
              </div>

              <!-- Tratamiento -->
              <div class="mb-4">
                <label for="tratamiento" class="block text-gray-300 font-medium mb-2">Tratamiento</label>
                <textarea name="tratamiento" rows="3" required
                  class="block w-full rounded border-gray-600 bg-gray-700 text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"></textarea>
              </div>

              <!-- Fecha -->
              <div class="mb-4">
                <label for="fecha" class="block text-gray-300 font-medium mb-2">Fecha</label>
                <input type="date" name="fecha" required
                  class="block w-full rounded border-gray-600 bg-gray-700 text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
              </div>

              <!-- Responsable -->
              <div class="mb-4">
                <label for="responsable_id" class="block text-gray-300 font-medium mb-2">Responsable</label>
                <select name="responsable_id" required
                  class="block w-full rounded border-gray-600 bg-gray-700 text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                  <option value="">Seleccionar Responsable</option>
                  @foreach($usuarios as $usuario)
                    <option value="{{ $usuario->id }}">{{ $usuario->nombre }}</option>
                  @endforeach
                </select>
              </div>

              <button type="submit" class="w-full bg-blue-700 hover:bg-blue-800 text-white font-semibold py-2 px-4 rounded shadow transition">
                Guardar
              </button>
            </form>
            <button @click="showAdd = false"
              class="mt-4 w-full bg-red-700 hover:bg-red-800 text-white font-semibold py-2 px-4 rounded shadow transition">
              Cerrar
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Cards listado -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4" id="contenedor-laboratorio-panel">
      @foreach($laboratorios as $lab)
      <div class="shadow-md rounded-lg overflow-hidden">
        <div class="bg-gray-600 rounded shadow p-4" data-categoria="{{ $lab->animal->categoria }}">
          <h5 class="text-xl font-bold mb-2">{{ $lab->animal->nombre }}</h5>

          <p class="text-sm mb-2"><strong>Diagnóstico:</strong> {{ Str::limit($lab->diagnostico, 50) }}</p>
          <p class="text-sm mb-2"><strong>Tratamiento:</strong> {{ Str::limit($lab->tratamiento, 50) }}</p>

          <p class="text-sm mb-1 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3M16 7V3M4 11h16M4 19h16M4 15h16M4 7h16" />
            </svg>
            Fecha: {{ \Carbon\Carbon::parse($lab->fecha)->format('d/m/Y') }}
          </p>

          <p class="text-sm flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.577 0 4.97.733 6.879 1.993M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            Responsable: {{ $lab->responsable->nombre }}
          </p>

          <div class="flex gap-4 mt-4">
            <button 
              @click="$dispatch('open-edit-modal', {
                id: {{ $lab->id }},
                animal_id: {{ $lab->animal_id }},
                diagnostico: '{{ addslashes($lab->diagnostico) }}',
                tratamiento: '{{ addslashes($lab->tratamiento) }}',
                fecha: '{{ $lab->fecha }}',
                responsable_id: {{ $lab->responsable_id }}
              })"
              class="bg-green-500 hover:bg-green-600 text-white font-bold rounded text-sm px-4 py-2">
              Editar
            </button>

            <button 
              @click="$dispatch('open-delete-modal', { id: {{ $lab->id }} })"
              class="bg-red-500 hover:bg-red-600 text-white font-bold rounded text-sm px-4 py-2">
              Eliminar
            </button>
          </div>
        </div>
      </div>
      @endforeach
    </div>

    <!-- Paginación -->
    <div class="flex justify-center mt-4 pagination">
      {{ $laboratorios->links() }}
    </div>

    <!-- Modal Eliminar -->
    <div 
      x-data="{ abierto: false, id: null }"
      @open-delete-modal.window="abierto = true; id = $event.detail.id"
      x-show="abierto"
      x-cloak
      class="fixed inset-0 bg-gray-900 bg-opacity-80 flex items-center justify-center z-50"
      @click.outside="abierto = false"
    >
      <div class="bg-gray-800 rounded-lg p-6 shadow-lg max-w-md w-full border-gray-700">
        <h2 class="text-lg font-semibold text-white mb-4">¿Seguro que quieres eliminar este registro?</h2>
        <div class="flex justify-end gap-4">
          <button @click="abierto = false"
            class="px-4 py-2 bg-gray-300 hover:bg-gray-400 rounded text-black text-sm">Cancelar</button>

          <form :action="`/laboratorio/${id}`" method="POST" class="inline" x-ref="deleteForm">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded text-sm">Eliminar</button>
          </form>
        </div>
      </div>
    </div>

    <!-- Modal Editar -->
    <div 
      x-data="editarLaboratorio()"
      x-show="abierto"
      x-cloak
      class="fixed inset-0 bg-gray-900 bg-opacity-80 flex items-center justify-center z-50"
      @click.outside="cerrarModal()"
      @open-edit-modal.window="abrirModal($event.detail)"
    >
      <div class="bg-gray-800 rounded-lg shadow-lg p-6 w-full max-w-md border border-gray-700">
        <h2 class="text-lg font-semibold mb-4 text-white">Editar Registro Laboratorio</h2>
        <form :action="`/laboratorio/${formData.id}`" method="POST" @submit="submitForm($event)">
          @csrf
          @method('PUT')

          <!-- Animal -->
          <div class="mb-4">
            <label class="block text-gray-300 font-medium mb-2">Animal</label>
            <select name="animal_id" x-model="formData.animal_id" required
              class="block w-full rounded border-gray-600 bg-gray-700 text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
              <option value="">Seleccionar Animal</option>
              @foreach ($animales as $animal)
                <option value="{{ $animal->id }}">{{ $animal->nombre }}</option>
              @endforeach
            </select>
          </div>

          <!-- Diagnóstico -->
          <div class="mb-4">
            <label class="block text-gray-300 font-medium mb-2">Diagnóstico</label>
            <textarea name="diagnostico" x-model="formData.diagnostico" rows="3" required
              class="block w-full rounded border-gray-600 bg-gray-700 text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"></textarea>
          </div>

          <!-- Tratamiento -->
          <div class="mb-4">
            <label class="block text-gray-300 font-medium mb-2">Tratamiento</label>
            <textarea name="tratamiento" x-model="formData.tratamiento" rows="3" required
              class="block w-full rounded border-gray-600 bg-gray-700 text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"></textarea>
          </div>

          <!-- Fecha -->
          <div class="mb-4">
            <label class="block text-gray-300 font-medium mb-2">Fecha</label>
            <input type="date" name="fecha" x-model="formData.fecha" required
              class="block w-full rounded border-gray-600 bg-gray-700 text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
          </div>

          <!-- Responsable -->
          <div class="mb-4">
            <label class="block text-gray-300 font-medium mb-2">Responsable</label>
            <select name="responsable_id" x-model="formData.responsable_id" required
              class="block w-full rounded border-gray-600 bg-gray-700 text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
              <option value="">Seleccionar Responsable</option>
              @foreach($usuarios as $usuario)
                <option value="{{ $usuario->id }}">{{ $usuario->nombre }}</option>
              @endforeach
            </select>
          </div>

          <button type="submit" class="w-full bg-green-700 hover:bg-green-800 text-white font-semibold py-2 px-4 rounded shadow transition">
            Actualizar
          </button>
          <button type="button" @click="cerrarModal()"
            class="mt-4 w-full bg-red-700 hover:bg-red-800 text-white font-semibold py-2 px-4 rounded shadow transition">
            Cancelar
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
function editarLaboratorio() {
  return {
    abierto: false,
    formData: {
      id: null,
      animal_id: '',
      diagnostico: '',
      tratamiento: '',
      fecha: '',
      responsable_id: '',
    },
    abrirModal(data) {
      this.formData = { ...data };
      this.abierto = true;
    },
    cerrarModal() {
      this.abierto = false;
      this.formData = {
        id: null,
        animal_id: '',
        diagnostico: '',
        tratamiento: '',
        fecha: '',
        responsable_id: '',
      };
    },
    submitForm(event) {
      // Puedes agregar validaciones aquí si quieres
      // Por defecto el form se envía
    }
  }
}
</script>
