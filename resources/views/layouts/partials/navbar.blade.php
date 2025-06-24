<nav class="app-header navbar navbar-expand bg-body">
    <div class="container-fluid">
        <!-- Sidebar Toggle -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                    <i class="bi bi-list"></i>
                </a>
            </li>
        </ul>

        <!-- Right Side -->
        <ul class="navbar-nav ms-auto">
            <!-- Fullscreen Toggle -->
            <li class="nav-item">
                <a class="nav-link" href="#" data-lte-toggle="fullscreen">
                    <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
                    <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none"></i>
                </a>
            </li>

            <!-- User Dropdown -->
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <img src="{{  Auth::user()->foto ? Storage::url(Auth::user()->foto) : asset('panel/assets/img/profile.png')}}" class="user-image rounded-circle shadow" alt="User Image" />
                    <span class="d-none d-md-inline">
                        {{ implode(' ', array_slice(explode(' ', Auth::user()->name), 0, 2)) }}
                        </span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <li class="user-header text-bg-primary text-center">
                        <img src="{{  Auth::user()->foto ? Storage::url(Auth::user()->foto) : asset('panel/assets/img/profile.png')}}" class="rounded-circle shadow mb-2" alt="User Image" />
                    <p class="mb-0">
                       {{ Auth::user()->name }}
                    </p>
                        <small>{{ Auth::user()->email }}</small>
                    </li>
                    <li class="user-footer d-flex justify-content-between px-3 py-2">
                        <a href="{{route('profile.edit')}}" class="btn btn-primary btn-flat">Pengaturan Profile</a>
                        <form action="{{route('logout')}}" method="POST">
                                @csrf
                                <button class="btn btn-danger btn-flat" type="submit">Logout</button>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
