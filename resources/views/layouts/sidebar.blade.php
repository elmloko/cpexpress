<!-- Sidebar -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/') }}" class="brand-link">
        <span class="brand-text font-weight-light">Mi Panel</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Inicio</p>
                    </a>
                </li>

                <!-- CRUD Usuarios -->
                <li class="nav-item">
                    <a href="{{ route('usuarios.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Gestión de Usuarios</p>
                    </a>
                </li>
                
                <!-- Agrega más menús aquí si lo necesitas -->
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
