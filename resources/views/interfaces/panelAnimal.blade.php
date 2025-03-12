<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Lista de Animales</title>
</head>
<body>

    <h2>Lista de Animales</h2>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Especie</th>
                <th>Raza</th>
                <th>Edad</th>
                <th>Peso</th>
                <th>Ubicación</th>
                <th>ID del Cuidador</th>
                <th>Fecha de Registro</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($animales as $animal)
            <tr>
                <td>{{ $animal->id }}</td>
                <td>{{ $animal->nombre }}</td>
                <td>{{ $animal->especie }}</td>
                <td>{{ $animal->raza }}</td>
                <td>{{ $animal->edad }}</td>
                <td>{{ $animal->peso }}</td>
                <td>{{ $animal->ubicacion }}</td>
                <td>{{ $animal->cuidador_id }}</td>
                <td>{{ $animal->fecha_registro }}</td>
                <td>
                    <form action="{{ route('animal.destroy', $animal->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este animal?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background-color: red; color: white; border: none; padding: 5px; cursor: pointer;">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
