   <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="{{ route('dashboard') }}" class="brand-link">
            {{-- <img src="..." class="brand-image" /> --}}
            <span class="brand-text fw-light">SIPB</span>
        </a>
    </div>
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                <li class="nav-header">Menu</li>

                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->is('dashboard*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-speedometer2"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                {{-- Staff Gudang --}}
                <li class="nav-item">
                    <a href="{{route('Manajemen_Barang.index')}}" class="nav-link {{ request()->is('Manajemen_Barang*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-box-seam"></i>
                        <p>Manajemen Barang</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('Barang_Masuk.index')}}" class="nav-link {{ request()->is('Kelola_Barang_Masuk*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-box-arrow-in-down"></i>
                        <p>Kelola Barang Masuk</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('Barang_Keluar.index')}}" class="nav-link {{ request()->is('Kelola_Barang_Keluar*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-box-arrow-up"></i>
                        <p>Kelola Barang Keluar</p>
                    </a>
                </li>

                @if(Auth::user()->role == 1)
                {{-- Admin --}}
                 <li class="nav-header">Master Data</li>
                <li class="nav-item">
                    <a href="{{route('Kategori.index')}}" class="nav-link {{ request()->is('Kelola-Kategori*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-tags"></i>
                        <p>Kelola Kategori</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('Jenis.index')}}" class="nav-link {{ request()->is('Kelola-Jenis*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-ui-checks-grid"></i>
                        <p>Kelola Jenis Barang</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('Pengguna.index')}}" class="nav-link {{ request()->is('Kelola-Pengguna*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-people"></i>
                        <p>Kelola Pengguna</p>
                    </a>
                </li>
                @endif
            </ul>
        </nav>
    </div>
</aside>

