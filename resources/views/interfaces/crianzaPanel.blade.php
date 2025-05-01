<div class="container-fluid mt-4">
  <!-- Botón para añadir nueva crianza -->
  <div class="d-flex justify-content-between mb-3">
      <h3>Crianza de Animales</h3>
      <a href="{{ route('crianza.create') }}" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">Añadir Crianza</a>
  </div>

  <!-- Filtro de categorías (JS dinámico) -->
<div class="mb-4">
    <div class="row">
        <div class="col">
            <select class="form-select" id="filtro-categoria">
                <option value="">Todas las Categorías</option>
                <option value="Aves">Aves</option>
                <option value="Mamíferos">Mamíferos</option>
                <option value="Herpetofauna">Herpetofauna</option>
                <option value="Acuario">Acuario</option>
            </select>
        </div>
    </div>
</div>

  <!-- Cards para mostrar las crianzas -->
  <div class="row">
      @foreach($crianzas as $crianza)
          <div class="col-md-4 mb-4">
              <div class="card" data-categoria="{{ $crianza->animal->categoria }}">
                  <div class="card-body">
                      <h5 class="card-title">{{ $crianza->animal->nombre }}</h5>
                      <p class="card-text">
                          Fecha de Registro: {{ \Carbon\Carbon::parse($crianza->fecha)->format('d/m/Y') }}<br>
                          Descripción: {{ Str::limit($crianza->descripcion, 50) }} <br>
                          Fecha: {{ $crianza->fecha }} <br>
                          Responsable: {{ $crianza->responsable->nombre }} <br>
                      </p>

                      <button class="btn btn-warning btn-sm edit-btn" 
                          data-id="{{ $crianza->id }}" 
                          data-animal="{{ $crianza->animal_id }}" 
                          data-descripcion="{{ $crianza->descripcion }}" 
                          data-fecha="{{ $crianza->fecha }}" 
                          data-responsable="{{ $crianza->responsable_id }}"
                          data-bs-toggle="modal" data-bs-target="#editModal">
                          Editar
                      </button>

                      <form action="{{ route('crianza.destroy', $crianza->id) }}" method="POST" style="display:inline;">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar este registro?')">Eliminar</button>
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
                    <!-- Campo Animal -->
                  <div class="mb-3">
                    
                      <label for="animal_id" class="form-label">Animal</label>
                      <select class="form-select" name="animal_id" required>
                        <option value="">Seleccionar Animal</option>
                          @foreach($animales as $animal)
                            <option value="{{ $animal->id }}">{{ $animal->nombre }}</option>
                          @endforeach
                      </select>
                  </div>
                   <!-- Campo Descripción -->
                  <div class="mb-3">
                      <label for="descripcion" class="form-label">Descripción</label>
                      <textarea class="form-control" name="descripcion" rows="3" required></textarea>
                  </div>
                  <!-- Campo Fecha -->
                  <div class="mb-3">
                      <label for="fecha" class="form-label">Fecha</label>
                      <input type="date" class="form-control" name="fecha" required>
                  </div>
                  <!-- Campo Responsable -->
                  <div class="mb-3">
                      <label for="responsable_id" class="form-label">Responsable</label>
                      <select class="form-select" name="responsable_id" required>
                          <option value="">Seleccionar Responsable</option>
                          @foreach($usuarios as $usuario)
                              <option value="{{ $usuario->id }}">{{ $usuario->nombre }}</option>
                          @endforeach
                      </select>
                  </div>
                  <button type="submit" class="btn btn-primary">Guardar</button>
              </form>
          </div>
      </div>
  </div>
</div>

<!-- Modal para Editar Crianza -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="editModalLabel">Editar Crianza</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <form id="editForm" method="POST"  action="{{ route('crianza.update', $crianza->id) }}">
                  @csrf
                  @method('PUT') <!-- Método PUT para actualización -->

                  <!-- Campo Animal -->
                  <div class="mb-3">
                      <label for="edit_animal_id" class="form-label">Animal</label>
                      <select class="form-select" name="animal_id" id="edit_animal_id" required>
                          @foreach($animales as $animal)
                              <option value="{{ $animal->id }}">{{ $animal->nombre }}</option>
                          @endforeach
                      </select>
                  </div>

                  <!-- Campo Descripción -->
                  <div class="mb-3">
                      <label for="edit_descripcion" class="form-label">Descripción</label>
                      <textarea class="form-control" name="descripcion" id="edit_descripcion" rows="3" required></textarea>
                  </div>

                  <!-- Campo Fecha -->
                  <div class="mb-3">
                      <label for="edit_fecha" class="form-label">Fecha</label>
                      <input type="date" class="form-control" name="fecha" id="edit_fecha" required>
                  </div>

                  <!-- Campo Responsable -->
                  <div class="mb-3">
                      <label for="edit_responsable_id" class="form-label">Responsable</label>
                      <select class="form-select" name="responsable_id" required>
                          <option value="">Seleccionar Responsable</option>
                          @foreach($usuarios as $usuario)
                              <option value="{{ $usuario->id }}">{{ $usuario->nombre }}</option>
                          @endforeach
                      </select>
                  </div>

                  <button type="submit" class="btn btn-primary">Actualizar</button>
              </form>
          </div>
      </div>
  </div>
</div>


<script>
  document.addEventListener("DOMContentLoaded", function() {
      const editModal = document.getElementById('editModal');
      const editForm = document.getElementById('editForm');
      const editAnimal = document.getElementById('edit_animal_id');
      const editDescripcion = document.getElementById('edit_descripcion');
      const editFecha = document.getElementById('edit_fecha');
      const editResponsable = document.getElementById('edit_responsable_id');
  
      document.querySelectorAll('.edit-btn').forEach(button => {
          button.addEventListener('click', function() {
              const crianzaId = this.getAttribute('data-id');
              const animalId = this.getAttribute('data-animal');
              const descripcion = this.getAttribute('data-descripcion');
              const fecha = this.getAttribute('data-fecha');
              const responsableId = this.getAttribute('data-responsable');
  
              editForm.action = `/crianza/${crianzaId}`; // Ruta de actualización
              editAnimal.value = animalId;
              editDescripcion.value = descripcion;
              editFecha.value = fecha;
              editResponsable.value = responsableId;
          });
      });
  });
  </script>
  
  <script>
    document.addEventListener("DOMContentLoaded", function () {
        const filtroCategorias = document.getElementById("filtro-categoria");
    
        filtroCategorias.addEventListener("change", function () {
            let categoriaSeleccionada = this.value;
            let cards = document.querySelectorAll("#contenedor-crianza .card");
    
            cards.forEach(card => {
                let categoria = card.getAttribute("data-categoria");
    
                if (categoriaSeleccionada === "" || categoria === categoriaSeleccionada) {
                    card.style.display = "block"; // Mostrar la card
                } else {
                    card.style.display = "none"; // Ocultar la card
                }
            });
        });
    });
    </script>
    
    