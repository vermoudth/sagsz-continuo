<!DOCTYPE html>
<html lang="es" data-bs-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/showFormU.js', 'resources/js/theme.js'])

  <title>SAGSZ</title>
</head>
<body>
    @include('components.alert')
    <!-- Toggle Dark/Light -->
    <div class="me-3 mt-2">
        <button id="darkModeToggle" class="btn btn-outline-secondary border-0">
        <span id="themeIcon">🌙</span>
        </button>
    </div>
  
  
  <main>
      <div class=" flex flex-col max-w items-center">
        <h1 class="mx-1 my-2">SAGSZ</h1>
        <h2 class="mx-1 my-2">Sistema de Administración de Gestión de Seguridad y Salud en el Trabajo</h2>
        <div class="columns-2 flex justify-evenly items-center">
            <!--Logo de SAGSZ-->
          <div class=" max-w-xl mx-auto">
            <img 
            src="{{ asset('img/SAGSZ_logo.png') }}" 
            alt="Logo SAGSZ" 
            class="w-lg aspect-[3/2] object-contain mx-auto rounded-xl" />
          </div>


          <!--Formulario de Inicio de Sesion-->
          <div class="col-6">
              <button id="formShow" class="bg-green-600 text-white font-bold py-2 px-4 rounded transition-colors duration-300 hover:bg-green-900" >Ingresar</button>
              
              
              <div id="formulario" style="display: none">
                <div class="container">
                  <h1>Inicio de Sesión</h1>
                    @if ($errors->any())
                        <div>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                
                    <form method="POST" action="{{ route('login') }}" class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md">
    @csrf

    <div class="mb-4">
        <label for="identificacion" class="block text-gray-700 font-medium mb-2">Identificación</label>
        <input id="identificacion" type="text" name="identificacion" value="{{ old('identificacion') }}"
               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 
                      @error('identificacion') border-red-500 @enderror" required autofocus>
        @error('identificacion')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <div class="mb-4">
        <label for="password" class="block text-gray-700 font-medium mb-2">Contraseña</label>
        <input id="password" type="password" name="password"
               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-400 
                      @error('password') border-red-500 @enderror" required>
        @error('password')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <div class="mb-4">
        <button type="submit" class="w-full bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-green-400">
            Ingresar
        </button>
    </div>
</form>
                  </div>
              </div>
          </div>
        </div>
      </div>
  </main>
</body>
</html>