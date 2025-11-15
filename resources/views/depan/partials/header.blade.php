<nav class="navbar">
  <div class="navbar-container">
    <div class="navbar-logo">
      <img alt="BAKNUS 666 Logo" src="{{ asset('img/logo.png') }}" />
      <div class="navbar-text">
        <h2>SMK BAKTI NUSANTARA 666</h2>
        <p>Santun, Jujur, Taat</p>
      </div>
    </div>
    <button class="navbar-toggle" id="navbarToggle">
      <i class="fas fa-bars"></i>
    </button>
    <div class="navbar-pill">
      <div class="navbar-nav">
        <a class="active" href="/">Beranda</a>
        <div class="dropdown">
          <a class="dropbtn" href="{{ route('akademik') }}">Profil Sekolah ▾</a>
          <div class="dropdown-content">
            <div class="dropdown-section">
              <a href="{{ url('/akademik#identitas') }}">🔹Identitas &amp; Umum</a>
              <a href="{{ url('/akademik#akademik') }}">🔹Akademik &amp; Kejuruan</a>
              <a href="{{ url('/akademik#fasilitas') }}">🔹Fasilitas &amp; Layanan</a>
            </div>
          </div>
        </div>
        <a href="{{ route('informasi') }}">Info SPMB</a>
        <a href="{{ route('pendaftaran') }}">Daftar</a>
        <a href="{{ route('pengumuman') }}">Pengumuman</a>
        <a href="{{ route('kontak') }}">Kontak</a>
      </div>
    </div>
    <div class="navbar-search">
      @auth
      <div class="dropdown">
        <a class="dropbtn user-profile" href="#" style="display: flex; align-items: center; gap: 8px;">
          <i class="fas fa-user-circle" style="font-size: 1.2rem;"></i>
          {{ Auth::user()->nama }}
          <i class="fas fa-chevron-down" style="font-size: 0.8rem;"></i>
        </a>
        <div class="dropdown-content">
          <div class="dropdown-section">
            <a href="#" style="pointer-events: none; color: var(--text-light);">
              <small>Logged in as {{ Auth::user()->role }}</small>
            </a>
            <div class="dropdown-divider"></div>
            @if(Auth::user()->role === 'pendaftar')
            <a href="{{ route('dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            @else
            <a href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            @endif
            <form action="{{ 
                        Auth::user()->role === 'pendaftar' ? route('peserta.logout') : route('admin.logout') 
                    }}" method="POST" id="logout-form" style="display: none;">
              @csrf
            </form>
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              <i class="fas fa-sign-out-alt"></i> Logout
            </a>
          </div>
        </div>
      </div>
      @else
      <div style="display: flex; align-items: center; gap: 15px;">
        <a href="{{ url('/#login-section') }}" class="login-button">
          <i class="fas fa-sign-in-alt"></i> Login Peserta
        </a>
        <span style="color: var(--text-light);">|</span>
        <a href="{{ route('admin.login') }}" style="color: var(--primary-blue); text-decoration: none; font-size: 0.9rem;">
          <i class="fas fa-users-cog"></i> Staff/Admin
        </a>
      </div>
      @endauth
    </div>
  </div>

  <!-- Mobile Menu -->
  <div class="mobile-menu" id="mobileMenu">
    <a class="active" href="/">Beranda</a>
    <div class="dropdown">
      <a class="dropbtn" href="{{ route('akademik') }}">Profil Sekolah ▾</a>
      <div class="dropdown-content">
        <div class="dropdown-section">
          <a href="{{ url('/akademik#identitas') }}">🔹Identitas &amp; Umum</a>
          <a href="{{ url('/akademik#akademik') }}">🔹Akademik &amp; Kejuruan</a>
          <a href="{{ url('/akademik#fasilitas') }}">🔹Fasilitas &amp; Layanan</a>
        </div>
      </div>
    </div>
    <a href="{{ route('informasi') }}">Info SPMB</a>
    <a href="{{ route('pendaftaran') }}">Daftar</a>
    <a href="{{ route('pengumuman') }}">Pengumuman</a>
    <a href="{{ route('kontak') }}">Kontak</a>

    @auth
    <div class="mobile-user-info">
      <p style="color: var(--primary-blue); font-weight: 600; margin: 10px 0 5px 0;">
        <i class="fas fa-user"></i> {{ Auth::user()->nama }}
      </p>
      <p style="color: var(--text-light); font-size: 0.8rem; margin-bottom: 10px;">
        {{ Auth::user()->role }}
      </p>
      @if(Auth::user()->role === 'pendaftar')
      <a href="{{ route('dashboard') }}" style="display: block; padding: 8px 0;">
        <i class="fas fa-tachometer-alt"></i> Dashboard
      </a>
      @else
      <a href="{{ route('admin.dashboard') }}" style="display: block; padding: 8px 0;">
        <i class="fas fa-tachometer-alt"></i> Dashboard
      </a>
      @endif
      <form action="{{ 
                    Auth::user()->role === 'pendaftar' ? route('peserta.logout') : route('admin.logout') 
                }}" method="POST">
        @csrf
        <button type="submit" style="background: none; border: none; color: var(--text-dark); padding: 8px 0; width: 100%; text-align: left; cursor: pointer;">
          <i class="fas fa-sign-out-alt"></i> Logout
        </button>
      </form>
    </div>
    @endauth
  </div>
</nav>