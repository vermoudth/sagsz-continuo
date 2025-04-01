<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/appLayoutPanel.js'])
    <title>Panel de Control</title>
    
</head>
<body>
  @if(session('success'))
      <x-alert id="alerta"></x-alert>
  @endif
  <!--Contenedor principal-->
  <div class="container-fluid d-flex mx-0 py-0 px-0 p-3" style="height: 100vh;">
    <!--Barra de navegación-->
    <nav class="navbar-nav d-flex flex-column p-3 bg-light" style="width: 18%;">
      <a href="/homePanel" class="d-flex align-items-center justify-content-evenly my-3 me-md-auto link-dark text-decoration-none">
        <img src="{{ asset('img/logo.jpeg') }}" class="img-fluid rounded" style="width: 30%;" alt="Logo">
        <span class="fs-4">SAGSZ</span>
      </a>
      <hr>
      <ul class="nav flex-column mb-auto">
        <li class="nav-item">
          <a href="/homePanel" class="nav-link link-dark" id="inicio-link" style="cursor: pointer"><i class="fas fa-home"></i> <strong>Inicio</strong></a>
        </li>
        <li>
          <a class="nav-link link-dark" id="traslados-link" style="cursor: pointer"><i class="fas fa-truck"></i> <strong>Traslados</strong></a>
        </li>
        <li>
          <a class="nav-link link-dark" id="crianza-link" style="cursor: pointer"><i class="fas fa-paw"></i> <strong>Crianza</strong></a>
        </li>
        <li>
          <a class="nav-link link-dark" id="lab-link" style="cursor: pointer"><i class="fa-solid fa-flask"></i> <strong>Laboratorio</strong></a>
        </li>
        <li>
          <a class="nav-link link-dark" id="nutri-link" style="cursor: pointer"><i class="fa-solid fa-heart"></i><strong>Nutrición</strong></a>
        </li>
      </ul>
      <hr>
      <div class="dropdown dropup">
        <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" id="dropdownUser2" data-bs-toggle="dropdown">
          <i class="fa-solid fa-gear"></i> <strong>Ajustes</strong>
        </a>
        <ul class="dropdown-menu text-small shadow">
          <li><a class="dropdown-item" href="#">Settings</a></li>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item-text"><form action="{{ route('logout') }}" method="POST" style="display: inline;">
              @csrf
              <button type="submit" class="btn btn-danger">Cerrar sesión</button>
            </form></a></li>
        </ul>
      </div>
    </nav>
    <!--Contenido Principal-->
    <div class="container">
      <main>
        <!--Cabecera de breadcums y busqueda-->
        <header class="d-flex justify-content-evenly my-2 bg-light" style="width: 100%;">
          <nav class="mx-1" aria-label="breadcrumb" style="width: 70%;">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a class="text-decoration-none text-dark" href="/homePanel">Panel de Inicio</a></li>
                <!--<li class="breadcrumb-item"><a class="text-decoration-none text-dark" href="/homePanel">Panel de Inicio</a></li>
                <li class="breadcrumb-item"><a class="text-decoration-none text-dark" href="/homePanel">Panel de Inicio</a></li>
                <li class="breadcrumb-item"><a class="text-decoration-none text-dark" href="/homePanel">Panel de Inicio</a></li>-->
            </ol>     
          </nav>
          <form class="d-flex" style="width: 30%;" >
            <input class="form-control me-1" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
          </form>   
        </header>
        <hr>
        <!--Contenido de Inicio-->
        <div id="homePanel" class=" text-center">
          <h1>Panel de Control</h1>
          <p>Bienvenido al panel de control de la aplicación.</p>
          <img src="{{ asset('img/logo.jpeg') }}" class="img-fluid rounded" style="width: 35%;" alt="Logo">
        </div>
        <!--Contenido Dinámico-->
        <div id="contenido-dinamico" class="d-flex flex-column aling-items-center text-center justify-content-center my-2"></div>
      </main>
    </div>
  </div>

  <script>
    var routePanelAnimales = "{{ route('panel.animales') }}";
    var routePanelTraslados = "{{ route('trasladosPanel') }}";
  </script>


</body>
</html>