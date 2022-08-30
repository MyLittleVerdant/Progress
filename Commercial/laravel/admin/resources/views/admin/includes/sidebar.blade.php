<aside class="main-sidebar main-sidebar-custom sidebar-dark-primary elevation-4">
    <a href="{{ route('admin.index') }}" class="brand-link">
        <img src="/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">Korm</span>
    </a>
    <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-sidebar">
                    <i class="fas fa-search fa-fw"></i>
                </button>
            </div>
        </div>
    </div>
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="{{ route('admin.users.index') }}"
                   class="nav-link @if(Route::is('admin.users.*')) active @endif">
                    <i class="nav-icon fas fa-user"></i>
                    <p>
                        Пользователи
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.clients.index') }}"
                   class="nav-link @if(Route::is('admin.clients.*')) active @endif">
                    <i class="nav-icon fa-solid fa-user-group"></i>
                    <p>
                        Клиенты
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.feedback.index') }}"
                   class="nav-link @if(Route::is('admin.feedback.*')) active @endif">
                    <i class="nav-icon fas fa-phone"></i>
                    <p>
                        Обратная связь
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.diet.index') }}"
                   class="nav-link @if(Route::is('admin.diet.*')) active @endif">
                    <i class="nav-icon fa-solid fa-list"></i>
                    <p>
                        Рационы
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.pets.index') }}"
                   class="nav-link @if(Route::is('admin.pets.*')) active @endif">
                    <i class="nav-icon fa-solid fa-dog"></i>
                    <p>
                        Питомцы
                    </p>
                </a>
            </li>
        </ul>
    </nav>
</aside>
