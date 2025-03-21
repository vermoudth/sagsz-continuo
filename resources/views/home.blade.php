<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <title>Home</title>
</head>
<body>
  <main>
    <x-appHomeLayout>
      <div class="container text-center">
        <div class="row justify-content-center gy-5">
          
          <div class="col-12">
            <h1 class="text-center">Bienvenido</h1>
          </div>

          <div class="row align-items-center gy-5">
            <div class="col-6">
                <img src="{{ asset('img/logo.jpeg') }}" class="img-fluid rounded" style="width: 50%;" alt="...">
                <h3>SAGSZ ERP</h3>
            </div>

            <div class="col-6">
              <a href="{{ route('auth.login') }}">
                <button class="btn btn-success">Ingresar</button>
              </a>
              
              <a href="{{ route('auth.register') }}">
                <button class="btn btn-success">Registrarse</button>
              </a>
            </div>
          </div>

        </div>
      </div>
    </x-appHomeLayout>
  </main>
</body>
</html>