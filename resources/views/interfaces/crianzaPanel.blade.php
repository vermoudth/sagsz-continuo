<div class="container-fluid mt-4">
  <!-- Botón para añadir nueva crianza -->
  <div class="d-flex justify-content-between mb-3">
      <h3>Crianza de Animales</h3>
      <a href="{{ route('crianza.create') }}" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">Añadir Crianza</a>
  </div>

  <!-- Filtro de categorías (opcional) -->
  <div class="mb-4">
      <form method="GET" action="{{ route('crianza.index') }}">
          <div class="row">
              <div class="col">
                  <select class="form-select" name="categoria" id="categoria">
                      <option value="">Seleccionar Categoría</option>
                      <option value="Aves">Aves</option>
                      <option value="Mamíferos">Mamíferos</option>
                      <option value="Herpetofauna">Herpetofauna</option>
                      <option value="Acuario">Acuario</option>
                  </select>
              </div>
              <div class="col">
                  <button type="submit" class="btn btn-secondary">Filtrar</button>
              </div>
          </div>
      </form>
  </div>

  <!-- Cards para mostrar las crianzas -->
  <div class="row">
      @foreach($crianzas as $crianza)
          <div class="col-md-4 mb-4">
              <div class="card">
                  <img src="{{ asset('images/animal_default.jpg') }}" class="card-img-top" alt="Imagen Animal">
                  <div class="card-body">
                      <h5 class="card-title">{{ $crianza->animal->nombre }}</h5>
                      <p class="card-text">
                          Fecha de Registro: {{ \Carbon\Carbon::parse($crianza->fecha)->format('d/m/Y') }}<br>
                          Descripción: {{ Str::limit($crianza->descripcion, 50) }}
                      </p>
                      <a href="{{ route('crianza.show', $crianza->id) }}" class="btn btn-info">Ver más</a>
                      <a href="{{ route('crianza.edit', $crianza->id) }}" class="btn btn-warning">Editar</a>
                      <form action="{{ route('crianza.destroy', $crianza->id) }}" method="POST" style="display:inline;">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-danger" onclick="return confirm('¿Seguro que deseas eliminar este registro?')">Eliminar</button>
                      </form>
                  </div>
              </div>
          </div>
      @endforeach
  </div>

  <!-- Paginación -->
  <div class="d-flex justify-content-center">
      {{ $crianzas->links() }} <!-- Esto genera la paginación con Bootstrap -->
  </div>
</div>

<!-- Modal para Añadir Crianza -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="addModalLabel">Añadir Crianza</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <!-- Aquí colocas el formulario para añadir una nueva crianza -->
              <form action="{{ route('crianza.store') }}" method="POST">
                  @csrf
                  <!-- Campos del formulario -->
                  <div class="mb-3">
                      <label for="animal_id" class="form-label">Animal</label>
                      <select class="form-select" name="animal_id" required>
                          <option value="">Seleccionar Animal</option>
                          <!-- Llenar con los animales disponibles -->
                      </select>
                  </div>
                  <div class="mb-3">
                      <label for="descripcion" class="form-label">Descripción</label>
                      <textarea class="form-control" name="descripcion" rows="3" required></textarea>
                  </div>
                  <div class="mb-3">
                      <label for="fecha" class="form-label">Fecha</label>
                      <input type="date" class="form-control" name="fecha" required>
                  </div>
                  <div class="mb-3">
                      <label for="responsable_id" class="form-label">Responsable</label>
                      <select class="form-select" name="responsable_id" required>
                          <option value="">Seleccionar Responsable</option>
                          <!-- Llenar con los responsables disponibles -->
                      </select>
                  </div>
                  <button type="submit" class="btn btn-primary">Guardar</button>
              </form>
          </div>
      </div>
  </div>
</div>

