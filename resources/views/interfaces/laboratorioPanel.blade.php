@vite(['resources/js/app.js'])

<div class="w-full mt-2 flex flex-col items-center dark:bg-gray-900 dark:text-white transition-colors duration-300">
  <div class="w-full px-4 py-2 space-y-4 max-w-7xl">

    <!-- Botón + Modal para añadir laboratorio -->
    <div class="flex justify-end" x-data="{ showAdd: false }">
      
      <!-- Botón que abre el modal -->
      <button 
        @click="showAdd = true"
        class="bg-blue-600 text-white px-3 py-1.5 rounded-md shadow hover:bg-blue-700 transition duration-200 text-sm flex items-center gap-2">
        <i class="fas fa-plus text-sm"></i>
        Añadir Laboratorio
      </button>

      <!-- Modal -->
      <div 
        x-show="showAdd" 
        class="fixed inset-0 bg-gray-900 bg-opacity-80 flex items-center justify-center z-50"
        x-cloak
        @click.outside="showAdd = false">
        <div class="bg-gray-800 rounded-lg shadow-lg p-6 w-full max-w-md border border-gray-700">
          
          <h2 class="text-lg font-semibold mb-4 text-white">Añadir Registro de Laboratorio</h2>
          
          <form action="{{ route('laboratorio.store') }}" method="POST">
            @csrf
            
            <!-- Campo: Animal -->
            <div class="mb-4">
              <label for="animal_id" class="block text-gray-300 font-medium mb-2">Animal</label>
              <select 
                class="block w-full rounded border-gray-600 bg-gray-700 text-white shadow-sm focus:border-green-500 focus:ring focus:ring-green-200"
                name="animal_id" required>
                <option value="">Seleccionar Animal</option>
                @foreach($animales as $animal)
                  <option value="{{ $animal->id }}">
                    {{ $animal->nombre }}
                  </option>
                @endforeach
              </select>
            </div>

            <!-- Campo: Diagnóstico -->
            <div class="mb-4">
              <label for="diagnostico" class="block text-gray-300 font-medium mb-2">Diagnóstico</label>
              <textarea
                name="diagnostico"
                rows="3"
                class="block w-full rounded border-gray-600 bg-gray-700 text-white shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 resize-none"
                required
              ></textarea>
            </div>

            <!-- Campo: Tratamiento -->
            <div class="mb-4">
              <label for="tratamiento" class="block text-gray-300 font-medium mb-2">Tratamiento</label>
              <textarea
                name="tratamiento"
                rows="3"
                class="block w-full rounded border-gray-600 bg-gray-700 text-white shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 resize-none"
                required
              ></textarea>
            </div>

            <!-- Grupo Fecha y Responsable -->
            <div class="flex flex-col md:flex-row gap-4">
              <!-- Fecha -->
              <div class="flex-1">
                <label class="block text-gray-300 font-medium mb-2">Fecha</label>
                <input 
                  type="date" name="fecha" required
                  class="block w-full rounded border-gray-600 bg-gray-700 text-white shadow-sm focus:border-green-500 focus:ring focus:ring-green-200"
                >
              </div>

              <!-- Responsable -->
              <div class="flex-1">
                <label class="block text-gray-300 font-medium mb-2">Responsable</label>
                <select 
                  name="responsable_id" required
                  class="block w-full rounded border-gray-600 bg-gray-700 text-white shadow-sm focus:border-green-500 focus:ring focus:ring-green-200"
                >
                  <option value="">Seleccione responsable</option>
                  @foreach($usuarios as $usuario)
                    <option value="{{ $usuario->id }}"> 
                      {{ $usuario->nombre ?? 'Usuario sin nombre' }}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>

            <!-- Botones en línea -->
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

    <!-- Cards de laboratorio -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-3" id="contenedor-paginacion">
      @forelse ($laboratorios as $lab)
        <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-4 transition-colors duration-300 hover:shadow-lg flex flex-col justify-between">
          <!-- Encabezado con animal -->
          @if($lab->animal)
            <h2 class="text-lg font-bold mb-2 dark:text-white flex items-center gap-2">
              <i class="fas fa-paw text-green-500"></i>
              {{ $lab->animal->nombre ?? 'Animal ID: '.$lab->animal->id }}
            </h2>
          @else
            <h2 class="text-lg font-bold mb-2 text-red-500 flex items-center gap-2">
              <i class="fas fa-exclamation-triangle"></i>
              Sin información del animal
            </h2>
          @endif

          <!-- Datos de laboratorio -->
          <div class="grid grid-cols-2 gap-4 text-center text-gray-700 dark:text-gray-300 text-sm">
            <div>
              <i class="fas fa-notes-medical text-red-500 text-lg"></i>
              <p class="font-medium truncate">{{ Str::limit($lab->diagnostico, 40) }}</p>
              <p class="text-xs">Diagnóstico</p>
            </div>
            <div>
              <i class="fas fa-pills text-yellow-500 text-lg"></i>
              <p class="font-medium truncate">{{ Str::limit($lab->tratamiento, 40) }}</p>
              <p class="text-xs">Tratamiento</p>
            </div>
            <div>
              <i class="fas fa-calendar-day text-blue-500 text-lg"></i>
              <p class="font-medium">{{ \Carbon\Carbon::parse($lab->fecha)->format('d/m/Y') }}</p>
              <p class="text-xs">Fecha</p>
            </div>
            <div>
              <i class="fas fa-user-md text-purple-500 text-lg"></i>
              <p class="font-medium truncate">Resp. N: {{ $lab->responsable->nombre ?? 'Desconocido' }}</p>
              <p class="text-xs">Responsable</p>
            </div>
          </div>

          <!-- Botones de acciones -->
          <div class="flex justify-end gap-2 mt-4">
            <button 
              @click="$dispatch('open-edit-laboratorio', { 
                id: {{ $lab->id }}, 
                animal_id: '{{ $lab->animal_id }}',
                diagnostico: '{{ addslashes($lab->diagnostico) }}',
                tratamiento: '{{ addslashes($lab->tratamiento) }}',
                fecha: '{{ $lab->fecha }}',
                responsable_id: '{{ $lab->responsable_id }}'
              })"
              class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded text-sm flex items-center gap-1"
              title="Editar"
            >
              <i class="fas fa-edit"></i> Editar
            </button>
            <button 
              @click="$dispatch('open-delete-laboratorio', { id: {{ $lab->id }} })"
              class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-sm flex items-center gap-1"
              title="Eliminar"
            >
              <i class="fas fa-trash-alt"></i> Eliminar
            </button>
          </div>
        </div>
      @empty
        <div class="col-span-4 text-center py-10">
          <i class="fas fa-vials text-3xl text-gray-400 mb-2"></i>
          <p class="text-gray-500 text-sm">No hay registros de laboratorio por el momento.</p>
        </div>
      @endforelse
    </div>

    <!-- Paginación -->
    @if($laboratorios instanceof \Illuminate\Pagination\LengthAwarePaginator && $laboratorios->hasPages())
      <div class="flex justify-center mt-4 pagination">
        {{ $laboratorios->links() }}
      </div>
    @endif

    <!-- Modal para eliminar laboratorio -->
    <div 
      x-data="{ abierto: false, id: null }"
      @open-delete-laboratorio.window="abierto = true; id = $event.detail.id"
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
            class="px-4 py-2 bg-gray-300 hover:bg-gray-400 rounded text-black text-sm">
            Cancelar
          </button>
          <form :action="`/laboratorio/${id}`" method="POST" class="inline">
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

    <!-- Modal para Editar Laboratorio -->
    <div
      @open-edit-laboratorio.window="abierto = true; formData = { ...$event.detail }"
      x-data="{
        abierto: false, 
        formData: { id: null, animal_id: '', diagnostico: '', tratamiento: '', fecha: '', responsable_id: '' }
      }"
      x-show="abierto"
      x-cloak
      class="fixed inset-0 bg-gray-900 bg-opacity-80 flex items-center justify-center z-50"
      @click.outside="abierto = false"  
    >
      <div class="bg-gray-800 rounded-lg shadow-lg p-6 w-full max-w-md border border-gray-700">
        <h2 class="text-lg font-semibold mb-4 text-white">Editar Registro de Laboratorio</h2>
          <form :action="`/laboratorio/${formData.id}`" method="POST" id="editForm">
            @csrf
            @method('PUT')

            <!-- Animal -->
            <div class="mb-4">
              <label class="block text-gray-300 font-medium mb-2">Animal</label>
              <select name="animal_id" x-model="formData.animal_id" required
                  class="block w-full rounded border-gray-600 bg-gray-700 text-white shadow-sm focus:border-green-500 focus:ring focus:ring-green-200">
                  <option value="">Seleccionar Animal</option>
                  @foreach ($animales as $animal)
                    <option value="{{ $animal->id }}">{{ $animal->nombre }}</option>
                  @endforeach
              </select>
            </div>

            <!-- Diagnóstico -->
            <div class="mb-4">
              <label class="block text-gray-300 font-medium mb-2">Diagnóstico</label>
              <textarea x-model="formData.diagnostico" name="diagnostico" rows="3" required
                class="block w-full rounded border-gray-600 bg-gray-700 text-white shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 resize-none">
              </textarea>
            </div>

            <!-- Tratamiento -->
            <div class="mb-4">
              <label class="block text-gray-300 font-medium mb-2">Tratamiento</label>
              <textarea x-model="formData.tratamiento" name="tratamiento" rows="3" required
                class="block w-full rounded border-gray-600 bg-gray-700 text-white shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 resize-none">
              </textarea>
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
