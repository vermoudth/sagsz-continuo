@vite(['resources/js/app.js'])

<div class="w-full mt-2 flex flex-col items-center dark:bg-gray-900 dark:text-white transition-colors duration-300">
  <div class="w-full px-4 py-2 space-y-4 max-w-7xl">

    <!-- Botón + Modal para añadir traslado -->
    <div class="flex justify-end" x-data="{ showAdd: false }">

      <!-- Botón que abre el modal -->
      <button 
        @click="showAdd = true"
        class="bg-blue-600 text-white px-3 py-1.5 rounded-md shadow hover:bg-blue-700 transition duration-200 text-sm flex items-center gap-2">
        <i class="fas fa-plus text-sm"></i>
        Añadir traslado
      </button>

      <!-- Modal -->
      <div 
        x-show="showAdd" 
        class="fixed inset-0 bg-gray-900 bg-opacity-80 flex items-center justify-center z-50 p-4"
        x-cloak 
        @click.outside="showAdd = false"
      >
        <div class="bg-gray-800 rounded-lg shadow-lg p-6 w-full max-w-md border border-gray-700" @click.stop>

          <h2 class="text-lg font-semibold mb-4 text-white">Añadir Traslado</h2>

          <form action="{{ route('traslados.store') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Animal -->
            <div>
              <label for="animal_id" class="block text-gray-300 font-medium mb-2">Animal</label>
              <select 
                name="animal_id" required
                class="block w-full rounded border-gray-600 bg-gray-700 text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
              >
                <option value="">Seleccione un animal</option>
                @foreach($animales as $animal)
                  <option value="{{ $animal->id }}">
                    {{ $animal->nombre ?? 'Sin nombre' }} - {{ $animal->categoria->nombre ?? 'Sin categoría' }}
                  </option>
                @endforeach
              </select>
            </div>

            <!-- Origen -->
            <div>
              <label class="block text-gray-300 font-medium mb-2">Origen</label>
              <textarea 
                name="origen" rows="3" required
                class="block w-full rounded border-gray-600 bg-gray-700 text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
              ></textarea>
            </div>

            <!-- Destino -->
            <div>
              <label class="block text-gray-300 font-medium mb-2">Destino</label>
              <textarea 
                name="destino" rows="3" required
                class="block w-full rounded border-gray-600 bg-gray-700 text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
              ></textarea>
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

    <!-- Estadísticas -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 text-center">
      @php
        $stats = [
          ['icon' => 'fas fa-truck text-blue-500', 'label' => 'Total traslados', 'value' => $traslados->total()],
          ['icon' => 'fas fa-paw text-yellow-500', 'label' => 'Animales distintos', 'value' => $traslados->pluck('animal_id')->unique()->count()],
          ['icon' => 'fas fa-map-marker-alt text-purple-500', 'label' => 'Destinos distintos', 'value' => $traslados->pluck('destino')->unique()->count()],
          ['icon' => 'fas fa-university text-red-500', 'label' => 'Orígenes distintos', 'value' => $traslados->pluck('origen')->unique()->count()],
          ['icon' => 'fas fa-user-md text-green-500', 'label' => 'Responsables distintos', 'value' => $traslados->pluck('responsable_id')->unique()->count()],
        ];
      @endphp

      @foreach($stats as $stat)
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-3">
          <i class="{{ $stat['icon'] }} text-base"></i>
          <span class="text-xl font-semibold block">{{ $stat['value'] }}</span>
          <p class="text-xs font-semibold text-gray-600 dark:text-gray-300">{{ $stat['label'] }}</p>
        </div>
      @endforeach
    </div>

    <!-- Listado de traslados -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-3">
      @forelse ($traslados as $traslado)
        <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-3 transition-colors duration-300">
          <h2 class="text-base font-bold mb-2 dark:text-white">
            {{ $traslado->animal->nombre ?? 'Sin información del animal' }}
          </h2>

          <div class="grid grid-cols-2 gap-3 text-center text-gray-700 dark:text-gray-300 text-sm">
            <div>
              <i class="fas fa-university text-blue-500 text-base"></i>
              <p class="font-medium truncate">{{ $traslado->origen }}</p>
              <p class="text-xs">Origen</p>
            </div>
            <div>
              <i class="fas fa-map-marker-alt text-purple-500 text-base"></i>
              <p class="font-medium truncate">{{ $traslado->destino }}</p>
              <p class="text-xs">Destino</p>
            </div>
            <div>
              <i class="fas fa-calendar-day text-red-500 text-base"></i>
              <p class="font-medium">{{ \Carbon\Carbon::parse($traslado->fecha)->format('d/m/Y') }}</p>
              <p class="text-xs">Fecha</p>
            </div>
            <div>
              <i class="fas fa-user-md text-green-500 text-base"></i>
              <p class="font-medium truncate">{{ $traslado->responsable->nombre ?? 'Desconocido' }}</p>
              <p class="text-xs">Responsable</p>
            </div>
          </div>
        </div>
      @empty
        <div class="col-span-4 text-center py-10">
          <p class="text-gray-500 text-sm">No hay traslados registrados por el momento.</p>
        </div>
      @endforelse
    </div>

    <!-- Paginación -->
    @if($traslados instanceof \Illuminate\Pagination\LengthAwarePaginator && $traslados->hasPages())
      <div class="flex justify-center mt-4">
        {{ $traslados->links() }}
      </div>
    @endif

  </div>
</div>
