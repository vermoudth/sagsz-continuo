<!DOCTYPE html>
<html lang="es" class="scroll-smooth" >
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    @vite(['resources/css/app.css', 'resources/js/app.js' , 'resources/js/appLayoutPanel.js'])
    <title>Panel de Control</title>
</head>

<body class="bg-white text-gray-900 dark:bg-gray-900 dark:text-white">
  {{-- Muestra las alertas de sesión --}}
  @if(session('success') || session('error') || session('debug'))
    @include('components.alert')
  @endif

  <!-- Contenedor principal: flex columna en móvil, fila en md+ -->
  <div class="flex flex-col md:flex-row w-full h-screen">
    <!-- Barra de navegación -->
    <nav class="flex flex-row md:flex-col p-4 md:w-[18%] w-full bg-gray-100 dark:bg-gray-800 overflow-auto">
      <a href="/homePanel" class="flex items-center justify-center md:justify-start gap-2 mb-4 text-gray-800 dark:text-white">
        <img src="{{ asset('img/sagsz_logo.webp') }}" class="rounded w-12 md:w-1/3" alt="Logo" />
        <span class="text-xl font-bold hidden md:inline">SAGSZ</span>
      </a>
      <hr class="my-2 border-gray-300 dark:border-gray-600" />

      <ul class="flex md:flex-col flex-row md:gap-2 gap-4 overflow-x-auto whitespace-nowrap">
        <li>
          <a href="/homePanel" class="flex items-center justify-center md:justify-start gap-2 hover:text-blue-600 cursor-pointer text-gray-800 dark:text-white" title="Inicio">
            <i class="fas fa-home text-lg"></i>
            <span class="hidden md:inline font-semibold">Inicio</span>
          </a>
        </li>
        <li>
          <a href="/traslados" onclick="event.preventDefault(); cargarSeccion('/traslados')" class="flex items-center justify-center md:justify-start gap-2 hover:text-blue-600 cursor-pointer text-gray-800 dark:text-white" title="Traslados">
            <i class="fas fa-truck text-lg"></i>
            <span class="hidden md:inline font-semibold">Traslados</span>
          </a>
        </li>
        <li>
          <a href="/crianza" onclick="event.preventDefault(); cargarSeccion('/crianza')" class="sidebar-link flex items-center justify-center md:justify-start gap-2 hover:text-blue-600 cursor-pointer text-gray-800 dark:text-white" title="Crianza">
            <i class="fas fa-paw text-lg"></i>
            <span class="hidden md:inline font-semibold">Crianza</span>
          </a>
        </li>
        <li>
          <a href="/laboratorio" onclick="event.preventDefault(); cargarSeccion('/laboratorio')" class="flex items-center justify-center md:justify-start gap-2 hover:text-blue-600 cursor-pointer text-gray-800 dark:text-white" title="Laboratorio">
            <i class="fa-solid fa-flask text-lg"></i>
            <span class="hidden md:inline font-semibold">Laboratorio</span>
          </a>
        </li>
        <li>
          <a id="/nutricion" onclick="event.preventDefault(); cargarSeccion('/nutricion')" class="flex items-center justify-center md:justify-start gap-2 hover:text-blue-600 cursor-pointer text-gray-800 dark:text-white" title="Nutrición">
            <i class="fa-solid fa-heart text-lg"></i>
            <span class="hidden md:inline font-semibold">Nutrición</span>
          </a>
        </li>
        <li>
          <a href="/monitoreo-ambiental" onclick="event.preventDefault(); cargarSeccion('/monitoreo-ambiental')" class="flex items-center gap-2 hover:text-blue-600 cursor-pointer text-gray-800 dark:text-white" title="Monitoreo Ambiental">
            <i class="fas fa-paw text-lg"></i>
            <span class="hidden md:inline font-semibold">Monitoreo Ambiental</span>
          </a>
        </li>
      </ul>

      <hr class="my-2 border-gray-300 dark:border-gray-600" />

      <!-- Botón de ajustes y cerrar sesión -->
      <div class="relative mt-auto">
        <button
          class="flex items-center gap-2 hover:text-blue-600 cursor-pointer text-gray-800 dark:text-white"
          id="dropdownUser2"
          aria-haspopup="true"
          aria-expanded="false"
        >
          <i class="fa-solid fa-gear"></i> <strong>Ajustes</strong>
        </button>
        <ul
          class="absolute hidden mt-2 bg-white dark:bg-gray-800 text-sm rounded shadow-md w-40 right-0 z-10"
          id="settingsMenu"
          role="menu"
          aria-label="Menú de ajustes"
        >
          <li>
            <a href="#" class="block px-4 py-2 hover:bg-gray-200 dark:hover:bg-gray-700" role="menuitem">Settings</a>
          </li>
          <li><hr class="border-gray-300 dark:border-gray-600" /></li>
          <li>
            <form action="{{ route('logout') }}" method="POST" class="block px-4 py-2">
              @csrf
              <button type="submit" class="w-full text-left text-red-600 hover:text-red-800">Cerrar sesión</button>
            </form>
          </li>
        </ul>
      </div>
    </nav>

    <!-- Contenido Principal -->
    <div class="flex-1 px-4 py-6 overflow-auto">
      <main class="max-w-full">
        <!-- Cabecera de breadcrumb y búsqueda -->
        <header class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4 gap-3 md:gap-0">
          <nav aria-label="breadcrumb" class="w-full md:w-3/4">
            <ol id="breadcrumb-ol" class="flex space-x-2 text-sm text-gray-700 dark:text-gray-200 overflow-x-auto whitespace-nowrap">
              <li>
                <a href="/homePanel" class="hover:underline">Panel de Inicio</a>
              </li>
            </ol>
          </nav>

          <!-- Comentado el buscador, pero con responsividad en caso que quieras activarlo -->
          <!--
          <form class="flex w-full md:w-1/4">
            <input
              class="w-full px-3 py-1 border border-gray-300 rounded-l dark:bg-gray-800 dark:text-white dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-green-500"
              type="search"
              placeholder="Buscar"
              aria-label="Buscar"
            />
            <button
              class="px-4 py-1 bg-green-600 text-white rounded-r hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500"
              type="submit"
            >
              Buscar
            </button>
          </form>
          -->
        </header>

        <hr class="border-gray-300 dark:border-gray-600" />

        <!-- Contenido de Inicio -->
        <div id="homePanel" class="text-center" style="{{ isset($modulo) ? 'display:none;' : '' }}">
          <h1 class="text-3xl font-bold">Panel de Control</h1>
          <p class="mt-2">Bienvenido al panel de control de la aplicación.</p>
          <img src="{{ asset('img/sagsz_logo.webp') }}" class="mx-auto mt-4 w-1/3 rounded" alt="Logo" />
        </div>

        <!-- Contenedor padre responsivo para contenido dinámico -->
        <div
          id="contenido-dinamico-wrapper"
          class="w-full max-w-7xl px-4 py-4 mx-auto
                dark:bg-gray-900 dark:text-white
                transition-colors duration-300
                overflow-x-auto"
        >
          <div id="contenido-dinamico" class="min-w-full">
            @if(isset($modulo))
              @include('interfaces.' . $modulo . 'Panel')
            @endif
          </div>
        </div>

      </main>
    </div>
  </div>

  <script>
    // Toggle simple del menú de ajustes
    document.getElementById('dropdownUser2')?.addEventListener('click', () => {
      const menu = document.getElementById('settingsMenu');
      menu.classList.toggle('hidden');
      // Actualizar atributo aria-expanded para accesibilidad
      const expanded = menu.classList.contains('hidden') ? 'false' : 'true';
      document.getElementById('dropdownUser2').setAttribute('aria-expanded', expanded);
    });
  </script>
</body>
</html>
