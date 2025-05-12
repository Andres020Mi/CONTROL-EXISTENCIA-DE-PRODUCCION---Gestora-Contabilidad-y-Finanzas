<!doctype html>
<html lang="en">
  <!--begin::Head-->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>@yield('title')</title>
    <!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="AdminLTE v4 | Dashboard" />
    <meta name="author" content="ColorlibHQ" />
    <meta
      name="description"
      content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS."
    />
    <meta
      name="keywords"
      content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard"
    />
    <!--end::Primary Meta Tags-->
    <!--begin::Fonts-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
      integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q="
      crossorigin="anonymous"
    />
    <!--end::Fonts-->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/styles/overlayscrollbars.min.css"
      integrity="sha256-tZHrRjVqNSRyWg2wbppGnT833E/Ys0DHWGwT04GiqQg="
      crossorigin="anonymous"
    />
    <!--end::Third Party Plugin(OverlayScrollbars)-->
    <!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
      integrity="sha256-9kPW/n5nn53j4WMRYAxe9c1rCY96Oogo/MKSVdKzPmI="
      crossorigin="anonymous"
    />
    <!--end::Third Party Plugin(Bootstrap Icons)-->
    <!--begin::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="{{asset('Adminlte/dist/css/adminlte.css')}}" />
    <!--end::Required Plugin(AdminLTE)-->
   
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('links_css_head')
  </head>
  <!--end::Head-->
  <!--begin::Body-->
  <body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
      <!--begin::Header-->
    <nav class="app-header navbar navbar-expand bg-body">
    <div class="container-fluid">
        <!-- Start Navbar Links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                    <i class="bi bi-list"></i>
                </a>
            </li>

            {{-- <!-- Navigation Links según rol -->
            @if(Auth::user()->role == 'admin' || Auth::user()->role == 'instructor')
                <li class="nav-item">
                    <a href="{{ route('solicitudes_movimientos.index') }}" class="nav-link {{ request()->routeIs('solicitudes_movimientos.index') ? 'active' : '' }}">
                        Solicitudes de movimientos
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('lideres_unidades.index') }}" class="nav-link {{ request()->routeIs('lideres_unidades.index') ? 'active' : '' }}">
                        Gestionar líderes de unidades
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('insumos.index') }}" class="nav-link {{ request()->routeIs('insumos.index') ? 'active' : '' }}">
                        Insumos
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('stocks.index') }}" class="nav-link {{ request()->routeIs('stocks.index') ? 'active' : '' }}">
                        Stock
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('movimientos.index') }}" class="nav-link {{ request()->routeIs('movimientos.index') ? 'active' : '' }}">
                        Movimientos
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('unidades_de_produccion.index') }}" class="nav-link {{ request()->routeIs('unidades_de_produccion.index') ? 'active' : '' }}">
                        Unidades de Producción
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('almacenes.index') }}" class="nav-link {{ request()->routeIs('almacenes.index') ? 'active' : '' }}">
                        Almacenes
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('proveedores.index') }}" class="nav-link {{ request()->routeIs('proveedores.index') ? 'active' : '' }}">
                        Proveedores
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}">
                        Administrar usuarios
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('solicitudes_movimientos.mis_solicitudes') }}" class="nav-link {{ request()->routeIs('solicitudes_movimientos.mis_solicitudes') ? 'active' : '' }}">
                        Mis solicitudes
                    </a>
                </li>
            @elseif(Auth::user()->role == 'aprendiz' || Auth::user()->role == 'lider de la unidad')
                <li class="nav-item">
                    <a href="{{ route('insumos.index') }}" class="nav-link {{ request()->routeIs('insumos.index') ? 'active' : '' }}">
                        Insumos
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('stocks.index') }}" class="nav-link {{ request()->routeIs('stocks.index') ? 'active' : '' }}">
                        Stock
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('movimientos.index') }}" class="nav-link {{ request()->routeIs('movimientos.index') ? 'active' : '' }}">
                        Movimientos
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('unidades_de_produccion.index') }}" class="nav-link {{ request()->routeIs('unidades_de_produccion.index') ? 'active' : '' }}">
                        Unidades de Producción
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('almacenes.index') }}" class="nav-link {{ request()->routeIs('almacenes.index') ? 'active' : '' }}">
                        Almacenes
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('proveedores.index') }}" class="nav-link {{ request()->routeIs('proveedores.index') ? 'active' : '' }}">
                        Proveedores
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('solicitudes_movimientos.mis_solicitudes') }}" class="nav-link {{ request()->routeIs('solicitudes_movimientos.mis_solicitudes') ? 'active' : '' }}">
                        Mis solicitudes
                    </a>
                </li>
            @endif
                --}} 
        </ul>

        <!-- End Navbar Links -->
        <ul class="navbar-nav ms-auto">
            {{-- <!-- Navbar Search -->
            <li class="nav-item">
                <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                    <i class="bi bi-search"></i>
                </a>
            </li>

            <!-- Messages Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-bs-toggle="dropdown" href="#">
                    <i class="bi bi-chat-text"></i>
                    <span class="navbar-badge badge text-bg-danger">3</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <a href="#" class="dropdown-item">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <img src="{{ asset('Adminlte/dist/assets/img/user1-128x128.jpg') }}" alt="User Avatar" class="img-size-50 rounded-circle me-3" />
                            </div>
                            <div class="flex-grow-1">
                                <h3 class="dropdown-item-title">Brad Diesel</h3>
                                <p class="fs-7">Call me whenever you can...</p>
                                <p class="fs-7 text-secondary"><i class="bi bi-clock-fill me-1"></i> 4 Hours Ago</p>
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
                </div>
            </li> --}}

            {{-- <!-- Notifications Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-bs-toggle="dropdown" href="#">
                    <i class="bi bi-bell-fill"></i>
                    <span class="navbar-badge badge text-bg-warning">15</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <span class="dropdown-item dropdown-header">15 Notifications</span>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="bi bi-envelope me-2"></i> 4 new messages
                        <span class="float-end text-secondary fs-7">3 mins</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                </div>
            </li> --}}

            <!-- Fullscreen Toggle -->
            <li class="nav-item">
                <a class="nav-link" href="#" data-lte-toggle="fullscreen">
                    <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
                    <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none"></i>
                </a>
            </li> 

            <!-- User Menu Dropdown -->
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <img src="{{ asset('Adminlte/dist/assets/img/user2-160x160.png') }}" class="user-image rounded-circle shadow" alt="User Image" />
                    <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <li class="user-header text-bg-primary">
                        <img src="{{ asset('Adminlte/dist/assets/img/user2-160x160.png') }}" class="rounded-circle shadow" alt="User Image" />
                        <p>
                            {{ Auth::user()->name }} - {{ ucfirst(Auth::user()->role) }}
                            <small>Miembro desde {{ Auth::user()->created_at->format('M. Y') }}</small>
                        </p>
                    </li>
                    <li class="user-footer">
                        
                        <a href="{{ route('logout') }}" class="btn btn-default btn-flat float-end" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Cerrar sesión
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
<style>
    .app-sidebar .nav-link p {
    white-space: normal; /* Permite que el texto se divida en varias líneas */
    overflow: visible; /* Evita que el texto se oculte */
    text-overflow: initial; /* Elimina los puntos suspensivos */
    max-width: none; /* Elimina restricciones de ancho máximo */
}

.app-sidebar .nav-link {
    display: flex;
    align-items: center;
    padding: 0.5rem 1rem; /* Ajusta el padding para dar espacio */
}

.app-sidebar .sidebar-menu {
    width: 250px; /* Aumenta el ancho del sidebar si es necesario */
}

/* Opcional: Ajusta el ancho del sidebar cuando está colapsado */
.app-sidebar.sidebar-mini.sidebar-collapse .sidebar-menu {
    width: 60px;
}

.app-sidebar.sidebar-mini.sidebar-collapse .nav-link p {
    display: none; /* Oculta el texto cuando el sidebar está colapsado */
}
</style>
      <!--end::Header-->
      <!--begin::Sidebar-->
      <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
        <!-- Sidebar Brand -->
        <div class="sidebar-brand">
            <a href="{{ route('dashboard') }}" class="brand-link">
                <img src="{{ asset('Adminlte/dist/assets/img/AdminLTELogo.png') }}" alt="Logo" class="brand-image opacity-75 shadow" />
                <span class="brand-text fw-light">Existencias</span>
            </a>
        </div>
    
        <!-- Sidebar Wrapper -->
        <div class="sidebar-wrapper">
            <nav class="mt-2">
                <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                    <!-- Dashboard -->
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-speedometer"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
    
                    <!-- Rutas para admin e instructor -->
                    @if(Auth::user()->role == 'admin' || Auth::user()->role == 'instructor')
                        <li class="nav-item">
                            <a href="{{ route('articulos.index') }}" class="nav-link {{ request()->routeIs('articulos.index') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-file-earmark-text"></i>
                                <p>Existencias</p>
                            </a>
                        </li>
                        <li class="nav-item">
                          <a href="{{ route('movimientos.index') }}" class="nav-link {{ request()->routeIs('movimientos.index') ? 'active' : '' }}">
                              <i class="nav-icon bi bi-file-earmark-text"></i>
                              <p>Movimientos</p>
                          </a>
                      </li>
                        
                    @endif
    
                    
                </ul>
            </nav>
        </div>
    </aside>
      <!--end::Sidebar-->
      <!--begin::App Main-->
      <main class="app-main">
      @yield('content')
      </main>
      <!--end::App Main-->
      <!--begin::Footer-->
      <footer class="app-footer text-center py-3">
        <div class="container">
            <strong>© 2025 Gestión de Existencias SENA. Todos los derechos reservados.</strong>
            <br>
            <small>Desarrollado por Andrés Gonzalo Barrera Cortés | Contacto: +57 316 820 9707 | andresgbarrerac@gmail.com </small>
            <br>
            <small>28/03/2025</small>
        </div>
    </footer>
      <!--end::Footer-->
    </div>
    <!--end::App Wrapper-->
    <!--begin::Script-->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <script
      src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/browser/overlayscrollbars.browser.es6.min.js"
      integrity="sha256-dghWARbRe2eLlIJ56wNB+b760ywulqK3DzZYEpsg2fQ="
      crossorigin="anonymous"
    ></script>
    <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
    <script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
      integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
      crossorigin="anonymous"
    ></script>
    <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
      integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
      crossorigin="anonymous"
    ></script>
    <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
    <script src="{{asset('Adminlte/dist/js/adminlte.js')}}"></script>
    <!--end::Required Plugin(AdminLTE)--><!--begin::OverlayScrollbars Configure-->
    <script>
      const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
      const Default = {
        scrollbarTheme: 'os-theme-light',
        scrollbarAutoHide: 'leave',
        scrollbarClickScroll: true,
      };
      document.addEventListener('DOMContentLoaded', function () {
        const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
        if (sidebarWrapper && typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== 'undefined') {
          OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
            scrollbars: {
              theme: Default.scrollbarTheme,
              autoHide: Default.scrollbarAutoHide,
              clickScroll: Default.scrollbarClickScroll,
            },
          });
        }
      });
    </script>
    <!--end::OverlayScrollbars Configure-->
    <!-- OPTIONAL SCRIPTS -->
    <!-- sortablejs -->
    <script
      src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"
      integrity="sha256-ipiJrswvAR4VAx/th+6zWsdeYmVae0iJuiR+6OqHJHQ="
      crossorigin="anonymous"
    ></script>
    <!-- sortablejs -->
    <script>
      const connectedSortables = document.querySelectorAll('.connectedSortable');
      connectedSortables.forEach((connectedSortable) => {
        let sortable = new Sortable(connectedSortable, {
          group: 'shared',
          handle: '.card-header',
        });
      });

      const cardHeaders = document.querySelectorAll('.connectedSortable .card-header');
      cardHeaders.forEach((cardHeader) => {
        cardHeader.style.cursor = 'move';
      });
    </script>
   

        <!-- Modal para errores -->
    @if ($errors->any() || session('error'))
    <div class="modal" id="errorModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Error</h2>
                <button class="close-btn" onclick="closeModal()">×</button>
            </div>
            <div class="modal-body">
                @if ($errors->any())
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
                @if (session('error'))
                    <p>{{ session('error') }}</p>
                @endif
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" onclick="closeModal()">Cerrar</button>
            </div>
        </div>
    </div>

    <style>
    .modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
        animation: fadeIn 0.3s ease-in-out;
    }

    .modal-content {
        background: #fff;
        border-radius: 8px;
        width: 90%;
        max-width: 500px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        overflow: hidden;
        animation: slideIn 0.3s ease-in-out;
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 20px;
        background: #dc3545;
        color: #fff;
        border-bottom: 1px solid #dee2e6;
    }

    .modal-header h2 {
        margin: 0;
        font-size: 1.5rem;
    }

    .close-btn {
        background: none;
        border: none;
        color: #fff;
        font-size: 1.5rem;
        cursor: pointer;
        transition: color 0.2s;
    }

    .close-btn:hover {
        color: #f8d7da;
    }

    .modal-body {
        padding: 20px;
        font-size: 1rem;
        color: #333;
    }

    .modal-body ul {
        list-style: disc;
        padding-left: 20px;
        margin: 0;
    }

    .modal-footer {
        padding: 15px 20px;
        text-align: right;
        border-top: 1px solid #dee2e6;
    }

    .btn {
        padding: 8px 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 1rem;
        transition: background 0.2s;
    }

    .btn-primary {
        background: #dc3545;
        color: #fff;
    }

    .btn-primary:hover {
        background: #c82333;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideIn {
        from { transform: translateY(-20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    /* Estilo para el select */
    select {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 1rem;
        background-color: #fff;
        cursor: pointer;
    }

    select:focus {
        outline: none;
        border-color: #007bff;
        box-shadow: 0 0 5px rgba(0,123,255,0.3);
    }
    </style>

    <script>
    function closeModal() {
        var modal = document.getElementById('errorModal');
        if (modal) {
            modal.style.display = 'none';
        }
    }

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeModal();
        }
    });
    </script>
    @endif
    
    <!--end::Script-->
    @yield('scritps_end_body')
  </body>
  <!--end::Body-->
</html>