<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <title>Formulario de Registro</title>
</head>
<body>
    <h2>Registro de Mascotas</h2>
    <form action="{{ route('animal.store') }}" method="POST">
        @csrf

        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre"><br><br>

        <label for="especie">Especie:</label>
        <input type="text" id="especie" name="especie" required><br><br>

        <label for="raza">Raza:</label>
        <input type="text" id="raza" name="raza"><br><br>

        <label for="edad">Edad:</label>
        <input type="number" id="edad" name="edad"><br><br>

        <label for="peso">Peso:</label>
        <input type="number" step="0.01" id="peso" name="peso"><br><br>

        <label for="ubicacion">Ubicación:</label>
        <input type="text" id="ubicacion" name="ubicacion"><br><br>

        <label for="cuidador_id">ID del Cuidador:</label>
        <input type="number" id="cuidador_id" name="cuidador_id"><br><br>

        <label for="fecha_registro">Fecha de Registro:</label>
        <input type="date" id="fecha_registro" name="fecha_registro"><br><br>

        <button type="submit">Registrar</button>
    </form>

</body>
</html>