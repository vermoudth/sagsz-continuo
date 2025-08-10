@vite(['resources/js/app.js'])

<div class="w-full mt-2 flex flex-col items-center dark:bg-gray-900 dark:text-white transition-colors duration-300">
  <div class="w-full px-4 py-2 space-y-4 max-w-7xl">

    <!-- Botón añadir traslado -->
    <div x-data="{ showAdd: false }" class="flex justify-end">
      <button @click="showAdd = true"
        class="bg-blue-600 text-white px-3 py-1.5 rounded-md shadow hover:bg-blue-700 transition duration-200 text-sm flex items-center gap-2">
        <i class="fas fa-plus text-sm"></i>
        Añadir traslado
      </button>
      <!--Logica del modal-->
      <div x-show="showAdd" class="fixed inset-0 bg-gray-900 bg-opacity-80 flex items-center justify-center z-50"
        x-cloak @click.outside="showAdd = false">
        <div class="bg-gray-800 rounded-lg shadow-lg p-6 w-full max-w-md border border-gray-700">
          <h2 class="text-lg font-semibold mb-4 text-white">Añadir Traslado</h2>
          <form action="{{ route('traslados.store') }}" method="POST">
            @csrf
            <!-- Campo Animal -->
            <div class="mb-4">
              <label for="descripcion" class="block text-gray-300 font-medium mb-2">Id Animal</label>
              <input type="number"
                class="block w-full rounded border-gray-600 bg-gray-700 text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                name="animal_id" rows="1" required></input>
            </div>
            <!-- Campo Animal -->
            <div class="mb-4">
              <label for="descripcion" class="block text-gray-300 font-medium mb-2">Origen</label>
              <textarea
                class="block w-full rounded border-gray-600 bg-gray-700 text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                name="origen" rows="3" required></textarea>
            </div>
            <!-- Campo Descripción -->
            <div class="mb-4">
              <label for="descripcion" class="block text-gray-300 font-medium mb-2">Destino</label>
              <textarea
                class="block w-full rounded border-gray-600 bg-gray-700 text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                name="destino" rows="3" required></textarea>
            </div>
            <!-- Campo Fecha -->
            <div class="mb-4">
              <label for="fecha" class="block text-gray-300 font-medium mb-2">Fecha</label>
              <input type="date"
                class="block w-full rounded border-gray-600 bg-gray-700 text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                name="fecha" required>
            </div>
            <!-- Campo Responsable -->
            <div class="mb-4">
              <label for="descripcion" class="block text-gray-300 font-medium mb-2">Id Responsable</label>
              <input type="number"
                class="block w-full rounded border-gray-600 bg-gray-700 text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                name="responsable_id" rows="1" required></input>
            </div>
            <button type="submit"
              class="w-full bg-blue-700 hover:bg-blue-800 text-white font-semibold py-2 px-4 rounded shadow transition">Guardar</button>
          </form>
          <!-- Botón para cerrar el modal -->
          <button @click="showAdd = false"
            class="mt-4 w-full bg-red-700 hover:bg-red-800 text-white font-semibold py-2 px-4 rounded shadow transition">
            Cerrar
          </button>
        </div>
      </div>
    </div>

    <!-- Estadísticas generales
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 text-center">
      @php
        $stats = [
          ['icon' => '', 'label' => 'Total traslados', 'value' => '00'],
          ['icon' => 'fas fa-university text-blue-500', 'label' => 'Institución', 'value' => '00'],
          ['icon' => 'fas fa-map-marker-alt text-red-500', 'label' => 'Lugar', 'value' => '03'],
          ['icon' => 'fas fa-paw text-yellow-500', 'label' => 'Especie', 'value' => '00'],
          ['icon' => 'fas fa-user-md text-green-500', 'label' => 'Veterinario', 'value' => '00'],
        ];
      @endphp

      @foreach($stats as $stat)
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-3">
          @if($stat['icon'])
            <i class="{{ $stat['icon'] }} text-base"></i>
          @endif
          <span class="text-xl font-semibold block">{{ $stat['value'] }}</span>
          <p class="text-xs font-semibold text-gray-600 dark:text-gray-300">{{ $stat['label'] }}</p>
        </div>
      @endforeach
    </div>-->

    <!-- Cards de traslados -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-3">
      @forelse ($traslados as $traslado)
      <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-3 transition-colors duration-300">
      @if($traslado->animal)
      <h2 class="text-base font-bold mb-2 dark:text-white">
      Animal ID: {{ $traslado->animal->id }}
      </h2>
    @else
      <h2 class="text-base font-bold mb-2 text-red-500">
      Sin información del animal
      </h2>
    @endif


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
        <p class="font-medium truncate">Resp. ID: {{ $traslado->responsable_id }}</p>
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

    <!-- Espacio para futura paginación -->
    <div class="flex justify-center mt-4 pagination">
      {{ $traslados->links() }} <!-- Esto genera la paginación, ahora centrada con Tailwind -->
    </div>
  </div>
  <!--Traslado en proceso-->
  <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-3">

    <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-3 transition-colors duration-300">

      <h2 class="text-base font-bold mb-2 dark:text-white">
        Animal ID: 3
      </h2>

      <h2 class="text-base font-bold mb-2 text-red-500">
        Sin información del animal
      </h2>

      <div class="grid grid-cols-2 gap-3 text-center text-gray-700 dark:text-gray-300 text-sm">
        <div>
          <i class="fas fa-university text-blue-500 text-base"></i>
          <p class="font-medium truncate">Durango</p>
          <p class="text-xs">Origen</p>
        </div>
        <div>
          <i class="fas fa-map-marker-alt text-purple-500 text-base"></i>
          <p class="font-medium truncate">Pediente... En proceso</p>
          <p class="text-xs">Destino</p>
        </div>
        <div>
          <i class="fas fa-calendar-day text-red-500 text-base"></i>
          <p class="font-medium">19/12/2025</p>
          <p class="text-xs">Fecha</p>
        </div>
        <div>
          <i class="fas fa-user-md text-green-500 text-base"></i>
          <p class="font-medium truncate">2</p>
          <p class="text-xs">Responsable</p>
        </div>
      </div>
    </div>
  </div>

</div>