<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js' , 'resources/js/appLayoutPanel.js'])
    <title>Panel de Control</title>
</head>

<body class="bg-white text-gray-900 dark:bg-gray-900 dark:text-white">
  {{-- Muestra las alertas de sesión --}}
  @if(session('success') || session('error') || session('debug'))
    @include('components.alert')
  @endif

  <!--Contenedor principal-->
  <div class="flex w-full h-screen">
    <!--Barra de navegación-->
    <nav class="flex flex-col p-4 w-[18%] bg-gray-100 dark:bg-gray-800">
      <a href="/homePanel" class="flex items-center justify-evenly my-3 text-gray-800 dark:text-white">
        <img src="{{ asset('img/SAGSZ_logo.png') }}" class="rounded w-1/3" alt="Logo">
        <span class="text-xl font-bold">SAGSZ</span>
      </a>
      <hr class="my-2 border-gray-300 dark:border-gray-600">

      <ul class="flex flex-col gap-2">
        <li>
          <a 
          href="/homePanel" 
          class="flex items-center gap-2 hover:text-blue-600 cursor-pointer">
            <i class="fas fa-home"></i> <strong>Inicio</strong>
          </a>
        </li>
        <li>
          <a disable 
          href="#" 
          class="pointer-events-none opacity-50 flex items-center gap-2 cursor-not-allowed" 
          class="sidebar-link flex items-center gap-2 hover:text-blue-600 cursor-pointer"  
          data-ruta="{{ route('trasladosPanel') }}" 
          data-titulo="Traslados">
            <i class="fas fa-truck"></i> <strong>Traslados</strong>
          </a>
        </li>
        <li>
          <a href="/crianza" onclick="event.preventDefault(); cargarSeccion('/crianza')">
            <i class="fas fa-paw"></i> <strong>Crianza</strong>
          </a>
        </li>
        <li>
          <a disable id="lab-link" class="pointer-events-none opacity-50 flex items-center gap-2 cursor-not-allowed class="flex items-center gap-2 hover:text-blue-600 cursor-pointer">
            <i class="fa-solid fa-flask"></i> <strong>Laboratorio</strong>
          </a>
        </li>
        <li>
          <a id="nutri-link" class="pointer-events-none opacity-50 flex items-center gap-2 cursor-not-allowed class="flex items-center gap-2 hover:text-blue-600 cursor-pointer">
            <i class="fa-solid fa-heart"></i> <strong>Nutrición</strong>
          </a>
        </li>
      </ul>

      <hr class="my-2 border-gray-300 dark:border-gray-600">

      <!-- Botón de ajustes y cerrar sesión -->
      <div class="relative">
        <button class="flex items-center gap-2 text-gray-700 dark:text-white" id="dropdownUser2">
          <i class="fa-solid fa-gear"></i> <strong>Ajustes</strong>
        </button>
        <ul class="absolute hidden mt-2 bg-white dark:bg-gray-800 text-sm rounded shadow-md w-40" id="settingsMenu">
          <li><a href="#" class="block px-4 py-2 hover:bg-gray-200 dark:hover:bg-gray-700">Settings</a></li>
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

    <!--Contenido Principal-->
    <div class="flex-1 px-6 py-4">
      <main>
        <!--Cabecera de breadcums y busqueda-->
        <header class="flex justify-between items-center mb-4">
          <nav aria-label="breadcrumb" class="w-3/4">
            <ol id="breadcrumb-ol" class="flex space-x-2 text-sm text-gray-700 dark:text-gray-200">
              <li>
                <a href="/homePanel" class="hover:underline">Panel de Inicio</a>
              </li>
            </ol>
          </nav>
          <form class="flex w-1/4">
            <input class="w-full px-3 py-1 border border-gray-300 rounded-l dark:bg-gray-800 dark:text-white dark:border-gray-600" type="search" placeholder="Buscar">
            <button class="px-4 py-1 bg-green-600 text-white rounded-r hover:bg-green-700" type="submit">Buscar</button>
          </form>
          
        </header>

        <hr class="border-gray-300 dark:border-gray-600">

        <!-- Contenido de Inicio -->
        <div id="homePanel" class="text-center" style="{{ isset($modulo) ? 'display:none;' : '' }}">
            <h1 class="text-3xl font-bold">Panel de Control</h1>
            <p class="mt-2">Bienvenido al panel de control de la aplicación.</p>
            <img src="{{ asset('img/SAGSZ_logo.png') }}" class="mx-auto mt-4 w-1/3 rounded" alt="Logo">
        </div>

        <!-- Contenido Dinámico -->
        <div id="contenido-dinamico" class="flex flex-col items-center justify-center mt-4">
            @if(isset($modulo))
                @include('interfaces.' . $modulo . 'Panel') {{-- Esto incluirá crianzaPanel.blade.php --}}
            @endif
        </div>
        
      </main>
    </div>
  </div>

  <script>
    // Toggle simple del menú de ajustes
    document.getElementById('dropdownUser2')?.addEventListener('click', () => {
      const menu = document.getElementById('settingsMenu');
      menu.classList.toggle('hidden');
    });
  </script>
</body>
</html>
