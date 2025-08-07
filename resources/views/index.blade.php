<!DOCTYPE html>
<html lang="es" data-bs-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <title>SAGSZ</title>
</head>
<body class="bg-white text-gray-900 dark:bg-gray-900 dark:text-white">
  @include('components.alert')
  <main>
      <div class=" flex flex-col max-w items-center">
        <!--Titulo de la pagina-->
        <div class="text-center mb-4">
            <h1 class="text-lg">SAGSZ</h1>
            <h1 class="text-lg">Sistema de Administración de Gestión de Seguridad y Salud en el Trabajo</h1>
        </div>

        <div class="columns-2 flex justify-evenly items-center">
            <!--Logo de SAGSZ-->
          <div class=" max-w-xl mx-auto">
            <img 
            src="{{ asset('img/SAGSZ_logo.png') }}" 
            alt="Logo SAGSZ" 
            class="w-lg aspect-[3/2] object-contain mx-auto rounded-xl" />
          </div>


          <!--Formulario de Inicio de Sesion-->
          <div x-data="{ mostrarFormulario: false }" class="text-center mt-10">
            
            <!-- Botón para mostrar el formulario -->
            <button 
              x-show="!mostrarFormulario"
              @click="mostrarFormulario = true"
              class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700"
            >
              Ingresar
            </button>

            <!-- Formulario que aparece -->
            <form 
              x-show="mostrarFormulario" 
              x-transition 
              class="mt-6 space-y-4 max-w-sm mx-auto bg-white p-6 rounded shadow dark:bg-gray-800"
              method="POST" 
              action="{{ route('login') }}"
            >
              @csrf
              <input 
                type="text" 
                name="identificacion" 
                placeholder="Identificación"
                required 
                class="w-full px-4 py-2 border rounded dark:bg-gray-700 dark:text-white"
              >

              <input 
                type="password" 
                name="password" 
                placeholder="Contraseña"
                required 
                class="w-full px-4 py-2 border rounded dark:bg-gray-700 dark:text-white"
              >

              <div class="flex justify-between items-center">
                <button 
                  type="submit" 
                  class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
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