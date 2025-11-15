<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('kepsek.dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">PPDB System</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->is('kepsek/dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('kepsek.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Nav Item - Hasil Seleksi -->
<li class="nav-item {{ request()->is('kepsek/hasil-seleksi') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('kepsek.hasil-seleksi') }}">
        <i class="fas fa-fw fa-chart-bar"></i>
        <span>Hasil Seleksi</span>
    </a>
</li>

<!-- Nav Item - Peta Sebaran -->
<li class="nav-item {{ request()->is('kepsek/peta-sebaran') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('kepsek.peta-sebaran') }}">
        <i class="fas fa-fw fa-map"></i>
        <span>Peta Sebaran</span>
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