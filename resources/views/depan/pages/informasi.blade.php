@extends('depan.layouts.main')
@section('content')
<section class="hero">
    <div class="hero-content">
        <h1 data-splitting>Informasi SPMB 2025/2026</h1>
        <p style="font-size: 1.2rem; color: var(--white-blue); margin-top: 20px;">
            Semua informasi yang Anda butuhkan untuk mendaftar di BAKNUS 666
        </p>
        
        <!-- Countdown Container -->
        <div id="countdownContainer" style="margin-top: 30px;">
            <div id="countdown">
                <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
                    <div class="countdown-item">
                        <div class="countdown-number" id="days">00</div>
                        <div class="countdown-label">Hari</div>
                    </div>
                    <div class="countdown-item">
                        <div class="countdown-number" id="hours">00</div>
                        <div class="countdown-label">Jam</div>
                    </div>
                    <div class="countdown-item">
                        <div class="countdown-number" id="minutes">00</div>
                        <div class="countdown-label">Menit</div>
                    </div>
                    <div class="countdown-item">
                        <div class="countdown-number" id="seconds">00</div>
                        <div class="countdown-label">Detik</div>
                    </div>
                </div>
                <p style="margin-top: 15px; color: var(--text-light); font-size: 0.9rem;">
                    Menuju pembukaan pendaftaran: 15 Juni 2025
                </p>
            </div>
            
            <!-- Tampilan ketika pendaftaran dibuka -->
            <div id="registrationOpen" style="display: none;">
                <div class="registration-open-banner">
                    <div class="banner-content">
                        <div class="banner-icon">
                            <i class="fas fa-rocket"></i>
                        </div>
                        <div class="banner-text">
                            <h3 class="banner-title">PENDAFTARAN TELAH DIBUKA!</h3>
                            <p class="banner-subtitle">Jangan lewatkan kesempatan untuk bergabung dengan BAKNUS 666</p>
                        </div>
                        <div class="banner-actions">
                            <a href="/pendaftaran" class="btn btn-primary btn-large pulse-animation">
                                <i class="fas fa-pencil-alt"></i> Daftar Sekarang
                            </a>
                            <a href="#jadwal" class="btn btn-outline-white">
                                <i class="fas fa-calendar-alt"></i> Lihat Jadwal
                            </a>
                        </div>
                    </div>
                    <div class="banner-decoration">
                        <div class="decoration-item"></div>
                        <div class="decoration-item"></div>
                        <div class="decoration-item"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Jadwal SPMB - DIPERBAIKI MENJADI ALUR -->
<section class="section section-gradient" id="jadwal">
    <div class="section-divider"></div>
    <div class="container">
        <h2 class="section-title fade-in">Alur Pelaksanaan SPMB</h2>
        <div class="card fade-in" style="max-width: 1000px; margin: 0 auto; position: relative; overflow: hidden;">
            <div class="process-timeline">
                <div class="process-step">
                    <div class="step-icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <div class="step-content">
                        <h3>Pendaftaran Online</h3>
                        <div class="step-date">15 Juni - 15 Juli 2025</div>
                        <p>Periode pendaftaran peserta didik baru melalui sistem online</p>
                        <div class="step-note">
                            <i class="fas fa-info-circle"></i>
                            Pendaftaran ditutup otomatis saat kuota terpenuhi
                        </div>
                    </div>
                </div>

                <div class="process-step">
                    <div class="step-icon">
                        <i class="fas fa-file"></i>
                    </div>
                    <div class="step-content">
                        <h3>Verifikasi Berkas</h3>
                        <div class="step-date">16 - 20 Juli 2025</div>
                        <p>Proses verifikasi kelengkapan berkas dan data pendaftaran</p>
                        <div class="step-note">
                            <i class="fas fa-bell"></i>
                            Hasil diumumkan via email dan dashboard peserta
                        </div>
                    </div>
                </div>

                <div class="process-step">
                    <div class="step-icon">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <div class="step-content">
                        <h3>Seleksi Administrasi</h3>
                        <div class="step-date">21 - 25 Juli 2025</div>
                        <p>Seleksi berdasarkan dokumen dan persyaratan yang telah ditetapkan</p>
                        <div class="step-note">
                            <i class="fas fa-star"></i>
                            Kriteria: Nilai rapor, sertifikat prestasi, dokumen pendukung
                        </div>
                    </div>
                </div>

                <div class="process-step">
                    <div class="step-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="step-content">
                        <h3>Seleksi Akademik & Wawancara</h3>
                        <div class="step-date">26 - 30 Juli 2025</div>
                        <p>Tes akademik untuk semua jalur kecuali zonasi, plus wawancara untuk jalur prestasi</p>
                        <div class="step-note">
                            <i class="fas fa-map-marker-alt"></i>
                            Lokasi: BAKNUS 666 Campus | Waktu: 08.00 - 15.00 WIB
                        </div>
                    </div>
                </div>

                <div class="process-step">
                    <div class="step-icon">
                        <i class="fas fa-bullhorn"></i>
                    </div>
                    <div class="step-content">
                        <h3>Pengumuman Hasil Seleksi</h3>
                        <div class="step-date">2 Agustus 2025</div>
                        <p>Pengumuman peserta yang diterima melalui website resmi</p>
                        <div class="step-note">
                            <i class="fas fa-laptop"></i>
                            Akses: Dashboard peserta dengan nomor pendaftaran
                        </div>
                    </div>
                </div>

                <div class="process-step">
                    <div class="step-icon">
                        <i class="fas fa-clipboard-check"></i>
                    </div>
                    <div class="step-content">
                        <h3>Daftar Ulang</h3>
                        <div class="step-date">3 - 7 Agustus 2025</div>
                        <p>Proses administrasi kelengkapan pendaftaran ulang untuk siswa yang diterima</p>
                        <div class="step-note">
                            <i class="fas fa-file-alt"></i>
                            Dokumen: Surat pernyataan, formulir kesehatan, pembayaran
                        </div>
                    </div>
                </div>

                <div class="process-step">
                    <div class="step-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="step-content">
                        <h3>Orientasi Siswa Baru</h3>
                        <div class="step-date">12 - 14 Agustus 2025</div>
                        <p>Kegiatan pengenalan lingkungan sekolah dan program orientasi</p>
                        <div class="step-note">
                            <i class="fas fa-tasks"></i>
                            Kegiatan: Campus tour, perkenalan guru, pembagian seragam
                        </div>
                    </div>
                </div>

                <div class="process-step">
                    <div class="step-icon">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <div class="step-content">
                        <h3>Mulai Kegiatan Belajar</h3>
                        <div class="step-date">18 Agustus 2025</div>
                        <p>Hari pertama kegiatan belajar mengajar untuk tahun ajaran 2025/2026</p>
                        <div class="step-note">
                            <i class="fas fa-chalkboard-teacher"></i>
                            Program: Pembagian kelas, pengenalan kurikulum, target belajar
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Syarat Pendaftaran -->
<section class="section" style="background: linear-gradient(135deg, var(--light-blue) 0%, var(--white-blue) 100%);" id="syarat">
    <div class="container">
        <h2 class="section-title fade-in">Syarat Pendaftaran</h2>
        <div class="card-grid">
            <div class="card fade-in">
                <div style="text-align: center; margin-bottom: 20px;">
                    <i class="fas fa-user-graduate" style="font-size: 3rem; color: var(--primary-blue); margin-bottom: 15px;"></i>
                    <h3>Persyaratan Umum</h3>
                </div>
                <ul style="list-style: none; padding: 0;">
                    <li style="margin: 10px 0; padding-left: 25px; position: relative;">
                        <i class="fas fa-check-circle" style="position: absolute; left: 0; top: 2px; color: var(--primary-blue);"></i>
                        Lulusan SMP/MTs atau sederajat tahun 2025
                    </li>
                    <li style="margin: 10px 0; padding-left: 25px; position: relative;">
                        <i class="fas fa-check-circle" style="position: absolute; left: 0; top: 2px; color: var(--primary-blue);"></i>
                        Usia maksimal 18 tahun per 1 Juli 2025
                    </li>
                    <li style="margin: 10px 0; padding-left: 25px; position: relative;">
                        <i class="fas fa-check-circle" style="position: absolute; left: 0; top: 2px; color: var(--primary-blue);"></i>
                        Sehat jasmani dan rohani
                    </li>
                    <li style="margin: 10px 0; padding-left: 25px; position: relative;">
                        <i class="fas fa-check-circle" style="position: absolute; left: 0; top: 2px; color: var(--primary-blue);"></i>
                        Tidak buta warna (untuk jurusan tertentu)
                    </li>
                    <li style="margin: 10px 0; padding-left: 25px; position: relative;">
                        <i class="fas fa-check-circle" style="position: absolute; left: 0; top: 2px; color: var(--primary-blue);"></i>
                        Memiliki NISN (Nomor Induk Siswa Nasional)
                    </li>
                </ul>
            </div>

            <div class="card fade-in">
                <div style="text-align: center; margin-bottom: 20px;">
                    <i class="fas fa-file-alt" style="font-size: 3rem; color: var(--primary-blue); margin-bottom: 15px;"></i>
                    <h3>Dokumen yang Harus Dipersiapkan</h3>
                </div>
                <ul style="list-style: none; padding: 0;">
                    <li style="margin: 10px 0; padding-left: 25px; position: relative;">
                        <i class="fas fa-file-pdf" style="position: absolute; left: 0; top: 2px; color: var(--primary-blue);"></i>
                        Fotokopi Ijazah SMP/MTs (legalisir)
                    </li>
                    <li style="margin: 10px 0; padding-left: 25px; position: relative;">
                        <i class="fas fa-file-pdf" style="position: absolute; left: 0; top: 2px; color: var(--primary-blue);"></i>
                        Fotokopi SKHUN/SHUN (legalisir)
                    </li>
                    <li style="margin: 10px 0; padding-left: 25px; position: relative;">
                        <i class="fas fa-file-pdf" style="position: absolute; left: 0; top: 2px; color: var(--primary-blue);"></i>
                        Fotokopi Kartu Keluarga (KK)
                    </li>
                    <li style="margin: 10px 0; padding-left: 25px; position: relative;">
                        <i class="fas fa-file-pdf" style="position: absolute; left: 0; top: 2px; color: var(--primary-blue);"></i>
                        Fotokopi Akta Kelahiran
                    </li>
                    <li style="margin: 10px 0; padding-left: 25px; position: relative;">
                        <i class="fas fa-file-pdf" style="position: absolute; left: 0; top: 2px; color: var(--primary-blue);"></i>
                        Pas foto 3x4 (4 lembar) dan 4x6 (2 lembar)
                    </li>
                    <li style="margin: 10px 0; padding-left: 25px; position: relative;">
                        <i class="fas fa-file-pdf" style="position: absolute; left: 0; top: 2px; color: var(--primary-blue);"></i>
                        Rapor kelas VII dan VIII (semester 1-5)
                    </li>
                    <li style="margin: 10px 0; padding-left: 25px; position: relative;">
                        <i class="fas fa-file-pdf" style="position: absolute; left: 0; top: 2px; color: var(--primary-blue);"></i>
                        Surat keterangan sehat dari dokter
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Jalur Pendaftaran -->
<section class="section section-gradient">
    <div class="container">
        <h2 class="section-title fade-in">Jalur Pendaftaran</h2>
        <div class="card-grid">
            <div class="card-enhanced fade-in" style="border-top-color: var(--primary-blue);">
                <div style="display: flex; align-items: center; margin-bottom: 20px;">
                    <div style="background: var(--primary-blue); color: white; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 15px;">
                        <span style="font-weight: bold; font-size: 1.2rem;">1</span>
                    </div>
                    <div>
                        <h3 style="color: var(--primary-blue); margin: 0;">Jalur Zonasi</h3>
                        <small style="color: var(--text-light);">40% dari kuota</small>
                    </div>
                </div>
                <div style="margin-bottom: 15px;">
                    <h4 style="color: var(--text-dark); margin-bottom: 10px;">Kriteria:</h4>
                    <ul style="margin: 0; padding-left: 20px;">
                        <li>Domisili dalam radius 5 km dari sekolah</li>
                        <li>Nilai rapor minimal 75 untuk semua mata pelajaran</li>
                        <li>Urutan berdasarkan jarak tempuh</li>
                    </ul>
                </div>
            </div>

            <div class="card-enhanced fade-in" style="border-top-color: var(--accent-blue);">
                <div style="display: flex; align-items: center; margin-bottom: 20px;">
                    <div style="background: var(--accent-blue); color: white; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 15px;">
                        <span style="font-weight: bold; font-size: 1.2rem;">2</span>
                    </div>
                    <div>
                        <h3 style="color: var(--accent-blue); margin: 0;">Jalur Prestasi</h3>
                        <small style="color: var(--text-light);">30% dari kuota</small>
                    </div>
                </div>
                <div style="margin-bottom: 15px;">
                    <h4 style="color: var(--text-dark); margin-bottom: 10px;">Kriteria:</h4>
                    <ul style="margin: 0; padding-left: 20px;">
                        <li>Juara lomba minimal tingkat kabupaten</li>
                        <li>Bidang: Olimpiade, seni, olahraga, keagamaan</li>
                        <li>Wawancara dan presentasi prestasi</li>
                    </ul>
                </div>
            </div>

            <div class="card-enhanced fade-in" style="border-top-color: var(--dark-blue);">
                <div style="display: flex; align-items: center; margin-bottom: 20px;">
                    <div style="background: var(--dark-blue); color: white; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 15px;">
                        <span style="font-weight: bold; font-size: 1.2rem;">3</span>
                    </div>
                    <div>
                        <h3 style="color: var(--dark-blue); margin: 0;">Jalur Afirmasi</h3>
                        <small style="color: var(--text-light);">20% dari kuota</small>
                    </div>
                </div>
                <div style="margin-bottom: 15px;">
                    <h4 style="color: var(--text-dark); margin-bottom: 10px;">Kriteria:</h4>
                    <ul style="margin: 0; padding-left: 20px;">
                        <li>Penghasilan orang tua ≤ UMR</li>
                        <li>Kartu PKH/KKS/KIP</li>
                        <li>Surat keterangan tidak mampu dari kelurahan</li>
                    </ul>
                </div>
            </div>

            <div class="card-enhanced fade-in" style="border-top-color: #059669;">
                <div style="display: flex; align-items: center; margin-bottom: 20px;">
                    <div style="background: #059669; color: white; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 15px;">
                        <span style="font-weight: bold; font-size: 1.2rem;">4</span>
                    </div>
                    <div>
                        <h3 style="color: #059669; margin: 0;">Jalur Mutasi</h3>
                        <small style="color: var(--text-light);">10% dari kuota</small>
                    </div>
                </div>
                <div style="margin-bottom: 15px;">
                    <h4 style="color: var(--text-dark); margin-bottom: 10px;">Kriteria:</h4>
                    <ul style="margin: 0; padding-left: 20px;">
                        <li>Pindahan dari sekolah lain</li>
                        <li>Alasan mutasi: perpindahan orang tua</li>
                        <li>Surat rekomendari dari sekolah asal</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Kuota Per Jurusan - DATA DINAMIS DARI DATABASE -->
<section class="section" style="background: linear-gradient(135deg, var(--light-blue) 0%, var(--white-blue) 100%);" id="kuota">
    <div class="container">
        <h2 class="section-title fade-in">Kuota per Jurusan</h2>
        <div class="card fade-in" style="max-width: 900px; margin: 0 auto;">
            <div class="table-responsive">
                <table class="quota-table">
                    <thead>
                        <tr>
                            <th>Jurusan</th>
                            <th>Kelas</th>
                            <th>Kuota Total</th>
                            <th>Terisi</th>
                            <th>Sisa Kuota</th>
                        </tr>
                    </thead>
                    <tbody id="kuotaTableBody">
                        <!-- Data akan diisi oleh JavaScript -->
                    </tbody>
                </table>
            </div>
            <div style="margin-top: 25px; text-align: center; padding-top: 20px; border-top: 1px solid rgba(59, 130, 246, 0.2);">
                <p style="color: var(--text-light); font-size: 0.9rem;">
                    <i class="fas fa-info-circle" style="margin-right: 5px;"></i>
                    Data terakhir diperbarui: <span id="lastUpdate">{{ date('d F Y') }}</span>
                </p>
                <div style="display: flex; justify-content: center; gap: 20px; margin-top: 15px; flex-wrap: wrap;">
                    <div style="display: flex; align-items: center; gap: 5px;">
                        <div style="width: 12px; height: 12px; background: #10b981; border-radius: 2px;"></div>
                        <span style="font-size: 0.8rem;">Tersedia (>50%)</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 5px;">
                        <div style="width: 12px; height: 12px; background: #f59e0b; border-radius: 2px;"></div>
                        <span style="font-size: 0.8rem;">Sedang (25-50%)</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 5px;">
                        <div style="width: 12px; height: 12px; background: #ef4444; border-radius: 2px;"></div>
                        <span style="font-size: 0.8rem;">Hampir Penuh (<25%)</span>
                    </div>
                </div>
                <button onclick="refreshKuotaData()" class="btn btn-outline" style="margin-top: 15px; padding: 8px 16px; font-size: 0.9rem;">
                    <i class="fas fa-sync-alt"></i> Perbarui Data
                </button>
            </div>
        </div>
    </div>
</section>

<!-- Alur Pendaftaran - DIPERBAIKI DESAIN -->
<section class="section section-gradient">
    <div class="container">
        <h2 class="section-title fade-in">Alur Pendaftaran</h2>
        <div class="card fade-in" style="max-width: 1000px; margin: 0 auto;">
            <div class="registration-flow">
                <div class="flow-step">
                    <div class="flow-number">1</div>
                    <div class="flow-icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <div class="flow-content">
                        <h4>Registrasi Akun</h4>
                        <p>Buat akun pendaftaran dengan email dan NISN</p>
                    </div>
                    <div class="flow-arrow">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>

                <div class="flow-step">
                    <div class="flow-number">2</div>
                    <div class="flow-icon">
                        <i class="fas fa-edit"></i>
                    </div>
                    <div class="flow-content">
                        <h4>Isi Formulir</h4>
                        <p>Lengkapi data pribadi, sekolah asal, dan orang tua</p>
                    </div>
                    <div class="flow-arrow">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>

                <div class="flow-step">
                    <div class="flow-number">3</div>
                    <div class="flow-icon">
                        <i class="fas fa-upload"></i>
                    </div>
                    <div class="flow-content">
                        <h4>Upload Berkas</h4>
                        <p>Upload dokumen pendukung dan pas foto</p>
                    </div>
                    <div class="flow-arrow">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>

                <div class="flow-step">
                    <div class="flow-number">4</div>
                    <div class="flow-icon">
                        <i class="fas fa-route"></i>
                    </div>
                    <div class="flow-content">
                        <h4>Pilih Jalur</h4>
                        <p>Pilih jalur pendaftaran dan jurusan yang diinginkan</p>
                    </div>
                    <div class="flow-arrow">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>

                <div class="flow-step">
                    <div class="flow-number">5</div>
                    <div class="flow-icon">
                        <i class="fas fa-paper-plane"></i>
                    </div>
                    <div class="flow-content">
                        <h4>Kirim & Bayar</h4>
                        <p>Kirim formulir dan lakukan pembayaran biaya pendaftaran</p>
                    </div>
                </div>
            </div>

            <div style="text-align: center; margin-top: 40px; padding-top: 30px; border-top: 2px dashed var(--primary-blue);">
                <a href="/pendaftaran" class="btn btn-primary" style="font-size: 1.1rem; padding: 15px 30px;">
                    <i class="fas fa-rocket"></i> Mulai Pendaftaran Sekarang
                </a>
            </div>
        </div>
    </div>
</section>

<style>
/* Registration Open Banner Styles */
.registration-open-banner {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    border-radius: 20px;
    padding: 40px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 20px 40px rgba(16, 185, 129, 0.3);
    border: 2px solid rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    animation: slideInUp 0.8s ease-out;
}

.banner-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 30px;
    position: relative;
    z-index: 2;
}

.banner-icon {
    font-size: 4rem;
    color: white;
    animation: bounce 2s infinite;
}

.banner-text {
    flex: 1;
    text-align: center;
}

.banner-title {
    font-size: 2.5rem;
    font-weight: bold;
    color: white;
    margin: 0 0 10px 0;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
    animation: pulse 2s infinite;
}

.banner-subtitle {
    font-size: 1.2rem;
    color: rgba(255, 255, 255, 0.9);
    margin: 0;
}

.banner-actions {
    display: flex;
    flex-direction: column;
    gap: 15px;
    min-width: 200px;
}

.btn-large {
    padding: 15px 25px;
    font-size: 1.1rem;
    font-weight: bold;
    border-radius: 50px;
    text-decoration: none;
    text-align: center;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
}

.btn-outline-white {
    background: transparent;
    color: white;
    border: 2px solid white;
    padding: 12px 20px;
    border-radius: 50px;
    text-decoration: none;
    text-align: center;
    transition: all 0.3s ease;
    font-weight: 600;
}

.btn-outline-white:hover {
    background: white;
    color: #059669;
    transform: translateY(-2px);
}

/* Banner Decoration */
.banner-decoration {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
}

.decoration-item {
    position: absolute;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    animation: float 6s infinite ease-in-out;
}

.decoration-item:nth-child(1) {
    width: 80px;
    height: 80px;
    top: -20px;
    right: 10%;
    animation-delay: 0s;
}

.decoration-item:nth-child(2) {
    width: 60px;
    height: 60px;
    bottom: -15px;
    left: 15%;
    animation-delay: 2s;
}

.decoration-item:nth-child(3) {
    width: 40px;
    height: 40px;
    top: 50%;
    right: -10px;
    animation-delay: 4s;
}

/* Quick Info Grid */
.quick-info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-top: 30px;
}

.quick-info-item {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 15px;
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 15px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: transform 0.3s ease;
}

.quick-info-item:hover {
    transform: translateY(-5px);
}

.quick-info-item i {
    font-size: 2rem;
    color: white;
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
}

.quick-info-content {
    display: flex;
    flex-direction: column;
}

.quick-info-number {
    font-size: 1.8rem;
    font-weight: bold;
    color: white;
    line-height: 1;
}

.quick-info-label {
    font-size: 0.9rem;
    color: rgba(255, 255, 255, 0.8);
    margin-top: 5px;
}

/* Animations */
@keyframes pulse {
    0% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.05);
    }
    100% {
        transform: scale(1);
    }
}

@keyframes bounce {
    0%, 20%, 50%, 80%, 100% {
        transform: translateY(0);
    }
    40% {
        transform: translateY(-10px);
    }
    60% {
        transform: translateY(-5px);
    }
}

@keyframes float {
    0%, 100% {
        transform: translateY(0) rotate(0deg);
    }
    33% {
        transform: translateY(-20px) rotate(120deg);
    }
    66% {
        transform: translateY(10px) rotate(240deg);
    }
}

@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.pulse-animation {
    animation: pulse 2s infinite;
    box-shadow: 0 10px 25px rgba(255, 255, 255, 0.3);
}

/* Countdown Styles Update */
.countdown-item {
    text-align: center;
    padding: 20px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 15px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    min-width: 100px;
    transition: transform 0.3s ease;
}

.countdown-item:hover {
    transform: translateY(-5px);
    background: rgba(255, 255, 255, 0.15);
}

.countdown-number {
    font-size: 2.5rem;
    font-weight: bold;
    color: white;
    margin-bottom: 5px;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
}

.countdown-label {
    font-size: 0.9rem;
    color: var(--white-blue);
    text-transform: uppercase;
    letter-spacing: 1px;
    font-weight: 600;
}

/* Responsive Design */
@media (max-width: 768px) {
    .banner-content {
        flex-direction: column;
        text-align: center;
        gap: 20px;
    }
    
    .banner-title {
        font-size: 2rem;
    }
    
    .banner-icon {
        font-size: 3rem;
    }
    
    .banner-actions {
        flex-direction: row;
        justify-content: center;
        flex-wrap: wrap;
    }
    
    .quick-info-grid {
        grid-template-columns: 1fr;
    }
    
    .countdown-item {
        padding: 15px;
        min-width: 80px;
    }
    
    .countdown-number {
        font-size: 2rem;
    }
}

@media (max-width: 480px) {
    .registration-open-banner {
        padding: 25px 20px;
    }
    
    .banner-title {
        font-size: 1.5rem;
    }
    
    .banner-subtitle {
        font-size: 1rem;
    }
    
    .countdown-item {
        padding: 10px;
        min-width: 70px;
    }
    
    .countdown-number {
        font-size: 1.5rem;
    }
}

    /* Loading and Animation Styles */
.alert {
    padding: 1rem 1.5rem;
    border-radius: 10px;
    margin-bottom: 1rem;
    border-left: 4px solid;
    animation: slideInRight 0.3s ease-out;
}

.alert-success {
    background: #f0fdf4;
    border-color: #10b981;
    color: #065f46;
}

.alert-danger {
    background: #fef2f2;
    border-color: #ef4444;
    color: #7f1d1d;
}

.alert-info {
    background: #eff6ff;
    border-color: #3b82f6;
    color: #1e3a8a;
}

.alert-warning {
    background: #fffbeb;
    border-color: #f59e0b;
    color: #92400e;
}

@keyframes slideInRight {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

/* Table animations */
.quota-table tbody tr {
    transition: all 0.3s ease;
}

.quota-table tbody tr:hover {
    background: rgba(59, 130, 246, 0.05) !important;
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

/* Countdown styles */
.countdown-item {
    text-align: center;
    padding: 15px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 10px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.countdown-number {
    font-size: 2rem;
    font-weight: bold;
    color: white;
    margin-bottom: 5px;
}

.countdown-label {
    font-size: 0.9rem;
    color: var(--white-blue);
    text-transform: uppercase;
    letter-spacing: 1px;
}

/* Responsive table */
@media (max-width: 768px) {
    .table-responsive {
        overflow-x: auto;
    }
    
    .quota-table {
        min-width: 600px;
    }
    
    .countdown-item {
        padding: 10px;
    }
    
    .countdown-number {
        font-size: 1.5rem;
    }
}

</style>

<script>
    // Data jurusan dan ikon
    const jurusanIcons = {
        'TKJ': 'fa-network-wired',
        'RPL': 'fa-laptop-code',
        'TEI': 'fa-bolt',
        'TKR': 'fa-car',
        'TBSM': 'fa-motorcycle',
        'TOTAL': 'fa-school'
    };

    // Load data kuota dari server
    async function loadKuotaData() {
        try {
            showLoading('kuotaTableBody', 'Memuat data kuota...');
            
            const response = await fetch('{{ route("informasi.kuota") }}');
            const data = await response.json();

            if (data.success) {
                renderKuotaTable(data.data, data.total);
                document.getElementById('lastUpdate').textContent = new Date().toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                });
            } else {
                showError('kuotaTableBody', 'Gagal memuat data kuota');
            }
        } catch (error) {
            console.error('Error loading kuota data:', error);
            showError('kuotaTableBody', 'Terjadi kesalahan saat memuat data');
        }
    }

    // Render tabel kuota
    function renderKuotaTable(kuotaData, totalData) {
        const tbody = document.getElementById('kuotaTableBody');
        
        if (!kuotaData || kuotaData.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="5" style="padding: 40px; text-align: center; color: var(--text-light);">
                        <i class="fas fa-info-circle" style="font-size: 2rem; margin-bottom: 10px;"></i><br>
                        Belum ada data kuota tersedia
                    </td>
                </tr>
            `;
            return;
        }

        let html = '';

        // Render data per jurusan
        kuotaData.forEach((item, index) => {
            const isTotal = item.kode === 'TOTAL';
            const icon = jurusanIcons[item.kode] || 'fa-book';
            const warnaTerisi = getWarnaKuota(item.persentase);
            
            html += `
                <tr ${isTotal ? 'style="background: rgba(219, 234, 254, 0.5);"' : ''}>
                    <td class="jurusan-name" ${isTotal ? 'style="font-weight: bold; font-size: 1.1rem;"' : ''}>
                        <i class="fas ${icon}" style="margin-right: 8px; color: var(--primary-blue);"></i>
                        ${item.nama}
                    </td>
                    <td class="text-center" ${isTotal ? 'style="font-weight: bold;"' : ''}>
                        ${item.kelas}
                    </td>
                    <td class="text-center quota-total" ${isTotal ? 'style="font-size: 1.2rem;"' : ''}>
                        ${item.kuota_total}
                    </td>
                    <td class="text-center">
                        <span class="quota-filled" style="background: ${warnaTerisi};">${item.terisi}</span>
                    </td>
                    <td class="text-center">
                        <span class="quota-available" style="background: ${getWarnaSisaKuota(item.persentase)};">${item.sisa}</span>
                    </td>
                </tr>
            `;
        });

        // Tambahkan baris total
        if (totalData) {
            html += `
                <tr style="background: rgba(16, 185, 129, 0.1); border-top: 2px solid var(--primary-blue);">
                    <td class="jurusan-name" style="font-weight: bold; font-size: 1.1rem;">
                        <i class="fas fa-school" style="margin-right: 8px; color: var(--primary-blue);"></i>
                        TOTAL
                    </td>
                    <td class="text-center" style="font-weight: bold;">
                        ${Math.ceil(totalData.kuota_total / 36)}
                    </td>
                    <td class="text-center quota-total" style="font-size: 1.2rem;">
                        ${totalData.kuota_total}
                    </td>
                    <td class="text-center">
                        <span class="quota-filled" style="background: var(--primary-blue);">
                            ${totalData.terisi}
                        </span>
                    </td>
                    <td class="text-center">
                        <span class="quota-available" style="background: #10b981;">
                            ${totalData.sisa}
                        </span>
                    </td>
                </tr>
            `;
        }

        tbody.innerHTML = html;
        
        // Animate table rows
        animateTableRows();
    }

    // Tentukan warna berdasarkan persentase kuota terisi
    function getWarnaKuota(persentase) {
        if (persentase < 25) return '#10b981';      // Hijau - masih banyak
        if (persentase < 50) return '#f59e0b';      // Kuning - sedang
        if (persentase < 75) return '#fb923c';      // Oranye - hampir penuh
        return '#ef4444';                           // Merah - penuh
    }

    // Tentukan warna untuk sisa kuota (kebalikan dari terisi)
    function getWarnaSisaKuota(persentase) {
        const sisaPersentase = 100 - persentase;
        return getWarnaKuota(sisaPersentase);
    }

    // Tampilkan loading
    function showLoading(elementId, message = 'Memuat...') {
        const element = document.getElementById(elementId);
        element.innerHTML = `
            <tr>
                <td colspan="5" style="padding: 40px; text-align: center; color: var(--text-light);">
                    <i class="fas fa-spinner fa-spin" style="font-size: 2rem; margin-bottom: 10px;"></i><br>
                    ${message}
                </td>
            </tr>
        `;
    }

    // Tampilkan error
    function showError(elementId, message) {
        const element = document.getElementById(elementId);
        element.innerHTML = `
            <tr>
                <td colspan="5" style="padding: 40px; text-align: center; color: #ef4444;">
                    <i class="fas fa-exclamation-triangle" style="font-size: 2rem; margin-bottom: 10px;"></i><br>
                    ${message}
                </td>
            </tr>
        `;
    }

    // Refresh data kuota
    function refreshKuotaData() {
        loadKuotaData();
        showNotification('Data kuota diperbarui', 'success');
    }

    // Animate table rows
    function animateTableRows() {
        const rows = document.querySelectorAll('#kuotaTableBody tr');
        rows.forEach((row, index) => {
            row.style.opacity = '0';
            row.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                row.style.transition = 'all 0.5s ease';
                row.style.opacity = '1';
                row.style.transform = 'translateY(0)';
            }, index * 100);
        });
    }

    // Notification function
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `alert alert-${type === 'error' ? 'danger' : type === 'success' ? 'success' : 'info'}`;
        notification.innerHTML = `
            <i class="fas fa-${getNotificationIcon(type)}"></i> 
            ${message}
            <button onclick="this.parentElement.remove()" style="float: right; background: none; border: none; cursor: pointer;">
                <i class="fas fa-times"></i>
            </button>
        `;

        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 10000;
            min-width: 300px;
            max-width: 500px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        `;

        document.body.appendChild(notification);

        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 5000);
    }

    function getNotificationIcon(type) {
        const icons = {
            success: 'check-circle',
            error: 'exclamation-triangle',
            warning: 'exclamation-circle',
            info: 'info-circle'
        };
        return icons[type] || 'info-circle';
    }

    // Initialize when page loads
    document.addEventListener('DOMContentLoaded', function() {
        // Load kuota data
        loadKuotaData();
        
        // Set auto refresh every 2 minutes
        setInterval(loadKuotaData, 120000);
        
        // Existing countdown and animation code
        initializeScrollEffects();
        updateCountdown();
        setInterval(updateCountdown, 1000);
        
        if (document.querySelector('[data-splitting]')) {
            Splitting();
            anime({
                targets: '[data-splitting] .char',
                translateY: [100, 0],
                opacity: [0, 1],
                easing: 'easeOutExpo',
                duration: 1400,
                delay: (el, i) => 30 * i
            });
        }
    });

    // Countdown Timer dengan fitur pendaftaran dibuka
    function updateCountdown() {
        const targetDate = new Date('June 15, 2025 00:00:00').getTime();
        const now = new Date().getTime();
        const distance = targetDate - now;

        const countdownElement = document.getElementById('countdown');
        const registrationOpenElement = document.getElementById('registrationOpen');

        // Jika countdown selesai, tampilkan banner pendaftaran dibuka
        if (distance < 0) {
            countdownElement.style.display = 'none';
            registrationOpenElement.style.display = 'block';
            
            // Load data real-time
            loadRegistrationStats();
            
            // Set auto-refresh untuk data real-time
            if (!window.statsInterval) {
                window.statsInterval = setInterval(loadRegistrationStats, 30000); // Refresh setiap 30 detik
            }
            
            return;
        }

        // Tampilkan countdown normal
        countdownElement.style.display = 'block';
        registrationOpenElement.style.display = 'none';

        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        document.getElementById('days').textContent = days.toString().padStart(2, '0');
        document.getElementById('hours').textContent = hours.toString().padStart(2, '0');
        document.getElementById('minutes').textContent = minutes.toString().padStart(2, '0');
        document.getElementById('seconds').textContent = seconds.toString().padStart(2, '0');
        
        // Update hari tersisa untuk quick info
        document.getElementById('daysLeft').textContent = days;
    }

    // Load registration statistics
    async function loadRegistrationStats() {
        try {
            // Untuk demo, kita gunakan data statis
            // Dalam implementasi real, ini akan fetch dari API
            const totalPendaftar = Math.floor(Math.random() * 100) + 150; // Random untuk demo
            const kuotaTersedia = 240 - totalPendaftar;
            
            // Animate numbers
            animateNumber('totalPendaftar', totalPendaftar);
            animateNumber('kuotaTersedia', kuotaTersedia > 0 ? kuotaTersedia : 0);
            
        } catch (error) {
            console.error('Error loading registration stats:', error);
            // Fallback values
            document.getElementById('totalPendaftar').textContent = '168';
            document.getElementById('kuotaTersedia').textContent = '72';
        }
    }

    // Animate number counting
    function animateNumber(elementId, targetNumber) {
        const element = document.getElementById(elementId);
        const currentNumber = parseInt(element.textContent) || 0;
        const duration = 1000; // 1 second
        const steps = 60;
        const stepTime = duration / steps;
        const increment = (targetNumber - currentNumber) / steps;
        
        let current = currentNumber;
        let step = 0;
        
        const timer = setInterval(() => {
            current += increment;
            step++;
            
            if (step >= steps) {
                element.textContent = targetNumber.toLocaleString();
                clearInterval(timer);
            } else {
                element.textContent = Math.floor(current).toLocaleString();
            }
        }, stepTime);
    }

    // Initialize when page loads
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize countdown
        updateCountdown();
        setInterval(updateCountdown, 1000);
        
        // Load initial data jika pendaftaran sudah dibuka
        if (new Date() >= new Date('June 15, 2025 00:00:00')) {
            loadRegistrationStats();
        }

        // Existing animations
        initializeScrollEffects();
        
        if (document.querySelector('[data-splitting]')) {
            Splitting();
            anime({
                targets: '[data-splitting] .char',
                translateY: [100, 0],
                opacity: [0, 1],
                easing: 'easeOutExpo',
                duration: 1400,
                delay: (el, i) => 30 * i
            });
        }
    });

    // Existing scroll animations function
    function initializeScrollEffects() {
        const fadeElements = document.querySelectorAll('.fade-in');
        const appearOptions = {
            threshold: 0.1,
            rootMargin: "0px 0px -50px 0px"
        };

        const appearOnScroll = new IntersectionObserver(function(entries, observer) {
            entries.forEach(entry => {
                if (!entry.isIntersecting) return;
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            });
        }, appearOptions);

        fadeElements.forEach(element => {
            appearOnScroll.observe(element);
        });

        // Smooth scroll for navigation
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    }
</script>
@endsection