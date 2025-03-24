<h2>Crianza</h2>
    <p>Este es el contenido de la sección Crianza.</p>
<h2>Lista de Animales</h2>

@if(session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif

<table class="table table-striped">
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
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
