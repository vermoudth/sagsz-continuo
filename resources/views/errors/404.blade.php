<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error 404 - Página no encontrada</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="text-center">
    <div class="container">
        <h1 class="display-4">¡Vaya!</h1>
        <p class="lead">La página que estás buscando no existe.</p>
        <a href="{{ route('index') }}" class="btn btn-primary">Volver al inicio</a>
    </div>
</body>
</html>
