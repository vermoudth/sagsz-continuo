<!DOCTYPE html>
<html lang="es" data-bs-theme="light">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <title>SAGSZ</title>
</head>
<body class="bg-white text-gray-900 dark:bg-gray-900 dark:text-white">
  @include('components.alert')
  <main>
    <div class="flex flex-col max-w-5xl mx-auto px-4 py-8 items-center">
      <!-- Título de la página -->
      <div class="text-center mb-6">
        <h1 class="text-xl sm:text-2xl font-semibold">SAGSZ</h1>
        <h2 class="text-sm sm:text-base mt-1">Sistema de Administración de Gestión de Seguridad y Salud en el Trabajo</h2>
      </div>

      <div class="flex flex-col md:flex-row justify-evenly items-center w-full gap-10">
        <!-- Logo -->
        <div class="max-w-md w-full mx-auto">
          <img
            src="{{ asset('img/SAGSZ_logo.webp') }}"
            alt="Logo SAGSZ"
            class="w-full aspect-[3/2] object-contain rounded-xl dark:brightness-90"
          />
        </div>

        <!-- Formulario de Inicio de Sesión -->
        <div x-data="{ mostrarFormulario: false }" class="w-full max-w-sm text-center">
          <!-- Botón para mostrar el formulario -->
          <button
            x-show="!mostrarFormulario"
            @click="mostrarFormulario = true"
            class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500"
          >
            Ingresar
          </button>

          <!-- Formulario que aparece -->
          <form
            x-show="mostrarFormulario"
            x-transition
            class="mt-6 space-y-4 bg-white dark:bg-gray-800 p-6 rounded shadow w-full"
            method="POST"
            action="{{ route('login') }}"
          >
            @csrf
            <input
              type="text"
              name="identificacion"
              placeholder="Identificación"
              required
              class="w-full px-4 py-2 border border-gray-300 rounded dark:bg-gray-700 dark:text-white dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-400"
            />

            <input
              type="password"
              name="password"
              placeholder="Contraseña"
              required
              class="w-full px-4 py-2 border border-gray-300 rounded dark:bg-gray-700 dark:text-white dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-400"
            />

            <div class="flex justify-between items-center">
              <button
                type="submit"
                class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
              >
                Entrar
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </main>
</body>
</html>
