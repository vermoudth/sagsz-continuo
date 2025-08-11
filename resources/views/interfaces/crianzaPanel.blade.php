@vite(['resources/js/app.js'])

<div class="w-full mt-2 flex flex-col items-center dark:bg-gray-900 dark:text-white transition-colors duration-300">
  <div class="w-full px-4 py-2 space-y-4 max-w-7xl">

    <!-- Mensajes de éxito y error -->
    @if(session('success'))
      <div class="bg-green-600 text-white rounded p-3 mb-4 shadow">
        {{ session('success') }}
      </div>
    @endif
    @if(session('error'))
      <div class="bg-red-600 text-white rounded p-3 mb-4 shadow">
        {{ session('error') }}
      </div>
    @endif

    <!-- Validación de errores del formulario (añadir y editar) -->
    @if($errors->any())
      <div class="bg-red-700 text-white rounded p-3 mb-4 shadow">
        <ul class="list-disc list-inside text-sm">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <!-- Botón + Modal para añadir crianza -->
    <div class="flex justify-end" x-data="{ showAdd: false }">
      <button 
        @click="showAdd = true"
        class="bg-blue-600 text-white px-3 py-1.5 rounded-md shadow hover:bg-blue-700 transition duration-200 text-sm flex items-center gap-2"
      >
        <i class="fas fa-plus text-sm"></i> Añadir Crianza
      </button>

      <!-- Modal Añadir Crianza -->
      <div 
        x-show="showAdd" 
        class="fixed inset-0 bg-gray-900 bg-opacity-80 flex items-center justify-center z-50"
        x-cloak
        @click.outside="showAdd = false"
      >
        <div class="bg-gray-800 rounded-lg shadow-lg p-6 w-full max-w-md border border-gray-700">

          <h2 class="text-lg font-semibold mb-4 text-white">Añadir Registro de Crianza</h2>

          <form action="{{ route('crianza.store') }}" method="POST">
            @csrf

            <!-- Campo Animal -->
            <div class="mb-4">
              <label for="animal_id" class="block text-gray-300 font-medium mb-2">Animal</label>
              <select 
                class="block w-full rounded border-gray-600 bg-gray-700 text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 @error('animal_id') border-red-500 @enderror"
                name="animal_id" required
              >
                <option value="">Seleccionar Animal</option>
                @foreach($animales as $animal)
                  <option value="{{ $animal->id }}" {{ old('animal_id') == $animal->id ? 'selected' : '' }}>
                    {{ $animal->nombre }}
                  </option>
                @endforeach
              </select>
              @error('animal_id')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
              @enderror
            </div>

            <!-- Campo Descripción -->
            <div class="mb-4">
              <label for="descripcion" class="block text-gray-300 font-medium mb-2">Descripción</label>
              <textarea
                name="descripcion" rows="3" required
                class="block w-full rounded border-gray-600 bg-gray-700 text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 resize-none @error('descripcion') border-red-500 @enderror"
                placeholder="Descripción de la crianza"
              >{{ old('descripcion') }}</textarea>
              @error('descripcion')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
              @enderror
            </div>

            <!-- Grupo Fecha y Responsable -->
            <div class="flex flex-col md:flex-row gap-4">
              <!-- Fecha -->
              <div class="flex-1">
                <label class="block text-gray-300 font-medium mb-2">Fecha</label>
                <input 
                  type="date" name="fecha" required
                  class="block w-full rounded border-gray-600 bg-gray-700 text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                >
              </div>

              <!-- Responsable -->
              <div class="flex-1">
                <label class="block text-gray-300 font-medium mb-2">Responsable</label>
                <select 
                  name="responsable_id" required
                  class="block w-full rounded border-gray-600 bg-gray-700 text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                >
                  <option value="">Seleccione responsable</option>
                  @foreach($usuarios as $usuario)
                    <option value="{{ $usuario->id }}"> 
                      {{ $usuario->nombre ?? 'Usuario sin nombre' }} - {{ $usuario->rol_id->nombre ?? 'Sin rol' }}

                    </option>
                  @endforeach
                </select>
              </div>
            </div>

            <!-- Botones -->
            <div class="flex justify-end gap-3 mt-4">
              <button type="submit"
                class="bg-blue-700 hover:bg-blue-800 text-white font-semibold py-2 px-4 rounded shadow transition text-sm"
              >
                Guardar
              </button>
                            <button 
                type="button" 
                @click="showAdd = false"
                class="bg-red-700 hover:bg-red-800 text-white font-semibold py-2 px-4 rounded shadow transition text-sm"
              >
                Cancelar
              </button>
            </div>
          </form>

        </div>
      </div>
    </div>

    <!-- Cards de crianza -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4" id="contenedor-paginacion">
      @forelse ($crianzas as $crianza)
        <div class="bg-gray-700 rounded-lg shadow p-4 flex flex-col justify-between text-white">
          <!-- Título con animal -->
          <h5 class="font-semibold text-lg mb-2 truncate">{{ $crianza->animal->nombre ?? 'Animal desconocido' }}</h5>

          <!-- Info compacta en fila -->
          <div class="flex flex-wrap gap-4 text-sm text-gray-300">
            <div class="flex items-center gap-1 min-w-[120px]">
              <!-- Icono calendario -->
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3M16 7V3M4 11h16M4 19h16M4 15h16M4 7h16" />
              </svg>
              <span>Registro: {{ \Carbon\Carbon::parse($crianza->fecha)->format('d/m/Y') }}</span>
            </div>
            <div class="flex items-center gap-1 min-w-[140px]">
              <!-- Icono comentario -->
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M21 12c0-4.418-4.03-8-9-8S3 7.582 3 12s4.03 8 9 8c1.55 0 3-.354 4.243-.98l3.514.727a1 1 0 001.212-1.212l-.727-3.514A7.963 7.963 0 0021 12z" />
              </svg>
              <span>{{ Str::limit($crianza->descripcion, 40) }}</span>
            </div>
            <div class="flex items-center gap-1 min-w-[120px]">
              <!-- Icono usuario -->
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.577 0 4.97.733 6.879 1.993M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
              </svg>
              <span>Resp.: {{ $crianza->responsable->nombre ?? 'N/A' }}</span>
            </div>
          </div>

          <!-- Botones en fila -->
          <div class="mt-4 flex gap-3 justify-end">
            <button 
              @click="$dispatch('open-edit-crianza', { 
                id: {{ $crianza->id }}, 
                animal_id: '{{ $crianza->animal_id }}',
                descripcion: '{{ addslashes($crianza->descripcion) }}',
                fecha: '{{ $crianza->fecha }}',
                responsable_id: '{{ $crianza->responsable_id }}'
              })"
              class="bg-green-600 hover:bg-green-700 px-3 py-1 rounded text-white text-sm font-semibold transition"
            >
              Editar
            </button>
            <button 
              @click="$dispatch('open-delete-crianza', { id: {{ $crianza->id }} })"
              class="bg-red-600 hover:bg-red-700 px-3 py-1 rounded text-white text-sm font-semibold transition"
            >
              Eliminar
            </button>
          </div>
        </div>
      @empty
        <div class="col-span-full text-center text-gray-400 py-12">
          <i class="fas fa-baby-carriage text-4xl mb-4"></i>
          No hay registros de crianza disponibles.
        </div>
      @endforelse
    </div>


    <!-- Paginación -->
    @if($crianzas instanceof \Illuminate\Pagination\LengthAwarePaginator && $crianzas->hasPages())
      <div class="flex justify-center mt-4 pagination">
        {{ $crianzas->links() }}
      </div>
    @endif


    <!-- Modal para eliminar crianza -->
    <div 
      x-data="{ abierto: false, id: null }"
      @open-delete-crianza.window="abierto = true; id = $event.detail.id"
      x-show="abierto"
      x-cloak
      class="fixed inset-0 bg-gray-900 bg-opacity-80 flex items-center justify-center z-50"
      @click.outside="abierto = false"
    >
      <div class="bg-gray-800 rounded-lg p-6 shadow-lg max-w-md w-full border border-gray-700">
        <h2 class="text-lg font-semibold text-white mb-4">¿Estás seguro de que deseas eliminar este registro?</h2>
        <div class="flex justify-end gap-4">
          <button 
            @click="abierto = false"
            class="px-4 py-2 bg-gray-300 hover:bg-gray-400 rounded text-black text-sm"
          >
            Cancelar
          </button>
          <form :action="`/crianza/${id}`" method="POST" class="inline">
            @csrf
            @method('DELETE')
            <button 
              type="submit" 
              class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded text-sm"
            >
              Eliminar
            </button>
          </form>
        </div>
      </div>
    </div>

    <!-- Modal para Editar Crianza -->
    <div
      @open-edit-crianza.window="abierto = true; formData = { ...$event.detail }"
      x-data="{
        abierto: false, 
        formData: { id: null, animal_id: '', descripcion: '', fecha: '', responsable_id: '' }
      }"
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
                  class="block w-full rounded border-gray-600 bg-gray-700 text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 @error('animal_id') border-red-500 @enderror">
                  <option value="">Seleccionar Animal</option>
                  @foreach ($animales as $animal)
                    <option value="{{ $animal->id }}">{{ $animal->nombre }}</option>
                  @endforeach
              </select>
              @error('animal_id')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
              @enderror
            </div>

            <!-- Descripción -->
            <div class="mb-4">
              <label class="block text-gray-300 font-medium mb-2">Descripción</label>
              <textarea x-model="formData.descripcion" name="descripcion" rows="3" required
                class="block w-full rounded border-gray-600 bg-gray-700 text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 resize-none @error('descripcion') border-red-500 @enderror">
              </textarea>
              @error('descripcion')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
              @enderror
            </div>

            <!-- Grupo: Fecha y Responsable -->
            <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
              
              <!-- Fecha -->
              <div>
                <label class="block text-gray-300 font-medium mb-2">Fecha</label>
                <input 
                  type="date" 
                  x-model="formData.fecha" 
                  name="fecha" 
                  required
                  class="block w-full rounded border-gray-600 bg-gray-700 text-white shadow-sm 
                        focus:border-blue-500 focus:ring focus:ring-blue-200 
                        @error('fecha') border-red-500 @enderror"
                >
                @error('fecha')
                  <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
              </div>

              <!-- Responsable -->
              <div>
                <label class="block text-gray-300 font-medium mb-2">Responsable</label>
                <select 
                  name="responsable_id" 
                  x-model="formData.responsable_id" 
                  required
                  class="block w-full rounded border-gray-600 bg-gray-700 text-white shadow-sm 
                        focus:border-blue-500 focus:ring focus:ring-blue-200 
                        @error('responsable_id') border-red-500 @enderror"
                >
                  <option value="">Seleccionar Responsable</option>
                  @foreach($usuarios as $usuario)
                    <option value="{{ $usuario->id }}">{{ $usuario->nombre }}</option>
                  @endforeach
                </select>
                @error('responsable_id')
                  <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
              </div>

            </div>


            <!-- Botones -->
            <button type="submit" class="w-full bg-green-700 hover:bg-green-800 text-white font-semibold py-2 px-4 rounded shadow transition">
              Actualizar
            </button>
          </form>
            <button @click="abierto = false"
              class="mt-4 w-full bg-red-700 hover:bg-red-800 text-white font-semibold py-2 px-4 rounded shadow transition">
              Cancelar
            </button>
      </div>
    </div>

  </div>
</div>
