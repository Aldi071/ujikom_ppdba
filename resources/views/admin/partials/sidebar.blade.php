<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-university"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Admin SPMB</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Master Data
    </div>

    <!-- Nav Item - Master Data Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMaster"
            aria-expanded="true" aria-controls="collapseMaster">
            <i class="fas fa-fw fa-database"></i>
            <span>Master Data</span>
        </a>
        <div id="collapseMaster" class="collapse" aria-labelledby="headingMaster" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Data Referensi:</h6>
                <a class="collapse-item {{ request()->routeIs('admin.master.jurusan*') ? 'active' : '' }}" href="{{ route('admin.master.jurusan') }}">Jurusan</a>
                <a class="collapse-item {{ request()->routeIs('admin.master.gelombang*') ? 'active' : '' }}" href="{{ route('admin.master.gelombang') }}">Gelombang</a>
                <a class="collapse-item {{ request()->routeIs('admin.master.wilayah*') ? 'active' : '' }}" href="{{ route('admin.master.wilayah') }}">Wilayah</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Monitoring Pendaftar -->
    <li class="nav-item {{ request()->routeIs('admin.monitoring.pendaftar.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.monitoring.pendaftar.index') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Monitoring Pendaftar</span>
        </a>
    </li>

    <!-- Nav Item - Peta Sebaran -->
    <li class="nav-item {{ request()->routeIs('admin.peta.sebaran.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.peta.sebaran.index') }}">
            <i class="fas fa-fw fa-map"></i>
            <span>Peta Sebaran</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Laporan
    </div>

    <!-- Nav Item - Laporan Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLaporan"
            aria-expanded="true" aria-controls="collapseLaporan">
            <i class="fas fa-fw fa-file-alt"></i>
            <span>Laporan Otomatis</span>
        </a>
        <div id="collapseLaporan" class="collapse" aria-labelledby="headingLaporan" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Jenis Laporan:</h6>
                <a class="collapse-item {{ request()->routeIs('admin.laporan.pendaftar') ? 'active' : '' }}" href="{{ route('admin.laporan.pendaftar') }}">Laporan Pendaftar</a>
                <a class="collapse-item {{ request()->routeIs('admin.laporan.keuangan') ? 'active' : '' }}" href="{{ route('admin.laporan.keuangan') }}">Laporan Keuangan</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Manajemen Akun -->
    <li class="nav-item {{ request()->routeIs('admin.akun.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.akun.index') }}">
            <i class="fas fa-fw fa-user-cog"></i>
            <span>Manajemen Akun</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->