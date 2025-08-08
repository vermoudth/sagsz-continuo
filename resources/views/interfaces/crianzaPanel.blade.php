<!-- Importacion de crianzaModulo.js -->
@vite(['resources/js/app.js'])

<!-- Contenedor principal con Tailwind -->
<div class="w-full max-w-7xl mx-auto px-4 mt-2 flex flex-col items-center">
  <!-- Título de la sección -->
  <div class="w-full max-w-6xl px-4">
    
    <!-- Botón para añadir nueva crianza y título -->
    <div class="p-4 flex flex-row justify-between items-center w-full max-w-6xl">
      <h3 class="text-xl font-semibold text-white">Crianza de Animales</h3>
      <!-- Botón que activa el modal -->
      <div x-data="{ showAdd: false }">
        <!-- Botón que activa el modal -->
        <button @click="showAdd = true"
          class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded shadow transition">
          Añadir Crianza
        </button>
        <!-- Modal para añadir crianza -->
        <div 
          x-show="showAdd" 
          class="fixed inset-0 bg-gray-900 bg-opacity-80 flex items-center justify-center z-50"
          x-cloak
          @click.outside="showAdd = false"
          >
          <div class="bg-gray-800 rounded-lg shadow-lg p-6 w-full max-w-md border border-gray-700">
            <h2 class="text-lg font-semibold mb-4 text-white">Añadir Crianza</h2>
            <form action="{{ route('crianza.store') }}" method="POST">
              @csrf
              <!-- Campo Animal -->
              <div class="mb-4">
                <label for="animal_id" class="block text-gray-300 font-medium mb-2">Animal</label>
                <select class="block w-full rounded border-gray-600 bg-gray-700 text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" name="animal_id" required>
                  <option value="">Seleccionar Animal</option>
                  @foreach($animales as $animal)
                    <option value="{{ $animal->id }}">{{ $animal->nombre }}</option>
                  @endforeach
                </select>
              </div>
              <!-- Campo Descripción -->
              <div class="mb-4">
                <label for="descripcion" class="block text-gray-300 font-medium mb-2">Descripción</label>
                <textarea class="block w-full rounded border-gray-600 bg-gray-700 text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" name="descripcion" rows="3" required></textarea>
              </div>
              <!-- Campo Fecha -->
              <div class="mb-4">
                <label for="fecha" class="block text-gray-300 font-medium mb-2">Fecha</label>
                <input type="date" class="block w-full rounded border-gray-600 bg-gray-700 text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" name="fecha" required>
              </div>
              <!-- Campo Responsable -->
              <div class="mb-4">
                <label for="responsable_id" class="block text-gray-300 font-medium mb-2">Responsable</label>
                <select class="block w-full rounded border-gray-600 bg-gray-700 text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" name="responsable_id" required>
                  <option value="">Seleccionar Responsable</option>
                  @foreach($usuarios as $usuario)
                    <option value="{{ $usuario->id }}">{{ $usuario->nombre }}</option>
                  @endforeach
                </select>
              </div>
              <button type="submit" class="w-full bg-blue-700 hover:bg-blue-800 text-white font-semibold py-2 px-4 rounded shadow transition">Guardar</button>
            </form>
            <!-- Botón para cerrar el modal -->
            <button @click="showAdd = false"
              class="mt-4 w-full bg-red-700 hover:bg-red-800 text-white font-semibold py-2 px-4 rounded shadow transition">
              Cerrar
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Filtro de categorías 
    <div class="flex justify-end mb-4">
        <select id="filtro-categoria" class="border rounded px-3 py-2" @change="filtrarCategoria">
            <option value="">Todas las categorías</option>
            @foreach ($categorias as $categoria)
                <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
            @endforeach
        </select>
    </div>-->

    <!-- Cards para mostrar las crianzas -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4" id="contenedor-crianza">
      @foreach($crianzas as $crianza)
        <div class="shadow-md rounded-lg overflow-hidden">
          <div class="bg-gray-600 rounded shadow p-2 space-y-3" data-categoria="{{ $crianza->animal->categoria }}">
            <div class="card-body">
              <h5 class="text-xl font-bold mb-2">{{ $crianza->animal->nombre }}</h5>
              <p class="text-sm space-y-1">
                <span class="flex items-center gap-2">
                  <!-- Icono calendario -->
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3M16 7V3M4 11h16M4 19h16M4 15h16M4 7h16" />
                  </svg>
                  Fecha de Registro: {{ \Carbon\Carbon::parse($crianza->fecha)->format('d/m/Y') }}
                </span>
                <span class="flex items-center gap-2">
                  <!-- Icono comentario -->
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M21 12c0-4.418-4.03-8-9-8S3 7.582 3 12s4.03 8 9 8c1.55 0 3-.354 4.243-.98l3.514.727a1 1 0 001.212-1.212l-.727-3.514A7.963 7.963 0 0021 12z" />
                  </svg>
                  Descripción: {{ Str::limit($crianza->descripcion, 50) }}
                </span>
                <span class="flex items-center gap-2">
                  <!-- Icono reloj -->
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3M12 2a10 10 0 100 20 10 10 0 000-20z" />
                  </svg>
                  Fecha: {{ $crianza->fecha }}
                </span>
                <span class="flex items-center gap-2">
                  <!-- Icono usuario -->
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.577 0 4.97.733 6.879 1.993M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                  </svg>
                  Responsable: {{ $crianza->responsable->nombre }}
                </span>
              </p>

              <div class="flex gap-4 mt-4">
                <button 
                  @click="$dispatch('open-edit-modal', {
                    id: {{ $crianza->id }},
                    animal: {{ $crianza->animal_id }},
                    descripcion: '{{ addslashes($crianza->descripcion) }}',
                    fecha: '{{ $crianza->fecha }}',
                    responsable_id: {{ $crianza->responsable_id }}
                  })"
                  class="flex flex-col sm:flex-row gap-2 sm:gap-4 mt-4 bg-green-500 hover:bg-green-600 text-white font-bold rounded text-sm px-4 py-2"
                  >
                  Editar
                </button>
                <button type="submit"
                  @click="$dispatch('open-delete-modal', { id: {{ $crianza->id }} })"
                  class="flex flex-col sm:flex-row gap-2 sm:gap-4 mt-4 bg-red-500 hover:bg-red-600 text-white font-bold rounded text-sm px-4 py-2">
                    Eliminar
                </button>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>

    <!-- Paginación -->
    <div class="flex justify-center mt-4 pagination">
      {{ $crianzas->appends(['categoria_id' => request('categoria_id')])->links() }} <!-- Esto genera la paginación, ahora centrada con Tailwind -->
    </div>

    <!-- Modal para eliminar crianza -->
    <div 
      x-data="{ abierto: false }"
      @open-delete-modal.window="abierto = true; id = $event.detail.id"
      x-show="abierto"
      x-cloak
      class="fixed inset-0 bg-gray-900 bg-opacity-80 flex items-center justify-center z-50"
       @click.outside="abierto = false"
      >
      <div class="bg-gray-800 rounded-lg p-6 shadow-lg max-w-md w-full border-gray-700">
        <h2 class="text-lg font-semibold text-white mb-4">¿Estás seguro de que deseas eliminar este registro?</h2>
        <div class="flex justify-end gap-4">
          <button 
            @click="abierto = false"
            class="px-4 py-2 bg-gray-300 hover:bg-gray-400 rounded text-black text-sm">
            Cancelar
          </button>
          <form action="{{ route('crianza.destroy', $crianza->id) }}" method="POST" class="inline">
            @csrf
            @method('DELETE')
            <button 
              type="submit" 
              class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded text-sm">
              Eliminar
            </button>
          </form>
        </div>
      </div>
    </div>

    <!-- Modal para Editar Crianza -->
    <div
      @open-edit-modal.window="abrirModal($event.detail)"
      x-init="$watch('abierto', value => { if (!value) formData = { id: null, animal_id: '', descripcion: '', fecha: '', responsable_id: '' }; })"
      x-data="window.editarCrianza ? editarCrianza() : {}" 
      x-show="abierto"
      x-cloak
      class="fixed inset-0 bg-gray-900 bg-opacity-80 flex items-center justify-center z-50"
       @click.outside="abierto = false"  
      >
      <div class="bg-gray-800 rounded-lg shadow-lg p-6 w-full max-w-md border border-gray-700">
        <h2 class="text-lg font-semibold mb-4 text-white">Editar Crianza</h2>
          <form :action="`/crianza/${formData.id}`" method="POST" id="editForm">
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

              <!-- Descripción -->
              <div class="mb-4">
                <label for="edit_descripcion" class="block text-gray-300 font-medium mb-2">Descripción</label>
                  <textarea type="text" x-model="formData.descripcion" name="descripcion" rows="3" required
                    class="block w-full rounded border-gray-600 bg-gray-700 text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                  </textarea>
              </div>

              <!-- Fecha -->
              <div class="mb-4">
                <label class="block text-gray-300 font-medium mb-2">Fecha</label>
                <input type="date" x-model="formData.fecha" name="fecha" required
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

              <!-- Botones -->
              <button type="submit" class="w-full bg-green-700 hover:bg-green-800 text-white font-semibold py-2 px-4 rounded shadow transition">
                Actualizar
              </button>
              <button @click="abierto = false"
                class="mt-4 w-full bg-red-700 hover:bg-red-800 text-white font-semibold py-2 px-4 rounded shadow transition">
                Cancelar
              </button>
          </form>
      </div>
    </div>
  </div>
</div>


<script>
 /*   document.addEventListener("DOMContentLoaded", function () {
        const filtroCategorias = document.getElementById("filtro-categoria");
    
        filtroCategorias.addEventListener("change", function () {
            let categoriaSeleccionada = this.value;
            let cards = document.querySelectorAll("#contenedor-crianza .card");
    
            cards.forEach(card => {
                let categoria = card.getAttribute("data-categoria");
    
                if (categoriaSeleccionada === "" || categoria === categoriaSeleccionada) {
                    card.style.display = "block"; // Mostrar la card
                } else {
                    card.style.display = "none"; // Ocultar la card
                }
            });
        });
    });*/
</script>

