<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Brand Aplikasi -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-boxes"></i>
        </div>
        <div class="sidebar-brand-text mx-3">M-Stok</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ $menuDashboard ?? '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    @if (auth()->user()->peran == 'admin')
        <!-- Heading -->
        <div class="sidebar-heading">
            Menu Admin
        </div>

        <li class="nav-item {{ $MProduk ?? '' }}">
            <a class="nav-link" href="{{ route('produk') }}">
                <i class="fas fa-fw fa-box"></i>
                <span>Produk</span>
            </a>
        </li>

        <!-- Nav Item - Kategori Produk -->
        <li class="nav-item {{ $MKategori ?? '' }}">
            <a class="nav-link" href="{{ route('kategori') }}">
                <i class="fas fa-fw fa-tags"></i>
                <span>Kategori Produk</span>
            </a>
        </li>

        <!-- Nav Item - Stok Masuk -->
        <li class="nav-item {{ $MMasuk ?? '' }}">
            <a class="nav-link" href="{{ route('stokmasuk') }}">
                <i class="fas fa-fw fa-arrow-down"></i>
                <span>Stok Masuk</span>
            </a>
        </li>

        <!-- Nav Item - Stok Keluar -->
        <li class="nav-item {{ $MKeluar ?? '' }}">
            <a class="nav-link" href="{{ route('stokkeluar') }}">
                <i class="fas fa-fw fa-arrow-up"></i>
                <span>Stok Keluar</span>
            </a>
        </li>

        <!-- Nav Item - Notifikasi Stok Minim -->
        <li class="nav-item {{ $MMinim ?? '' }}">
            <a class="nav-link" href="{{ route('stokminim') }}">
                <i class="fas fa-fw fa-bell"></i>
                <span>Stok Minim</span>
                @if ($stokMinimCount > 0)
                    <span class="badge badge-danger badge-counter ml-2">{{ $stokMinimCount }}</span>
                @endif
            </a>
        </li>

        <!-- Nav Item - Laporan -->
        <li class="nav-item {{ $MLaporan ?? '' }}">
            <a class="nav-link" href="{{ route('laporan.mutasi_stok') }}">
                <i class="fas fa-fw fa-chart-bar"></i>
                <span>Laporan</span>
            </a>
        </li>

        <!-- Nav Item - Kelola Pengguna -->
        <li class="nav-item {{ $MUser ?? '' }}">
            <a class="nav-link" href="{{ route('user') }}">
                <i class="fas fa-fw fa-users"></i>
                <span>Kelola Penngguna</span>
            </a>
        </li>
    @else
        <!-- Heading -->
        <div class="sidebar-heading">
            Menu User
        </div>

        <!-- Nav Item - Produk -->
        <li class="nav-item {{ $MProdukKaryawan ?? '' }}">
            <a class="nav-link" href="{{ route('produk') }}">
                <i class="fas fa-fw fa-box"></i>
                <span>Produk</span>
            </a>
        </li>

        <li class="nav-item {{ $MLaporanKaryawan ?? '' }}">
            <a class="nav-link" href="{{ route('laporan.mutasi_stok') }}">
                <i class="fas fa-fw fa-chart-bar"></i>
                <span>Laporan</span>
            </a>
        </li>
    @endif

    <!-- Divider -->\
    <hr class="sidebar-divider">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
