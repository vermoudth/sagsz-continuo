@foreach ($crianzas as $crianza)
    <div class="card">
        <h3>{{ $crianza->animal->nombre }}</h3>
        <p>Descripción: {{ $crianza->descripcion }}</p>
        <p>Fecha: {{ $crianza->fecha }}</p>
        <p>Responsable: {{ $crianza->responsable->nombre }}</p>
    </div>
@endforeach
