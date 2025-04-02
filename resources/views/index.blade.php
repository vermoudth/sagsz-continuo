<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/showFormU.js'])

  <title>SAGSZ</title>
</head>
<body>
  <main>
      <div class="container text-center">
        <h1>SAGSZ</h1>
        <div class="row justify-content-center align-items-center gy-5">
          <div class="col-6">
              <img src="{{ asset('img/logo.jpeg') }}" class="img-responsive rounded" style="width: 80%;" alt="...">
          </div>

          <div class="col-6">
              <button id="formShow" class="btn btn-success">Ingresar</button>
              
              <!--Formulario de Inicio de Sesion-->
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
                
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                
                        <div class="mb-3">
                            <label for="identificacion" class="form-label">Identificación</label>
                            <input id="identificacion" type="text" class="form-control @error('identificacion') is-invalid @enderror" 
                                   name="identificacion" value="{{ old('identificacion') }}" required autofocus>
                            @error('identificacion')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                                   name="password" required>
                            @error('password')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary w-100">Ingresar</button>
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