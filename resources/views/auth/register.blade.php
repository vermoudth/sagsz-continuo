<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  @vite(['resources/css/app.css', 'resources/js/app.js'])

    <title>Registro</title>
</head>
<body>
  <div class="container">
  <h1>Registro</h1>
    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="/register">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nombre:</label>
            <input type="text" class="form-control" id="name" name="name"  required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Correo electrónico:</label>
            <input type="email" class="form-control"  id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Contraseña:</label>
            <input type="password" class="form-control" id="password" name="password"  required>
        </div class="mb-3">
        <div>
            <label for="password_confirmation" class="form-label">Confirmar contraseña:</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"  required>
        </div>
        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Registrarse</button>
        </div>
    </form>
  </div>
    
</body>
</html>
