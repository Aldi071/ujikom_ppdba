{{-- resources/views/keuangan/partials/sidebar.blade.php --}}
<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('keuangan.dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Keuangan <sup>PPDB</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->routeIs('keuangan.dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('keuangan.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Interface
    </div>

    <li class="nav-item {{ request()->routeIs('keuangan.validasi.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('keuangan.validasi.index') }}">
            <i class="fas fa-fw fa-check-circle"></i>
            <span>Validasi Bukti</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('keuangan.laporan*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('keuangan.laporan') }}">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Laporan</span>
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