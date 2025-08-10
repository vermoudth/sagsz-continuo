@vite(['resources/js/app.js'])

<div class="w-full mt-2 flex flex-col items-center dark:bg-gray-900 dark:text-white transition-colors duration-300">
  <div class="w-full px-4 py-2 space-y-4 max-w-7xl">

    <!-- Botón añadir nutrición -->
    <div class="flex justify-end">
      <button 
        class="bg-green-600 text-white px-3 py-1.5 rounded-md shadow hover:bg-green-700 transition duration-200 text-sm flex items-center gap-2"
      >
        <i class="fas fa-plus text-sm"></i>
        Añadir Formulario de Nutrición
      </button>
    </div>

    <!-- Cards de nutrición -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-3">
      @forelse ($nutriciones as $nutricion)
        <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-4 transition-colors duration-300 hover:shadow-lg">
          <!-- Encabezado con animal -->
          @if($nutricion->animal)
              <h2 class="text-lg font-bold mb-2 dark:text-white flex items-center gap-2">
                  <i class="fas fa-paw text-green-500"></i>
                  {{ $nutricion->animal->nombre ?? 'Animal ID: '.$nutricion->animal->id }}
              </h2>
          @else
              <h2 class="text-lg font-bold mb-2 text-red-500 flex items-center gap-2">
                  <i class="fas fa-exclamation-triangle"></i>
                  Sin información del animal
              </h2>
          @endif

          <!-- Datos de nutrición -->
          <div class="grid grid-cols-2 gap-4 text-center text-gray-700 dark:text-gray-300 text-sm">
            <div>
              <i class="fas fa-seedling text-green-500 text-lg"></i>
              <p class="font-medium truncate">{{ $nutricion->dieta }}</p>
              <p class="text-xs">Dieta</p>
            </div>
            <div>
              <i class="fas fa-weight-hanging text-yellow-500 text-lg"></i>
              <p class="font-medium truncate">{{ $nutricion->cantidad }} kg</p>
              <p class="text-xs">Cantidad</p>
            </div>
            <div>
              <i class="fas fa-calendar-day text-blue-500 text-lg"></i>
              <p class="font-medium">{{ \Carbon\Carbon::parse($nutricion->fecha)->format('d/m/Y') }}</p>
              <p class="text-xs">Fecha</p>
            </div>
            <div>
              <i class="fas fa-user text-purple-500 text-lg"></i>
              <p class="font-medium truncate">Resp. ID: {{ $nutricion->responsable_id }}</p>
              <p class="text-xs">Responsable</p>
            </div>
          </div>
        </div>
      @empty
        <div class="col-span-4 text-center py-10">
          <i class="fas fa-utensils text-3xl text-gray-400 mb-2"></i>
          <p class="text-gray-500 text-sm">No hay registros de nutrición por el momento.</p>
        </div>
      @endforelse
    </div>

    <!-- Paginación -->
    @if($nutriciones instanceof \Illuminate\Pagination\LengthAwarePaginator && $nutriciones->hasPages())
      <div class="flex justify-center mt-4">
        {{ $nutriciones->links() }}
      </div>
    @endif

  </div>
</div>
