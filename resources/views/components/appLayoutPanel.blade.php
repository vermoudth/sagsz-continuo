<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <title>Panel de Control</title>
</head>
<body>
  @if(session('success'))
      <x-alert></x-alert>
  @endif
  <div class="container-xl d-flex d-flex-column">
    <!--Navegacion lateral-->
    <div class="d-flex flex-column flex-shrink-0 p-3 bg-light" style="width: 180px;">
      <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
      <img src="{{ asset('img/logo.jpeg') }}" class="img-fluid rounded" style="width: 30%;" alt="...">
        <span class="fs-4">SAGSZ</span>
      </a>
      <hr>
      <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
          <a href="#" class="nav-link active" aria-current="page">
          <i class="fas fa-home"></i>
          <strong>Inicio</strong>
          </a>
        </li>
        <li>
          <a href="#" class="nav-link link-dark">
          <i class="fas fa-truck"></i>
          <strong>Traslados</strong>
          </a>
        </li>
        <li>
          <a href="#" class="nav-link link-dark">
            <i class="fas fa-paw"></i>
            <strong>Crianza</strong>
          </a>
        </li>
        <li>
          <a href="#" class="nav-link link-dark">
            <i class="fas fa-flask-vial"></i>
            <strong>
              Laboratorio
            </strong>
            
          </a>
        </li>
        <li>
          <a href="#" class="nav-link link-dark">
          <i class="fa-solid fa-carrot"></i>
          <strong>Nutrición</strong>
          </a>
        </li>
      </ul>
      <hr>
      <div class="dropdown">
        <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fa-solid fa-gear"></i>
          <strong>Ajustes</strong>
        </a>
        <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
          <li><a class="dropdown-item" href="#">New project...</a></li>
          <li><a class="dropdown-item" href="#">Settings</a></li>
          <li><a class="dropdown-item" href="#">Profile</a></li>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item" ><form action="{{ route('logout') }}" method="POST" style="display: inline;">
              @csrf
              <button type="submit" class="btn btn-danger">Cerrar sesión</button>
            </form></a></li>
        </ul>
      </div>
    </div>

    <div class="container">
      <main>
        <header>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Panel de Inicio</a></li>
            </ol>
          </nav>
        </header>
        <!--Contenido de las secciones/panel-->
        <div class="container">
          {{$slot}}
        </div>
        
      </main>
    </div>
  </div>

</body>
</html>