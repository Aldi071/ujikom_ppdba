@extends('depan.layouts.main')
@section('content')
<section class="hero">
    <div class="hero-content">
        <div class="hero-logo">
            <img
                alt="BAKNUS Logo"
                src="{{ asset('img/logo.png') }}"
                style="width: 100%; height: 100%; object-fit: contain" />
        </div>
        <h1 data-splitting="">SMK</h1>
        <h1 data-splitting="">BAKTI NUSANTARA 666</h1>
        <div class="hero-slogan">
            <span id="typed-text"></span>
        </div>
        <div class="hero-buttons">
            @auth
                <!-- Tampilan ketika sudah login -->
                <a href="/pengumuman">
                    <button class="button">
                        Lihat Pengumuman
                    </button>
                </a>
            @else
                <!-- Tampilan ketika belum login -->
                <button class="button" onclick="openModal('registerModal')">
                    Register Akun
                </button>

            <!-- MODAL REGISTER -->
            <div class="modal" id="registerModal">
                <div class="modal-content">
                    <button class="modal-close" onclick="closeModal('registerModal')">×</button>
                    <h2 style="text-align: center; margin-bottom: 25px; color: var(--primary-blue);">
                        Register Akun SPMB
                    </h2>

                    @if($errors->any())
                    <div style="background: #fee2e2; color: #dc2626; padding: 12px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #dc2626;">
                        <strong>Error:</strong>
                        @foreach($errors->all() as $error)
                        {{ $error }}@if(!$loop->last), @endif
                        @endforeach
                    </div>
                    @endif

                    @if(session('error') && !session('showOtpModal'))
                    <div style="background: #fee2e2; color: #dc2626; padding: 12px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #dc2626;">
                        {{ session('error') }}
                    </div>
                    @endif

                    <form id="registerForm">
                        @csrf
                        <div class="form-group">
                            <label for="nisn">NISN</label>
                            <input
                                id="nisn"
                                name="nisn"
                                placeholder="Masukkan NISN Anda (10 digit)"
                                required
                                type="text"
                                value="{{ old('nisn') }}"
                                pattern="[0-9]{10}"
                                title="NISN harus 10 digit angka"
                                maxlength="10" />
                            @error('nisn')
                            <span style="color: #dc2626; font-size: 0.875rem; margin-top: 5px; display: block;">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input
                                id="nama"
                                name="nama"
                                placeholder="Nama Luuu"
                                required
                                type="text"
                                value="{{ old('nama') }}" />
                            @error('nama')
                            <span style="color: #dc2626; font-size: 0.875rem; margin-top: 5px; display: block;">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email Aktif</label>
                            <input
                                id="email"
                                name="email"
                                placeholder="Masukkan email aktif"
                                required
                                type="email"
                                value="{{ old('email') }}" />
                            @error('email')
                            <span style="color: #dc2626; font-size: 0.875rem; margin-top: 5px; display: block;">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input
                                id="password"
                                name="password"
                                placeholder="Buat password (minimal 6 karakter)"
                                required
                                type="password"
                                minlength="6" />
                            @error('password')
                            <span style="color: #dc2626; font-size: 0.875rem; margin-top: 5px; display: block;">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Konfirmasi Password</label>
                            <input
                                id="password_confirmation"
                                name="password_confirmation"
                                placeholder="Ulangi password"
                                required
                                type="password" />
                        </div>
                        <div class="form-group" id="otpSectionRegister" style="display:none;">
                            <label for="otpRegister">Kode OTP</label>
                            <input id="otpRegister" name="otp" type="text" maxlength="6" placeholder="Masukkan kode OTP (6 digit)" />
                            <small style="color: gray;">Cek email kamu untuk melihat kode OTP.</small>
                        </div>
                        <button
                            class="btn btn-primary"
                            style="width: 100%; margin-top: 10px"
                            type="submit"
                            id="registerBtn">
                            Daftar Sekarang
                        </button>
                        <button
                            class="btn btn-success d-none"
                            style="width: 100%; margin-top: 10px"
                            type="button"
                            id="verifyOtpBtn">
                            Verifikasi OTP
                        </button>
                    </form>

                    <p style="text-align: center; margin-top: 15px; color: var(--text-light);">
                        Sudah punya akun?
                        <a href="#" onclick="closeModal('registerModal'); document.getElementById('login-section').scrollIntoView({behavior: 'smooth'})" style="color: var(--primary-blue); font-weight: 600">Login di sini</a>
                    </p>
                </div>
            </div>
            @endauth
            <a href="{{ route('informasi') }}">
                <button
                    class="flex justify-center gap-2 items-center mx-auto shadow-xl text-lg bg-gray-50 backdrop-blur-md lg:font-semibold isolation-auto border-gray-50 before:absolute before:w-full before:transition-all before:duration-700 before:hover:w-full before:-left-full before:hover:left-0 before:rounded-full before:bg-blue-500 hover:text-gray-50 before:-z-10 before:aspect-square before:hover:scale-150 before:hover:duration-700 relative z-10 px-4 py-2 overflow-hidden border-2 rounded-full group"
                    type="button">
                    Info SPMB
                    <svg
                        class="w-8 h-8 justify-end group-hover:rotate-90 group-hover:bg-gray-50 text-gray-50 ease-linear duration-300 rounded-full border border-gray-700 group-hover:border-none p-2 rotate-45"
                        viewbox="0 0 16 19"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            class="fill-gray-800 group-hover:fill-gray-800"
                            d="M7 18C7 18.5523 7.44772 19 8 19C8.55228 19 9 18.5523 9 18H7ZM8.70711 0.292893C8.31658 -0.0976311 7.68342 -0.0976311 7.29289 0.292893L0.928932 6.65685C0.538408 7.04738 0.538408 7.68054 0.928932 8.07107C1.31946 8.46159 1.95262 8.46159 2.34315 8.07107L8 2.41421L13.6569 8.07107C14.0474 8.46159 14.6805 8.46159 15.0711 8.07107C15.4616 7.68054 15.4616 7.04738 15.0711 6.65685L8.70711 0.292893ZM9 18L9 1H7L7 18H9Z"></path>
                    </svg>
                </button>
            </a>
        </div>
    </div>
</section>

@guest
<!-- Section Login hanya ditampilkan untuk pengguna yang belum login -->
<section class="section" id="login-section">
    <div class="container">
        <div class="form-container fade-in">
            <h2 class="section-title">Login Peserta</h2>

            @if($errors->any())
            <div style="background: #fee2e2; color: #dc2626; padding: 12px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #dc2626;">
                <strong>Error:</strong> {{ $errors->first() }}
            </div>
            @endif

            @if(session('error'))
            <div style="background: #fee2e2; color: #dc2626; padding: 12px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #dc2626;">
                {{ session('error') }}
            </div>
            @endif

            <form action="{{ route('peserta.login') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="loginEmail">Email / NISN</label>
                    <input
                        id="loginEmail"
                        name="email"
                        placeholder="Masukkan email atau NISN"
                        required
                        type="text"
                        value="{{ old('email') }}" />
                </div>
                <div class="form-group">
                    <label for="loginPassword">Password</label>
                    <input
                        id="loginPassword"
                        name="password"
                        placeholder="Masukkan password"
                        required
                        type="password" />
                </div>
                <button
                    class="btn btn-primary"
                    style="width: 100%; margin-top: 10px"
                    type="submit">
                    Login
                </button>
                <p style="text-align: center; margin-top: 15px; color: var(--text-light);">
                    Belum punya akun?
                    <a href="#" onclick="openModal('registerModal')" style="color: var(--primary-blue); font-weight: 600">Daftar Sekarang</a>
                </p>
            </form>
        </div>
    </div>
</section>
@endguest

<section class="section" style="background: var(--light-blue)">
    <div class="container">
        <h2 class="section-title fade-in">Pengumuman Terbaru</h2>
        <p
            style="
            text-align: center;
            color: var(--text-light);
            max-width: 700px;
            margin: 0 auto 40px;
          ">
            Dapatkan informasi terkini seputar kegiatan, jadwal penting, dan acara
            menarik di SMK Bakti Nusantara 666. Gunakan tombol panah untuk melihat
            pengumuman lainnya!
        </p>
        <div class="splide" id="announcement-slider">
            <div class="splide__track">
                <ul class="splide__list">
                    <li class="splide__slide">
                        <div
                            class="card fade-in"
                            style="display: flex; align-items: center; gap: 25px">
                            <div
                                style="
                      background: var(--primary-blue);
                      color: white;
                      padding: 25px;
                      border-radius: 15px;
                      text-align: center;
                      flex-shrink: 0;
                      width: 90px;
                    ">
                                <div style="font-size: 1.8rem; font-weight: bold">15</div>
                                <div>Juni</div>
                            </div>
                            <div>
                                <h3 style="color: var(--primary-blue); margin-bottom: 8px">
                                    Pembukaan SPMB 2025/2026
                                </h3>
                                <p style="color: var(--text-light); margin-bottom: 10px">
                                    Pendaftaran Peserta Didik Baru resmi dibuka! Calon siswa
                                    dapat melakukan pendaftaran secara online melalui halaman
                                    <a
                                        href="/pendaftaran"
                                        style="color: var(--primary-blue); font-weight: 600">SPMB Online</a>.
                                </p>
                                <p
                                    style="
                        font-size: 0.9rem;
                        color: var(--text-light);
                        margin-bottom: 12px;
                      ">
                                    <i class="fas fa-map-marker-alt"></i> Online melalui situs
                                    resmi sekolah
                                </p>
                                <a
                                    class="btn btn-secondary"
                                    href="/informasi#jadwal"
                                    style="padding: 8px 16px; font-size: 0.9rem">
                                    <i class="fas fa-info-circle"></i> Lihat Detail
                                </a>
                            </div>
                        </div>
                    </li>
                    <li class="splide__slide">
                        <div
                            class="card fade-in"
                            style="display: flex; align-items: center; gap: 25px">
                            <div
                                style="
                      background: var(--accent-blue);
                      color: white;
                      padding: 25px;
                      border-radius: 15px;
                      text-align: center;
                      flex-shrink: 0;
                      width: 90px;
                    ">
                                <div style="font-size: 1.8rem; font-weight: bold">20</div>
                                <div>Juni</div>
                            </div>
                            <div>
                                <h3 style="color: var(--primary-blue); margin-bottom: 8px">
                                    Info Day SMK BAKNUS 666
                                </h3>
                                <p style="color: var(--text-light); margin-bottom: 10px">
                                    Acara pengenalan sekolah, jurusan, dan program unggulan.
                                    Orang tua dan calon siswa diundang untuk hadir secara
                                    gratis!
                                </p>
                                <p
                                    style="
                        font-size: 0.9rem;
                        color: var(--text-light);
                        margin-bottom: 12px;
                      ">
                                    <i class="fas fa-map-marker-alt"></i> Aula SMK Bakti
                                    Nusantara 666
                                </p>
                                <a
                                    class="btn btn-secondary"
                                    href="/informasi#infoday"
                                    style="padding: 8px 16px; font-size: 0.9rem">
                                    <i class="fas fa-calendar-check"></i> Lihat Jadwal
                                </a>
                            </div>
                        </div>
                    </li>
                    <li class="splide__slide">
                        <div
                            class="card fade-in"
                            style="display: flex; align-items: center; gap: 25px">
                            <div
                                style="
                      background: var(--dark-blue);
                      color: white;
                      padding: 25px;
                      border-radius: 15px;
                      text-align: center;
                      flex-shrink: 0;
                      width: 90px;
                    ">
                                <div style="font-size: 1.8rem; font-weight: bold">25</div>
                                <div>Juni</div>
                            </div>
                            <div>
                                <h3 style="color: var(--primary-blue); margin-bottom: 8px">
                                    Try Out Online Gratis
                                </h3>
                                <p style="color: var(--text-light); margin-bottom: 10px">
                                    Ikuti try out online untuk mengukur kesiapan menghadapi
                                    ujian masuk. Peserta terbaik akan mendapatkan sertifikat
                                    &amp; beasiswa!
                                </p>
                                <p
                                    style="
                        font-size: 0.9rem;
                        color: var(--text-light);
                        margin-bottom: 12px;
                      ">
                                    <i class="fas fa-globe"></i> Melalui portal e-learning
                                    sekolah
                                </p>
                                <a
                                    class="btn btn-secondary"
                                    href="/pengumuman#tryout"
                                    style="padding: 8px 16px; font-size: 0.9rem">
                                    <i class="fas fa-arrow-right"></i> Daftar Sekarang
                                </a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="splide__arrows">
                <button class="splide__arrow splide__arrow--prev">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="splide__arrow splide__arrow--next">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>
</section>
<section class="section">
    <div class="container">
        <h2 class="section-title fade-in">Informasi Cepat SPMB</h2>
        <div class="card-grid">
            <div class="card fade-in">
                <div class="bg"></div>
                <div class="blob"></div>
                <div style="text-align: center; margin-bottom: 20px">
                    <i class="fas fa-calendar-alt" style="font-size: 3rem; color: var(--primary-blue); margin-bottom: 15px;"></i>
                    <h3>Jadwal Pendaftaran</h3>
                </div>
                
                @if($gelombangAktif)
                    <p style="text-align: center; color: var(--text-light)">
                        <strong>
                            {{ \Carbon\Carbon::parse($gelombangAktif->tgl_mulai)->translatedFormat('d F Y') }} - 
                            {{ \Carbon\Carbon::parse($gelombangAktif->tgl_selesai)->translatedFormat('d F Y') }}
                        </strong><br />
                        Gelombang: {{ $gelombangAktif->nama }}<br />
                        Biaya Pendaftaran: Rp {{ number_format($gelombangAktif->biaya_daftar, 0, ',', '.') }}
                    </p>
                @else
                    <p style="text-align: center; color: var(--text-light)">
                        <strong>Pendaftaran Belum Dibuka</strong><br />
                        Silakan pantau informasi terbaru di website kami.
                    </p>
                @endif
                
                <div style="text-align: center; margin-top: 20px">
                    <a class="btn btn-secondary" href="/informasi#jadwal" style="padding: 10px 20px; font-size: 0.9rem">
                        Lihat Detail
                    </a>
                </div>
            </div>
            
            <div class="card fade-in">
                <div class="bg"></div>
                <div class="blob"></div>
                <div style="text-align: center; margin-bottom: 20px">
                    <i class="fas fa-users" style="font-size: 3rem; color: var(--primary-blue); margin-bottom: 15px;"></i>
                    <h3>Kuota Tersedia</h3>
                </div>
                
                <p style="text-align: center; color: var(--text-light)">
                    <strong>{{ $kuotaTersisa }} Sisa Kuota</strong><br />
                    Dari total {{ $totalKuota }} kuota<br />
                    Terbagi dalam {{ \App\Models\Jurusan::where('aktif', 1)->count() }} jurusan
                </p>
                
                <div style="text-align: center; margin-top: 20px">
                    <a class="btn btn-secondary" href="/informasi#kuota" style="padding: 10px 20px; font-size: 0.9rem">
                        Lihat Kuota
                    </a>
                </div>
            </div>

            <!-- Card Tambahan: Jurusan Tersedia -->
            <div class="card fade-in">
                <div class="bg"></div>
                <div class="blob"></div>
                <div style="text-align: center; margin-bottom: 20px">
                    <i class="fas fa-graduation-cap" style="font-size: 3rem; color: var(--primary-blue); margin-bottom: 15px;"></i>
                    <h3>Jurusan Tersedia</h3>
                </div>
                
                <p style="text-align: center; color: var(--text-light)">
                    <strong>{{ \App\Models\Jurusan::where('aktif', 1)->count() }} Program</strong><br />
                    @foreach(\App\Models\Jurusan::where('aktif', 1)->take(3)->get() as $jurusan)
                        • {{ $jurusan->nama }} ({{ $jurusan->kuota }} kursi)<br />
                    @endforeach
                    @if(\App\Models\Jurusan::where('aktif', 1)->count() > 3)
                        • dan {{ \App\Models\Jurusan::where('aktif', 1)->count() - 3 }} lainnya
                    @endif
                </p>
                
                <div style="text-align: center; margin-top: 20px">
                    <a class="btn btn-secondary" href="/informasi#jurusan" style="padding: 10px 20px; font-size: 0.9rem">
                        Lihat Jurusan
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="section">
    <div class="container">
        <h2 class="section-title fade-in">Mengapa Memilih BAKNUS 666?</h2>
        <div class="why-choose-grid">
            <div class="fancy-card fade-in">
                <span class="icon">
                    <i class="fas fa-chalkboard-teacher"></i>
                </span>
                <h3>Guru Berkompeten</h3>
                <p>
                    Tenaga pengajar berpengalaman dan bersertifikat dengan metode
                    mengajar yang inovatif.
                </p>
                <div class="shine"></div>
                <div class="background">
                    <div class="tiles">
                        <div class="tile tile-1"></div>
                        <div class="tile tile-2"></div>
                        <div class="tile tile-3"></div>
                        <div class="tile tile-4"></div>
                        <div class="tile tile-5"></div>
                        <div class="tile tile-6"></div>
                        <div class="tile tile-7"></div>
                        <div class="tile tile-8"></div>
                        <div class="tile tile-9"></div>
                        <div class="tile tile-10"></div>
                    </div>
                    <div class="line line-1"></div>
                    <div class="line line-2"></div>
                    <div class="line line-3"></div>
                </div>
            </div>
            <div class="fancy-card fade-in">
                <span class="icon">
                    <i class="fas fa-laptop-code"></i>
                </span>
                <h3>Fasilitas Modern</h3>
                <p>
                    Laboratorium komputer, perpustakaan, dan kelas multimedia
                    yang lengkap.
                </p>
                <div class="shine"></div>
                <div class="background">
                    <div class="tiles">
                        <div class="tile tile-1"></div>
                        <div class="tile tile-2"></div>
                        <div class="tile tile-3"></div>
                        <div class="tile tile-4"></div>
                        <div class="tile tile-5"></div>
                        <div class="tile tile-6"></div>
                        <div class="tile tile-7"></div>
                        <div class="tile tile-8"></div>
                        <div class="tile tile-9"></div>
                        <div class="tile tile-10"></div>
                    </div>
                    <div class="line line-1"></div>
                    <div class="line line-2"></div>
                    <div class="line line-3"></div>
                </div>
            </div>
            <div class="fancy-card fade-in">
                <span class="icon">
                    <i class="fas fa-handshake"></i>
                </span>
                <h3>Kerja Sama Industri</h3>
                <p>
                    Program magang dan pelatihan dengan perusahaan ternama untuk
                    persiapan karir.
                </p>
                <div class="shine"></div>
                <div class="background">
                    <div class="tiles">
                        <div class="tile tile-1"></div>
                        <div class="tile tile-2"></div>
                        <div class="tile tile-3"></div>
                        <div class="tile tile-4"></div>
                        <div class="tile tile-5"></div>
                        <div class="tile tile-6"></div>
                        <div class="tile tile-7"></div>
                        <div class="tile tile-8"></div>
                        <div class="tile tile-9"></div>
                        <div class="tile tile-10"></div>
                    </div>
                    <div class="line line-1"></div>
                    <div class="line line-2"></div>
                    <div class="line line-3"></div>
                </div>
            </div>
            <div class="fancy-card fade-in">
                <span class="icon">
                    <i class="fas fa-trophy"></i>
                </span>
                <h3>Prestasi Gemilang</h3>
                <p>
                    Siswa kami berprestasi di berbagai lomba nasional.
                </p>
                <div class="shine"></div>
                <div class="background">
                    <div class="tiles">
                        <div class="tile tile-1"></div>
                        <div class="tile tile-2"></div>
                        <div class="tile tile-3"></div>
                        <div class="tile tile-4"></div>
                        <div class="tile tile-5"></div>
                        <div class="tile tile-6"></div>
                        <div class="tile tile-7"></div>
                        <div class="tile tile-8"></div>
                        <div class="tile tile-9"></div>
                        <div class="tile tile-10"></div>
                    </div>
                    <div class="line line-1"></div>
                    <div class="line line-2"></div>
                    <div class="line line-3"></div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="section">
    <div class="container">
        <h2 class="section-title fade-in">Program Unggulan</h2>
        <div class="card-grid">
            <div class="card fade-in">
                <div
                    style="
                background: linear-gradient(
                  135deg,
                  var(--primary-blue),
                  var(--dark-blue)
                );
                color: white;
                padding: 30px;
                border-radius: 15px;
                text-align: center;
                margin-bottom: 20px;
              ">
                    <i
                        class="fas fa-rocket"
                        style="font-size: 3rem; margin-bottom: 15px"></i>
                    <h3>Accelerated Learning</h3>
                </div>
                <p
                    style="
                color: var(--text-light);
                margin-bottom: 20px;
                line-height: 1.6;
              ">
                    Program akselerasi untuk siswa berprestasi dengan kurikulum yang
                    lebih intensif dan mendalam sesuai dengan minat dan bakat siswa.
                </p>
                <ul style="color: var(--text-dark); margin-bottom: 20px">
                    <li>Kelas akselerasi dengan durasi 2.5 tahun</li>
                    <li>Kurikulum yang dapat disesuaikan</li>
                    <li>Mentoring oleh praktisi industri</li>
                    <li>Sertifikasi internasional</li>
                </ul>
            </div>
            <div class="card fade-in">
                <div
                    style="
                background: linear-gradient(
                  135deg,
                  var(--accent-blue),
                  #1e40af
                );
                color: white;
                padding: 30px;
                border-radius: 15px;
                text-align: center;
                margin-bottom: 20px;
              ">
                    <i
                        class="fas fa-globe"
                        style="font-size: 3rem; margin-bottom: 15px"></i>
                    <h3>International Program</h3>
                </div>
                <p
                    style="
                color: var(--text-light);
                margin-bottom: 20px;
                line-height: 1.6;
              ">
                    Program internasional dengan pertukaran pelajar dan kurikulum yang
                    disesuaikan dengan standar global.
                </p>
                <ul style="color: var(--text-dark); margin-bottom: 20px">
                    <li>Pertukaran pelajar ke luar negeri</li>
                    <li>Kurikulum Cambridge/IB</li>
                    <li>TOEFL/IELTS preparation</li>
                    <li>University pathway program</li>
                </ul>
            </div>
            <div class="card fade-in">
                <div
                    style="
                background: linear-gradient(135deg, #059669, #047857);
                color: white;
                padding: 30px;
                border-radius: 15px;
                text-align: center;
                margin-bottom: 20px;
              ">
                    <i
                        class="fas fa-seedling"
                        style="font-size: 3rem; margin-bottom: 15px"></i>
                    <h3>Green Technology</h3>
                </div>
                <p
                    style="
                color: var(--text-light);
                margin-bottom: 20px;
                line-height: 1.6;
              ">
                    Fokus pada teknologi ramah lingkungan dan berkelanjutan dengan
                    proyek-proyek yang berdampak positif bagi lingkungan.
                </p>
                <ul style="color: var(--text-dark); margin-bottom: 20px">
                    <li>Proyek energi terbarukan</li>
                    <li>IoT untuk monitoring lingkungan</li>
                    <li>Green computing practices</li>
                    <li>Sertifikasi Adiwiyata</li>
                </ul>
            </div>
        </div>
    </div>
</section>
@endsection

<style>
  #otpSectionRegister {
    margin-top: 15px;
    display: none;
    transition: all 0.3s ease;
  }
  #otpSectionRegister input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 14px;
  }
  #otpSectionRegister small {
    display: block;
    margin-top: 4px;
    color: gray;
  }
  
  /* Loading state */
  .btn:disabled {
    opacity: 0.7;
    cursor: not-allowed;
  }
  
  .fa-spinner {
    margin-right: 8px;
  }
  
  /* Message styles */
  .message-alert {
    animation: slideDown 0.3s ease;
  }
  
  @keyframes slideDown {
    from {
      opacity: 0;
      transform: translateY(-10px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
</style>

<script>
    // Fungsi untuk membuka dan menutup modal
    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = 'block';
            document.body.style.overflow = 'hidden';

            setTimeout(() => {
                modal.classList.add('active');
            }, 10);
        }
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('active');

            setTimeout(() => {
                modal.style.display = 'none';
                document.body.style.overflow = 'auto';
                
                // Reset form ketika modal ditutup
                const form = document.getElementById('registerForm');
                if (form) {
                    form.reset();
                    document.getElementById('otpSectionRegister').style.display = 'none';
                    document.getElementById('registerBtn').classList.remove('d-none');
                    document.getElementById('verifyOtpBtn').classList.add('d-none');
                    clearMessages();
                }
            }, 300);
        }
    }

    // Tutup modal ketika klik di luar konten modal
    window.onclick = function(event) {
        if (event.target.classList.contains('modal')) {
            const modals = document.querySelectorAll('.modal');
            modals.forEach(modal => {
                if (modal.style.display === 'block') {
                    const modalId = modal.getAttribute('id');
                    closeModal(modalId);
                }
            });
        }
    }

    // Event listener untuk modal register
    document.addEventListener('DOMContentLoaded', function() {
        initializeRegisterForm();
        initializeOtpVerification();
    });

    function initializeRegisterForm() {
        const registerForm = document.getElementById('registerForm');
        if (!registerForm) return;

        registerForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            await handleRegisterSubmit();
        });
    }

    function initializeOtpVerification() {
        const verifyOtpBtn = document.getElementById('verifyOtpBtn');
        if (!verifyOtpBtn) return;

        verifyOtpBtn.addEventListener('click', async () => {
            await handleOtpVerification();
        });

        // Enter key support untuk OTP field
        const otpInput = document.getElementById('otpRegister');
        if (otpInput) {
            otpInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    handleOtpVerification();
                }
            });
        }
    }

    async function handleRegisterSubmit() {
        // Reset pesan error sebelumnya
        clearMessages();

        const formData = getFormData();
        if (!validateFormData(formData)) {
            return;
        }

        // Tampilkan loading state
        const registerBtn = document.getElementById('registerBtn');
        if (!registerBtn) return;

        const originalText = registerBtn.innerHTML;
        registerBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mendaftarkan...';
        registerBtn.disabled = true;

        try {
            const response = await fetch("{{ route('peserta.register') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(formData)
            });

            const data = await response.json();
            // Debug log removed: Register Response

            if (data.status === 'success') {
                handleRegisterSuccess(data);
            } else {
                handleRegisterError(data);
            }
        } catch (error) {
            console.error('Network Error:', error);
            showMessage('error', 'Terjadi kesalahan jaringan. Silakan coba lagi.');
        } finally {
            // Reset loading state
            registerBtn.innerHTML = originalText;
            registerBtn.disabled = false;
        }
    }

    function getFormData() {
        return {
            nisn: document.getElementById('nisn')?.value.trim() || '',
            nama: document.getElementById('nama')?.value.trim() || '',
            email: document.getElementById('email')?.value.trim() || '',
            password: document.getElementById('password')?.value || '',
            password_confirmation: document.getElementById('password_confirmation')?.value || ''
        };
    }

    function validateFormData(data) {
        // Validasi NISN
        if (!/^\d{10}$/.test(data.nisn)) {
            showMessage('error', 'NISN harus terdiri dari 10 digit angka.');
            return false;
        }

        // Validasi nama
        if (data.nama.length < 2) {
            showMessage('error', 'Nama harus diisi dengan minimal 2 karakter.');
            return false;
        }

        // Validasi email
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(data.email)) {
            showMessage('error', 'Format email tidak valid.');
            return false;
        }

        // Validasi password
        if (data.password.length < 6) {
            showMessage('error', 'Password harus minimal 6 karakter.');
            return false;
        }

        if (data.password !== data.password_confirmation) {
            showMessage('error', 'Konfirmasi password tidak sesuai.');
            return false;
        }

        return true;
    }

    function handleRegisterSuccess(data) {
    // Jika ada debug_otp, gunakan pesan yang lebih informatif
    if (data.debug_otp) {
        showMessage('success', `Pendaftaran berhasil! Kode OTP: <strong>${data.debug_otp}</strong>. Silakan masukkan kode ini untuk verifikasi.`);
    } else {
        showMessage('success', data.message);
    }
    
    // Tampilkan kolom OTP dan tombol verifikasi
    const otpSection = document.getElementById('otpSectionRegister');
    const registerBtn = document.getElementById('registerBtn');
    const verifyOtpBtn = document.getElementById('verifyOtpBtn');
    
    if (otpSection) otpSection.style.display = 'block';
    if (registerBtn) registerBtn.classList.add('d-none');
    if (verifyOtpBtn) verifyOtpBtn.classList.remove('d-none');

    // Auto focus ke field OTP
    setTimeout(() => {
        const otpInput = document.getElementById('otpRegister');
        if (otpInput) {
            otpInput.focus();
            // Jika ada debug_otp, auto-fill OTP untuk kemudahan development
            if (data.debug_otp) {
                otpInput.value = data.debug_otp;
            }
        }
    }, 100);
}

    function handleRegisterError(data) {
        showMessage('error', data.message || 'Terjadi kesalahan saat mendaftar.');
        
        // Tampilkan error validasi jika ada
        if (data.errors) {
            Object.keys(data.errors).forEach(field => {
                const errorElement = document.querySelector(`[name="${field}"]`);
                if (errorElement) {
                    const errorSpan = document.createElement('span');
                    errorSpan.style.color = '#dc2626';
                    errorSpan.style.fontSize = '0.875rem';
                    errorSpan.style.marginTop = '5px';
                    errorSpan.style.display = 'block';
                    errorSpan.textContent = data.errors[field][0];
                    errorSpan.className = 'field-error';
                    errorElement.parentNode.appendChild(errorSpan);
                }
            });
        }
    }

    async function handleOtpVerification() {
        const email = document.getElementById('email')?.value;
        const otp = document.getElementById('otpRegister')?.value;

        if (!email) {
            showMessage('error', 'Email tidak ditemukan. Silakan daftar ulang.');
            return;
        }

        if (!otp || !/^\d{6}$/.test(otp)) {
            showMessage('error', 'Masukkan kode OTP 6 digit yang valid.');
            return;
        }

        // Tampilkan loading state
        const verifyBtn = document.getElementById('verifyOtpBtn');
        if (!verifyBtn) return;

        const originalText = verifyBtn.innerHTML;
        verifyBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memverifikasi...';
        verifyBtn.disabled = true;

        try {
            const response = await fetch("{{ route('peserta.verifyOtp') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    email: email,
                    otp: otp
                })
            });

            const data = await response.json();
            // Debug log removed: OTP Verification Response

            if (data.status === 'success') {
                handleOtpSuccess(data);
            } else {
                handleOtpError(data);
            }
        } catch (error) {
            console.error('Network Error:', error);
            showMessage('error', 'Terjadi kesalahan jaringan. Silakan coba lagi.');
        } finally {
            // Reset loading state
            verifyBtn.innerHTML = originalText;
            verifyBtn.disabled = false;
        }
    }

    function handleOtpSuccess(data) {
        showMessage('success', data.message);
        
        // Redirect setelah 2 detik
        setTimeout(() => {
            if (data.redirect) {
                window.location.href = data.redirect;
            } else {
                closeModal('registerModal');
                // Reset form
                const form = document.getElementById('registerForm');
                if (form) form.reset();
            }
        }, 2000);
    }

    function handleOtpError(data) {
        showMessage('error', data.message || 'Terjadi kesalahan saat verifikasi OTP.');
        
        // Clear OTP field jika error
        const otpInput = document.getElementById('otpRegister');
        if (otpInput) otpInput.value = '';
    }

    // Fungsi untuk menampilkan pesan
    function showMessage(type, message) {
        clearMessages();
        
        const messageDiv = document.createElement('div');
        messageDiv.style.padding = '12px';
        messageDiv.style.borderRadius = '8px';
        messageDiv.style.marginBottom = '20px';
        messageDiv.style.borderLeft = '4px solid';
        messageDiv.style.animation = 'slideDown 0.3s ease';
        
        if (type === 'success') {
            messageDiv.style.background = '#d1fae5';
            messageDiv.style.color = '#065f46';
            messageDiv.style.borderLeftColor = '#10b981';
        } else {
            messageDiv.style.background = '#fee2e2';
            messageDiv.style.color = '#dc2626';
            messageDiv.style.borderLeftColor = '#dc2626';
        }
        
        messageDiv.innerHTML = `<strong>${type === 'success' ? 'Sukses!' : 'Error!'}</strong> ${message}`;
        messageDiv.className = 'message-alert';
        
        // Sisipkan pesan di atas form
        const form = document.getElementById('registerForm');
        if (form) {
            const firstChild = form.firstChild;
            form.insertBefore(messageDiv, firstChild);
            
            // Auto hide pesan sukses setelah 5 detik
            if (type === 'success') {
                setTimeout(() => {
                    if (messageDiv.parentNode) {
                        messageDiv.remove();
                    }
                }, 5000);
            }
        }
    }

    // Fungsi untuk menghapus pesan sebelumnya
    function clearMessages() {
        // Hapus message alert
        const existingMessages = document.querySelectorAll('.message-alert');
        existingMessages.forEach(msg => msg.remove());
        
        // Hapus error message dari validasi
        const errorSpans = document.querySelectorAll('.field-error');
        errorSpans.forEach(span => span.remove());
    }

    // Prevent form submission dengan Enter key di field yang tidak diinginkan
    document.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            const activeElement = document.activeElement;
            if (activeElement.tagName === 'INPUT' && 
                activeElement.type !== 'submit' && 
                !activeElement.id.includes('otp')) {
                e.preventDefault();
            }
        }
    });
</script>