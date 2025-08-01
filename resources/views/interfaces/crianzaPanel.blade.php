<!-- Contenedor principal con Tailwind -->
<div class="w-full mt-4">
  <!-- Botón para añadir nueva crianza y título -->
  <div class="flex justify-between items-center mb-3">
      <h3 class="text-xl font-semibold">Crianza de Animales</h3>

      
    <div x-data="{ showAdd: false }">
        <!-- Botón que activa el modal -->
    <button @click="showAdd = true"
        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded shadow transition">
        Añadir Crianza
    </button>

        <!-- Modal para añadir crianza -->
        <div x-show="showAdd" class="fixed inset-0 bg-gray-900 bg-opacity-80 flex items-center justify-center z-50">
            <div class="bg-gray-800 rounded-lg shadow-lg p-6 w-full max-w-md border border-gray-700">
                <h2 class="text-lg font-semibold mb-4 text-white">Añadir Crianza</h2>
                <form action="{{ route('crianza.store') }}" method="POST">
                    @csrf
                    <!-- Campo Animal -->
                    <div class="mb-4">
                        <label for="animal_id" class="block text-gray-300 font-medium mb-2">Animal</label>
                        <select class="block w-full rounded border-gray-600 bg-gray-700 text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" name="animal_id" required>
                            <option value="">Seleccionar Animal</option>
                            @foreach($animales as $animal)
                                <option value="{{ $animal->id }}">{{ $animal->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Campo Descripción -->
                    <div class="mb-4">
                        <label for="descripcion" class="block text-gray-300 font-medium mb-2">Descripción</label>
                        <textarea class="block w-full rounded border-gray-600 bg-gray-700 text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" name="descripcion" rows="3" required></textarea>
                    </div>
                    <!-- Campo Fecha -->
                    <div class="mb-4">
                        <label for="fecha" class="block text-gray-300 font-medium mb-2">Fecha</label>
                        <input type="date" class="block w-full rounded border-gray-600 bg-gray-700 text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" name="fecha" required>
                    </div>
                    <!-- Campo Responsable -->
                    <div class="mb-4">
                        <label for="responsable_id" class="block text-gray-300 font-medium mb-2">Responsable</label>
                        <select class="block w-full rounded border-gray-600 bg-gray-700 text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" name="responsable_id" required>
                            <option value="">Seleccionar Responsable</option>
                            @foreach($usuarios as $usuario)
                                <option value="{{ $usuario->id }}">{{ $usuario->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="w-full bg-blue-700 hover:bg-blue-800 text-white font-semibold py-2 px-4 rounded shadow transition">Guardar</button>
                </form>
                <!-- Botón para cerrar el modal -->
                <button @click="showAdd = false"
                    class="mt-4 w-full bg-red-700 hover:bg-red-800 text-white font-semibold py-2 px-4 rounded shadow transition">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
  </div>

  <!-- Filtro de categorías (JS dinámico) -->
<div class="mb-4">
    <div class="flex">
        <div class="w-full">
            <select class="form-select block w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" id="filtro-categoria">
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
  <div class="flex flex-wrap -mx-2" id="contenedor-crianza">
      @foreach($crianzas as $crianza)
          <div class="w-full md:w-1/3 px-2 mb-4">
              <div class="bg-white rounded shadow p-4" data-categoria="{{ $crianza->animal->categoria }}">
                  <div class="card-body">
                      <h5 class="text-lg font-semibold mb-2">{{ $crianza->animal->nombre }}</h5>
                      <p class="text-gray-700 text-sm mb-2">
                          Fecha de Registro: {{ \Carbon\Carbon::parse($crianza->fecha)->format('d/m/Y') }}<br>
                          Descripción: {{ Str::limit($crianza->descripcion, 50) }} <br>
                          Fecha: {{ $crianza->fecha }} <br>
                          Responsable: {{ $crianza->responsable->nombre }} <br>
                      </p>

                      <button class="bg-yellow-400 hover:bg-yellow-500 text-white font-bold py-1 px-3 rounded text-xs edit-btn"
                          data-id="{{ $crianza->id }}"
                          data-animal="{{ $crianza->animal_id }}"
                          data-descripcion="{{ $crianza->descripcion }}"
                          data-fecha="{{ $crianza->fecha }}"
                          data-responsable="{{ $crianza->responsable_id }}"
                          data-bs-toggle="modal" data-bs-target="#editModal">
                          Editar
                      </button>

                      <form action="{{ route('crianza.destroy', $crianza->id) }}" method="POST" class="inline">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded text-xs" onclick="return confirm('¿Seguro que deseas eliminar este registro?')">Eliminar</button>
                      </form>
                  </div>
              </div>
          </div>
      @endforeach
  </div>

  <!-- Paginación -->
  <div class="flex justify-center mt-4">
    {{ $crianzas->links() }} <!-- Esto genera la paginación, ahora centrada con Tailwind -->
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

