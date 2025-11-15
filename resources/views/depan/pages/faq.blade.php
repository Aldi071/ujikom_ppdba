@extends('depan.layouts.main')
@section('content')
<section class="hero" style="padding: 120px 0 60px;">
    <div class="hero-content">
        <h1>FAQ - Pertanyaan Umum</h1>
        <p style="font-size: 1.2rem; color: var(--text-light); margin-top: 20px;">
            Temukan jawaban atas pertanyaan seputar SPMB BAKNUS 666 2025/2026
        </p>
    </div>
</section>

<!-- Search FAQ -->
<section class="section">
    <div class="container">
        <div class="search-faq">
            <div style="position: relative;">
                <input type="text" id="faqSearch" placeholder="Cari pertanyaan..." style="width: 100%; padding: 15px 50px 15px 20px; border: 2px solid rgba(59, 130, 246, 0.2); border-radius: 25px; font-size: 1rem;">
                <i class="fas fa-search" style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%); color: var(--primary-blue);"></i>
            </div>
            <div style="text-align: center; margin-top: 15px;">
                <small style="color: var(--text-light);">
                    <i class="fas fa-info-circle"></i> Ketik kata kunci untuk mencari pertanyaan
                </small>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Content -->
<section class="section" style="background: var(--light-blue); padding-top: 40px;">
    <div class="container">
        <div id="faqContent">
            <!-- Pendaftaran -->
            <div class="faq-category">
                <h3><i class="fas fa-user-plus"></i> Pendaftaran</h3>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <div>
                            <strong>Bagaimana cara mendaftar SPMB BAKNUS 666 2025/2026?</strong>
                        </div>
                        <i class="fas fa-chevron-down faq-icon"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Proses pendaftaran dilakukan secara online melalui website resmi kami. Berikut langkah-langkahnya:</p>
                        <ol style="margin: 15px 0; padding-left: 20px;">
                            <li>Kunjungi website SPMB BAKNUS 666</li>
                            <li>Buat akun dengan email dan NISN</li>
                            <li>Isi formulir pendaftaran lengkap</li>
                            <li>Upload berkas yang diperlukan</li>
                            <li>Pilih jalur pendaftaran dan jurusan</li>
                            <li>Kirim pendaftaran dan simpan bukti</li>
                        </ol>
                        <p>Pastikan semua data diisi dengan benar dan lengkap sebelum mengirimkan pendaftaran.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <div>
                            <strong>Apakah bisa mendaftar secara offline/datang langsung ke sekolah?</strong>
                        </div>
                        <i class="fas fa-chevron-down faq-icon"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Untuk SPMB tahun 2025/2026, semua pendaftaran dilakukan secara online melalui sistem kami. Hal ini bertujuan untuk:</p>
                        <ul style="margin: 15px 0; padding-left: 20px;">
                            <li>Mempermudah akses bagi calon siswa dari berbagai wilayah</li>
                            <li>Mempercepat proses pendaftaran dan seleksi</li>
                            <li>Mengurangi antrian dan kerumunan di sekolah</li>
                            <li>Memastikan data tersimpan dengan aman dan terintegrasi</li>
                        </ul>
                        <p>Jika mengalami kesulitan dalam proses pendaftaran online, silakan hubungi tim bantuan kami melalui WhatsApp atau telepon.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <div>
                            <strong>Berapa biaya pendaftaran SPMB BAKNUS 666?</strong>
                        </div>
                        <i class="fas fa-chevron-down faq-icon"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Biaya pendaftaran SPMB BAKNUS 666 2025/2026 adalah:</p>
                        <div style="overflow-x: auto;">
                            <table>
                                <tr>
                                    <th>Jenis Biaya</th>
                                    <th>Jumlah</th>
                                </tr>
                                <tr>
                                    <td>Biaya Pendaftaran</td>
                                    <td>Rp 500.000</td>
                                </tr>
                                <tr>
                                    <td>Biaya Seragam</td>
                                    <td>Rp 1.200.000</td>
                                </tr>
                                <tr>
                                    <td>Biaya Buku Paket</td>
                                    <td>Rp 800.000</td>
                                </tr>
                                <tr>
                                    <td>Biaya Alat Praktik</td>
                                    <td>Rp 1.500.000</td>
                                </tr>
                                <tr style="font-weight: bold; background: var(--light-blue);">
                                    <td>Total Biaya Awal</td>
                                    <td>Rp 4.000.000</td>
                                </tr>
                            </table>
                        </div>
                        <p style="margin-top: 10px;"><em>Catatan: Biaya dapat diangsur dalam 2 kali pembayaran</em></p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <div>
                            <strong>Apa yang harus dilakukan jika lupa nomor pendaftaran?</strong>
                        </div>
                        <i class="fas fa-chevron-down faq-icon"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Jika Anda lupa nomor pendaftaran, beberapa cara dapat dilakukan:</p>
                        <ol style="margin: 15px 0; padding-left: 20px;">
                            <li><strong>Cek Email:</strong> Nomor pendaftaran dikirim ke email saat registrasi</li>
                            <li><strong>Cetak Ulang Bukti:</strong> Login ke dashboard dan cetak ulang bukti pendaftaran</li>
                            <li><strong>Hubungi Admin:</strong> Screenshot bukti transfer atau data pendaftaran</li>
                            <li><strong>WhatsApp Bantuan:</strong> Kirim NISN dan nama lengkap ke nomor bantuan</li>
                        </ol>
                        <p>Untuk keamanan, pastikan Anda menyimpan bukti pendaftaran dengan baik.</p>
                    </div>
                </div>
            </div>

            <!-- Persyaratan -->
            <div class="faq-category">
                <h3><i class="fas fa-clipboard-check"></i> Persyaratan & Dokumen</h3>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <div>
                            <strong>Apa saja dokumen yang harus dipersiapkan untuk pendaftaran?</strong>
                        </div>
                        <i class="fas fa-chevron-down faq-icon"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Berikut dokumen yang harus dipersiapkan:</p>
                        <h4 style="color: var(--primary-blue); margin: 15px 0 10px 0;">Dokumen Wajib:</h4>
                        <ul style="margin: 10px 0; padding-left: 20px;">
                            <li>Fotokopi Ijazah SMP/MTs (legalisir)</li>
                            <li>Fotokopi SKHUN/SHUN (legalisir)</li>
                            <li>Fotokopi Kartu Keluarga (KK)</li>
                            <li>Fotokopi Akta Kelahiran</li>
                            <li>Pas foto 3x4 (4 lembar) dan 4x6 (2 lembar)</li>
                            <li>Rapor kelas VII dan VIII (semester 1-5)</li>
                            <li>Surat keterangan sehat dari dokter</li>
                        </ul>
                        
                        <h4 style="color: var(--primary-blue); margin: 15px 0 10px 0;">Dokumen Tambahan (Jika Ada):</h4>
                        <ul style="margin: 10px 0; padding-left: 20px;">
                            <li>Sertifikat prestasi/olahraga/keagamaan</li>
                            <li>Kartu PKH/KKS/KIP (untuk jalur afirmasi)</li>
                            <li>Surat keterangan tidak mampu</li>
                        </ul>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <div>
                            <strong>Apakah siswa pindahan bisa mendaftar di BAKNUS 666?</strong>
                        </div>
                        <i class="fas fa-chevron-down faq-icon"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Ya, BAKNUS 666 menerima siswa pindahan melalui jalur mutasi dengan ketentuan:</p>
                        <ul style="margin: 15px 0; padding-left: 20px;">
                            <li>Pindahan untuk kelas X dan XI</li>
                            <li>Alasan pindah karena perpindahan orang tua</li>
                            <li>Membawa surat rekomendari dari sekolah asal</li>
                            <li>Menyerahkan rapor dari sekolah sebelumnya</li>
                            <li>Mengikuti tes penempatan untuk menyesuaikan kurikulum</li>
                        </ul>
                        <p>Kuota untuk jalur mutasi adalah 10% dari total kuota dengan kuota maksimal 24 siswa per tahun.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <div>
                            <strong>Bagaimana jika nilai rapor tidak mencapai standar minimal?</strong>
                        </div>
                        <i class="fas fa-chevron-down faq-icon"></i>
                    </div>
                    <div class="faq-answer">
                        <p>BAKNUS 666 menetapkan standar minimal nilai rapor sebagai berikut:</p>
                        <ul style="margin: 15px 0; padding-left: 20px;">
                            <li><strong>Nilai minimal:</strong> 75 untuk semua mata pelajaran</li>
                            <li><strong>Nilai rata-rata:</strong> Minimal 80</li>
                        </ul>
                        <p>Jika nilai tidak memenuhi standar:</p>
                        <ol style="margin: 15px 0; padding-left: 20px;">
                            <li>Masih bisa mendaftar melalui jalur afirmasi jika memenuhi kriteria</li>
                            <li>Menunggu hasil seleksi akhir (jika kuota belum terpenuhi)</li>
                            <li>Mengikuti program remedial yang disediakan sekolah</li>
                        </ol>
                        <p>Setiap kasus akan dievaluasi secara individual oleh tim seleksi.</p>
                    </div>
                </div>
            </div>

            <!-- Jalur Pendaftaran -->
            <div class="faq-category">
                <h3><i class="fas fa-route"></i> Jalur Pendaftaran</h3>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <div>
                            <strong>Apa perbedaan antara jalur zonasi, prestasi, afirmasi, dan mutasi?</strong>
                        </div>
                        <i class="fas fa-chevron-down faq-icon"></i>
                    </div>
                    <div class="faq-answer">
                        <div class="grid-cards">
                            <div class="grid-card">
                                <h5 style="color: var(--primary-blue); margin-bottom: 10px;">Jalur Zonasi (40%)</h5>
                                <p style="font-size: 0.9rem;">Untuk siswa yang berdomisili dalam radius 5 km dari sekolah</p>
                            </div>
                            <div class="grid-card">
                                <h5 style="color: var(--accent-blue); margin-bottom: 10px;">Jalur Prestasi (30%)</h5>
                                <p style="font-size: 0.9rem;">Untuk siswa berprestasi di bidang akademik, seni, atau olahraga</p>
                            </div>
                            <div class="grid-card">
                                <h5 style="color: #059669; margin-bottom: 10px;">Jalur Afirmasi (20%)</h5>
                                <p style="font-size: 0.9rem;">Untuk siswa dari keluarga tidak mampu dengan kartu PKH/KKS</p>
                            </div>
                            <div class="grid-card">
                                <h5 style="color: #dc2626; margin-bottom: 10px;">Jalur Mutasi (10%)</h5>
                                <p style="font-size: 0.9rem;">Untuk siswa pindahan dari sekolah lain</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <div>
                            <strong>Bagaimana sistem penilaian untuk jalur prestasi?</strong>
                        </div>
                        <i class="fas fa-chevron-down faq-icon"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Sistem penilaian jalur prestasi menggunakan komponen sebagai berikut:</p>
                        <div style="overflow-x: auto; margin: 15px 0;">
                            <table>
                                <tr>
                                    <th>Komponen</th>
                                    <th>Bobot</th>
                                    <th>Keterangan</th>
                                </tr>
                                <tr>
                                    <td>Nilai Rapor</td>
                                    <td>40%</td>
                                    <td>Rata-rata nilai semester 1-5</td>
                                </tr>
                                <tr>
                                    <td>Prestasi</td>
                                    <td>35%</td>
                                    <td>Sertifikat lomba (minimal kabupaten)</td>
                                </tr>
                                <tr>
                                    <td>Tes Akademik</td>
                                    <td>15%</td>
                                    <td>Tes kemampuan dasar</td>
                                </tr>
                                <tr>
                                    <td>Wawancara</td>
                                    <td>10%</td>
                                    <td>Presentasi dan tanya jawab</td>
                                </tr>
                            </table>
                        </div>
                        <p>Kriteria prestasi yang diakui minimal juara tingkat kabupaten dalam bidang akademik, seni, olahraga, atau keagamaan.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <div>
                            <strong>Bisa kah saya mendaftar di lebih dari satu jalur?</strong>
                        </div>
                        <i class="fas fa-chevron-down faq-icon"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Setiap calon siswa HANYA boleh mendaftar melalui SATU jalur pendaftaran. Hal ini untuk:</p>
                        <ul style="margin: 15px 0; padding-left: 20px;">
                            <li>Menjamin keadilan dan transparansi proses seleksi</li>
                            <li>Memudahkan pengelolaan data dan kuota</li>
                            <li>Mencegah manipulasi data ganda</li>
                            <li>Memastikan sistem berjalan dengan optimal</li>
                        </ul>
                        <p>Jika tidak diterima di jalur yang dipilih, Anda tidak bisa mendaftar ulang di jalur lain dalam tahun ajaran yang sama. Namun, Anda bisa mencoba lagi tahun depan.</p>
                    </div>
                </div>
            </div>

            <!-- Jurusan & Kurikulum -->
            <div class="faq-category">
                <h3><i class="fas fa-graduation-cap"></i> Jurusan & Kurikulum</h3>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <div>
                            <strong>Apa saja jurusan yang tersedia di BAKNUS 666?</strong>
                        </div>
                        <i class="fas fa-chevron-down faq-icon"></i>
                    </div>
                    <div class="faq-answer">
                        <p>BAKNUS 666 menyediakan 3 jurusan unggulan yang sesuai dengan kebutuhan industri:</p>
                        
                        <div style="margin: 15px 0;">
                            <h4 style="color: var(--primary-blue); margin-bottom: 10px;">1. Teknik Komputer dan Jaringan (TKJ)</h4>
                            <ul style="margin: 10px 0; padding-left: 20px;">
                                <li>Perakitan dan instalasi komputer</li>
                                <li>Jaringan komputer dan server</li>
                                <li>Keamanan sistem dan data</li>
                                <li>Cloud computing dan virtualisasi</li>
                            </ul>
                            <p style="margin: 10px 0; color: var(--text-light);"><strong>Kuota:</strong> 120 siswa (3 kelas)</p>
                        </div>
                        
                        <div style="margin: 15px 0;">
                            <h4 style="color: var(--accent-blue); margin-bottom: 10px;">2. Rekayasa Perangkat Lunak (RPL)</h4>
                            <ul style="margin: 10px 0; padding-left: 20px;">
                                <li>Pemrograman web dan mobile</li>
                                <li>Database dan sistem informasi</li>
                                <li>UI/UX design</li>
                                <li>Artificial Intelligence dan Machine Learning</li>
                            </ul>
                            <p style="margin: 10px 0; color: var(--text-light);"><strong>Kuota:</strong> 80 siswa (2 kelas)</p>
                        </div>
                        
                        <div style="margin: 15px 0;">
                            <h4 style="color: #059669; margin-bottom: 10px;">3. Teknik Elektronika Industri (TEI)</h4>
                            <ul style="margin: 10px 0; padding-left: 20px;">
                                <li>Perancangan sistem elektronika</li>
                                <li>Mikrokontroler dan IoT</li>
                                <li>Robotika dan automation</li>
                                <li>Sistem kontrol industri</li>
                            </ul>
                            <p style="margin: 10px 0; color: var(--text-light);"><strong>Kuota:</strong> 40 siswa (1 kelas)</p>
                        </div>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <div>
                            <strong>Apakah bisa mengganti jurusan setelah diterima?</strong>
                        </div>
                        <i class="fas fa-chevron-down faq-icon"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Penggantian jurusan memungkinkan dengan ketentuan sebagai berikut:</p>
                        
                        <h4 style="color: var(--primary-blue); margin: 15px 0 10px 0;">Masa Orientasi Siswa (MOS):</h4>
                        <ul style="margin: 10px 0; padding-left: 20px;">
                            <li>Penggantian jurusan masih dimungkinkan</li>
                            <li>Harus mengikuti tes penempatan ulang</li>
                            <li>Kuota jurusan tujuan harus tersedia</li>
                            <li>Memerlukan persetujuan orang tua dan sekolah</li>
                        </ul>
                        
                        <h4 style="color: var(--primary-blue); margin: 15px 0 10px 0;">Setelah MOS:</h4>
                        <ul style="margin: 10px 0; padding-left: 20px;">
                            <li>Penggantian jurusan tidak diperbolehkan</li>
                            <li>Keputusan bersifat final</li>
                            <li>Siswa diharapkan fokus pada jurusan yang dipilih</li>
                        </ul>
                        
                        <p style="background: #fef3c7; padding: 15px; border-radius: 8px; margin: 15px 0; border-left: 4px solid #f59e0b;">
                            <strong>Tips:</strong> Pilih jurusan sesuai minat dan bakat Anda. Konsultasikan dengan guru BK atau orang tua sebelum memutuskan.
                        </p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <div>
                            <strong>Bagaimana sistem pembelajaran di BAKNUS 666?</strong>
                        </div>
                        <i class="fas fa-chevron-down faq-icon"></i>
                    </div>
                    <div class="faq-answer">
                        <p>BAKNUS 666 menerapkan sistem pembelajaran modern dengan konsep:</p>
                        
                        <h4 style="color: var(--primary-blue); margin: 15px 0 10px 0;">1. Blended Learning</h4>
                        <ul style="margin: 10px 0; padding-left: 20px;">
                            <li>Kombinasi pembelajaran tatap muka dan online</li>
                            <li>Menggunakan Learning Management System (LMS)</li>
                            <li>Akses materi dan tugas kapan saja</li>
                        </ul>
                        
                        <h4 style="color: var(--primary-blue); margin: 15px 0 10px 0;">2. Project-Based Learning</h4>
                        <ul style="margin: 10px 0; padding-left: 20px;">
                            <li>Siswa mengerjakan proyek nyata dari industri</li>
                            <li>Mengembangkan kemampuan problem-solving</li>
                            <li>Mempersiapkan untuk dunia kerja</li>
                        </ul>
                        
                        <h4 style="color: var(--primary-blue); margin: 15px 0 10px 0;">3. Industry Collaboration</h4>
                        <ul style="margin: 10px 0; padding-left: 20px;">
                            <li>Kerja sama dengan perusahaan teknologi</li>
                            <li>Magang dan pelatihan industri</li>
                            <li>Sertifikasi kompetensi</li>
                        </ul>
                        
                        <h4 style="color: var(--primary-blue); margin: 15px 0 10px 0;">4. Character Building</h4>
                        <ul style="margin: 10px 0; padding-left: 20px;">
                            <li>Pengembangan karakter dan soft skills</li>
                            <li>Kegiatan sosial dan komunitas</li>
                            <li>Bimbingan karir dan konseling</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Fasilitas & Layanan -->
            <div class="faq-category">
                <h3><i class="fas fa-building"></i> Fasilitas & Layanan</h3>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <div>
                            <strong>Apa saja fasilitas yang tersedia di BAKNUS 666?</strong>
                        </div>
                        <i class="fas fa-chevron-down faq-icon"></i>
                    </div>
                    <div class="faq-answer">
                        <p>BAKNUS 666 dilengkapi dengan fasilitas modern untuk mendukung pembelajaran:</p>
                        
                        <div class="grid-cards">
                            <div class="grid-card">
                                <h5 style="color: var(--primary-blue); margin-bottom: 10px;">
                                    <i class="fas fa-desktop"></i> Laboratorium Komputer
                                </h5>
                                <ul style="margin: 0; padding-left: 20px; font-size: 0.9rem;">
                                    <li>50 unit komputer high-spec</li>
                                    <li>Internet fiber optic 100 Mbps</li>
                                    <li>Software terbaru dan licensed</li>
                                </ul>
                            </div>
                            
                            <div class="grid-card">
                                <h5 style="color: var(--primary-blue); margin-bottom: 10px;">
                                    <i class="fas fa-book"></i> Perpustakaan Digital
                                </h5>
                                <ul style="margin: 0; padding-left: 20px; font-size: 0.9rem;">
                                    <li>10.000+ koleksi digital</li>
                                    <li>Akses jurnal internasional</li>
                                    <li>Area baca nyaman dengan AC</li>
                                </ul>
                            </div>
                            
                            <div class="grid-card">
                                <h5 style="color: var(--primary-blue); margin-bottom: 10px;">
                                    <i class="fas fa-microscope"></i> Laboratorium Sains
                                </h5>
                                <ul style="margin: 0; padding-left: 20px; font-size: 0.9rem;">
                                    <li>Lab Fisika, Kimia, Biologi</li>
                                    <li>Peralatan modern dan lengkap</li>
                                    <li>Standar keamanan internasional</li>
                                </ul>
                            </div>
                            
                            <div class="grid-card">
                                <h5 style="color: var(--primary-blue); margin-bottom: 10px;">
                                    <i class="fas fa-tools"></i> Workshop Teknik
                                </h5>
                                <ul style="margin: 0; padding-left: 20px; font-size: 0.9rem;">
                                    <li>Mesin dan alat praktik modern</li>
                                    <li>Area praktik yang luas</li>
                                    <li>Instructor berpengalaman</li>
                                </ul>
                            </div>
                            
                            <div class="grid-card">
                                <h5 style="color: var(--primary-blue); margin-bottom: 10px;">
                                    <i class="fas fa-theater-masks"></i> Aula Multifungsi
                                </h5>
                                <ul style="margin: 0; padding-left: 20px; font-size: 0.9rem;">
                                    <li>Kapasitas 500 orang</li>
                                    <li>Sistem audio dan lighting profesional</li>
                                    <li>AC dan kursi ergonomis</li>
                                </ul>
                            </div>
                            
                            <div class="grid-card">
                                <h5 style="color: var(--primary-blue); margin-bottom: 10px;">
                                    <i class="fas fa-futbol"></i> Lapangan Olahraga
                                </h5>
                                <ul style="margin: 0; padding-left: 20px; font-size: 0.9rem;">
                                    <li>Lapangan basket, voli, futsal</li>
                                    <li>Standar nasional</li>
                                    <li>Area indoor dan outdoor</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <div>
                            <strong>Apakah ada program beasiswa yang tersedia?</strong>
                        </div>
                        <i class="fas fa-chevron-down faq-icon"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Ya, BAKNUS 666 menyediakan berbagai program beasiswa:</p>
                        
                        <h4 style="color: var(--primary-blue); margin: 15px 0 10px 0;">1. Beasiswa Jalur Afirmasi</h4>
                        <ul style="margin: 10px 0; padding-left: 20px;">
                            <li>100% biaya pendidikan untuk 48 siswa</li>
                            <li>Untuk siswa dengan kartu PKH/KKS</li>
                            <li>Penghasilan orang tua ≤ UMR</li>
                        </ul>
                        
                        <h4 style="color: var(--primary-blue); margin: 15px 0 10px 0;">2. Beasiswa Prestasi</h4>
                        <ul style="margin: 10px 0; padding-left: 20px;">
                            <li>50-100% biaya pendidikan</li>
                            <li>Untuk siswa berprestasi tingkat provinsi/nasional</li>
                            <li>Evaluasi berkala setiap semester</li>
                        </ul>
                        
                        <h4 style="color: var(--primary-blue); margin: 15px 0 10px 0;">3. Beasiswa Mitra Industri</h4>
                        <ul style="margin: 10px 0; padding-left: 20px;">
                            <li>Disediakan oleh perusahaan mitra</li>
                            <li>Program magang terintegrasi</li>
                            <li>Jaminan kerja setelah lulus</li>
                        </ul>
                        
                        <h4 style="color: var(--primary-blue); margin: 15px 0 10px 0;">4. Beasiswa Alumni</h4>
                        <ul style="margin: 10px 0; padding-left: 20px;">
                            <li>Dana dari alumni BAKNUS 666</li>
                            <li>Untuk siswa berprestasi dengan kondisi ekonomis terbatas</li>
                            <li>Program mentoring oleh alumni</li>
                        </ul>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <div>
                            <strong>Bagaimana sistem keamanan dan keselamatan di sekolah?</strong>
                        </div>
                        <i class="fas fa-chevron-down faq-icon"></i>
                    </div>
                    <div class="faq-answer">
                        <p>BAKNUS 666 menerapkan sistem keamanan dan keselamatan yang ketat:</p>
                        
                        <h4 style="color: var(--primary-blue); margin: 15px 0 10px 0;">Keamanan Sekolah:</h4>
                        <ul style="margin: 10px 0; padding-left: 20px;">
                            <li>Security 24 jam di pintu masuk</li>
                            <li>Sistem CCTV di seluruh area sekolah</li>
                            <li>Kartu akses untuk siswa dan staf</li>
                            <li>Sistem absensi berbasis sidik jari</li>
                            <li>Pintu darurat dan jalur evakuasi yang jelas</li>
                        </ul>
                        
                        <h4 style="color: var(--primary-blue); margin: 15px 0 10px 0;">Keselamatan Siswa:</h4>
                        <ul style="margin: 10px 0; padding-left: 20px;">
                            <li>Asuransi kecelakaan untuk semua siswa</li>
                            <li>UKS (Unit Kesehatan Sekolah) dengan perawat</li>
                            <li>Kerja sama dengan klinik terdekat</li>
                            <li>Pelatihan P3K untuk seluruh staf</li>
                            <li>Drill evakuasi berkala setiap semester</li>
                        </ul>
                        
                        <h4 style="color: var(--primary-blue); margin: 15px 0 10px 0;">Kesehatan Mental:</h4>
                        <ul style="margin: 10px 0; padding-left: 20px;">
                            <li>Konselor sekolah yang profesional</li>
                            <li>Program bimbingan karir</li>
                            <li>Workshop kesehatan mental</li>
                            <li>Hotline konsultasi 24 jam</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Teknis & Sistem -->
            <div class="faq-category">
                <h3><i class="fas fa-cogs"></i> Teknis & Sistem</h3>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <div>
                            <strong>Apakah website SPMB aman dan terpercaya?</strong>
                        </div>
                        <i class="fas fa-chevron-down faq-icon"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Website SPMB BAKNUS 666 menggunakan sistem keamanan terbaik:</p>
                        
                        <h4 style="color: var(--primary-blue); margin: 15px 0 10px 0;">Keamanan Data:</h4>
                        <ul style="margin: 10px 0; padding-left: 20px;">
                            <li>Enkripsi SSL 256-bit untuk semua transmisi data</li>
                            <li>Backup data otomatis setiap hari</li>
                            <li>Server dengan uptime 99.9%</li>
                            <li>Perlindungan DDoS dan malware</li>
                            <li>Audit keamanan berkala oleh pihak ketiga</li>
                        </ul>
                        
                        <h4 style="color: var(--primary-blue); margin: 15px 0 10px 0;">Perlindungan Privasi:</h4>
                        <ul style="margin: 10px 0; padding-left: 20px;">
                            <li>Data siswa dienkripsi dan terlindungi</li>
                            <li>Akses terbatas untuk staf yang berwenang</li>
                            <li>Tidak ada sharing data ke pihak ketiga</li>
                            <li>Kebijakan privasi yang jelas dan transparan</li>
                        </ul>
                        
                        <div style="background: #d1fae5; padding: 15px; border-radius: 8px; border-left: 4px solid #10b981; margin: 15px 0;">
                            <strong>Verified:</strong> Website kami telah terverifikasi dan memiliki sertifikat keamanan resmi dari otoritas yang terpercaya.
                        </div>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <div>
                            <strong>Bagaimana jika website mengalami gangguan atau error?</strong>
                        </div>
                        <i class="fas fa-chevron-down faq-icon"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Kami memiliki sistem penanggulangan gangguan yang terintegrasi:</p>
                        
                        <h4 style="color: var(--primary-blue); margin: 15px 0 10px 0;">Sistem Backup:</h4>
                        <ul style="margin: 10px 0; padding-left: 20px;">
                            <li>Server cadangan siap pakai 24/7</li>
                            <li>Failover otomatis dalam 5 menit</li>
                            <li>Data terbackup di lokasi berbeda</li>
                        </ul>
                        
                        <h4 style="color: var(--primary-blue); margin: 15px 0 10px 0;">Layanan Bantuan:</h4>
                        <ul style="margin: 10px 0; padding-left: 20px;">
                            <li>Hotline teknis: (021) 1234-5678</li>
                            <li>WhatsApp Bantuan: +62 812-3456-7890</li>
                            <li>Email: support@baknus.666.ac.id</li>
                            <li>Response time: Maksimal 2 jam</li>
                        </ul>
                        
                        <h4 style="color: var(--primary-blue); margin: 15px 0 10px 0;">Alternatif Akses:</h4>
                        <ul style="margin: 10px 0; padding-left: 20px;">
                            <li>Mirror website cadangan</li>
                            <li>Aplikasi mobile (coming soon)</li>
                            <li>Offline registration center (jika diperlukan)</li>
                        </ul>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <div>
                            <strong>Bagaimana sistem notifikasi dan informasi untuk calon siswa?</strong>
                        </div>
                        <i class="fas fa-chevron-down faq-icon"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Kami menyediakan berbagai channel komunikasi untuk memastikan Anda tidak ketinggalan informasi:</p>
                        
                        <h4 style="color: var(--primary-blue); margin: 15px 0 10px 0;">Notifikasi Otomatis:</h4>
                        <ul style="margin: 10px 0; padding-left: 20px;">
                            <li>Email konfirmasi setiap transaksi</li>
                            <li>SMS untuk pengumuman penting</li>
                            <li>Notifikasi di dashboard siswa</li>
                            <li>Update status pendaftaran real-time</li>
                        </ul>
                        
                        <h4 style="color: var(--primary-blue); margin: 15px 0 10px 0;">Media Informasi:</h4>
                        <ul style="margin: 10px 0; padding-left: 20px;">
                            <li>Website resmi SPMB</li>
                            <li>WhatsApp Blast untuk pengumuman</li>
                            <li>Social media (Facebook, Instagram, Twitter)</li>
                            <li>Email newsletter mingguan</li>
                        </ul>
                        
                        <h4 style="color: var(--primary-blue); margin: 15px 0 10px 0;">Customer Service:</h4>
                        <ul style="margin: 10px 0; padding-left: 20px;">
                            <li>Live chat di website (08.00-16.00 WIB)</li>
                            <li>WhatsApp hotline 24/7</li>
                            <li>Telepon: (021) 1234-5678</li>
                            <li>Email: info@baknus666.ac.id</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- No Results -->
        <div id="noResults" class="no-results">
            <i class="fas fa-search"></i>
            <h3 style="color: var(--primary-blue); margin-bottom: 15px;">Pertanyaan tidak ditemukan</h3>
            <p>
                Maaf, kami tidak menemukan pertanyaan yang sesuai dengan pencarian Anda.<br>
                Silakan coba kata kunci lain atau hubungi kami untuk bantuan lebih lanjut.
            </p>
            <div style="margin-top: 30px;">
                <a href="{{ route('kontak') }}" class="btn btn-primary">
                    <i class="fas fa-phone"></i> Hubungi Kami
                </a>
            </div>
        </div>
    </div>
</section>

<style>
    /* ===== PERBAIKAN UNTUK HALAMAN FAQ ===== */

    /* Fix untuk animasi fade-in */
    .fade-in {
        opacity: 1;
        transform: translateY(0);
    }

    /* Perbaikan untuk FAQ items */
    .faq-item {
        background: white;
        border-radius: 10px;
        margin-bottom: 15px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .faq-item:hover {
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
        transform: translateY(-2px);
    }

    .faq-question {
        background: white;
        padding: 20px;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border: none;
        transition: all 0.3s ease;
        position: relative;
    }

    .faq-question:hover {
        background: var(--light-blue);
    }

    .faq-question.active {
        background: var(--primary-blue);
        color: white;
    }

    .faq-answer {
        background: white;
        padding: 0 20px;
        max-height: 0;
        overflow: hidden;
        transition: all 0.3s ease;
        border: none;
    }

    .faq-answer.active {
        padding: 20px;
        max-height: 1000px;
        border-top: 1px solid var(--light-blue);
    }

    .faq-icon {
        transition: transform 0.3s ease;
        font-size: 0.9rem;
    }

    .faq-icon.active {
        transform: rotate(180deg);
    }

    /* Perbaikan untuk kategori FAQ */
    .faq-category {
        margin-bottom: 40px;
        animation: fadeInUp 0.6s ease;
    }

    .faq-category h3 {
        color: var(--primary-blue);
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid var(--light-blue);
        font-size: 1.5rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* Animasi untuk scroll */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Perbaikan untuk search */
    .search-faq {
        max-width: 600px;
        margin: 0 auto 40px;
    }

    .search-faq input {
        width: 100%;
        padding: 15px 50px 15px 20px;
        border: 2px solid rgba(59, 130, 246, 0.2);
        border-radius: 25px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: white;
    }

    .search-faq input:focus {
        outline: none;
        border-color: var(--primary-blue);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    /* Perbaikan untuk tabel responsif */
    .faq-answer table {
        width: 100%;
        border-collapse: collapse;
        margin: 15px 0;
    }

    .faq-answer th,
    .faq-answer td {
        padding: 12px;
        text-align: left;
        border: 1px solid rgba(59, 130, 246, 0.2);
    }

    .faq-answer th {
        background: var(--light-blue);
        font-weight: 600;
        color: var(--primary-blue);
    }

    /* Perbaikan untuk grid cards dalam FAQ */
    .grid-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 15px;
        margin: 15px 0;
    }

    .grid-card {
        background: var(--light-blue);
        padding: 15px;
        border-radius: 8px;
        border-left: 4px solid var(--primary-blue);
    }

    /* Perbaikan untuk no results */
    .no-results {
        text-align: center;
        padding: 60px 20px;
        color: var(--text-light);
        display: none;
    }

    .no-results i {
        font-size: 4rem;
        color: var(--text-light);
        margin-bottom: 20px;
        opacity: 0.5;
    }

    /* Responsive improvements untuk FAQ */
    @media (max-width: 768px) {
        .faq-question {
            padding: 15px;
        }
        
        .faq-answer {
            padding: 0 15px;
        }
        
        .faq-answer.active {
            padding: 15px;
        }
        
        .faq-category h3 {
            font-size: 1.3rem;
        }
        
        .faq-answer table {
            font-size: 0.9rem;
        }
        
        .faq-answer th,
        .faq-answer td {
            padding: 8px;
        }
        
        .search-faq {
            margin-bottom: 30px;
        }
        
        .grid-cards {
            grid-template-columns: 1fr;
        }
    }

    /* Memastikan konten terlihat dengan baik */
    .faq-answer p,
    .faq-answer ul,
    .faq-answer ol {
        margin-bottom: 15px;
        line-height: 1.6;
    }

    .faq-answer ul,
    .faq-answer ol {
        padding-left: 20px;
    }

    .faq-answer li {
        margin-bottom: 8px;
    }

    /* Highlight untuk teks penting */
    .faq-answer strong {
        color: var(--primary-blue);
    }
</style>

<script>
    // Initialize page
    document.addEventListener('DOMContentLoaded', function() {
        // Add click event to all FAQ questions
        document.querySelectorAll('.faq-question').forEach(question => {
            question.addEventListener('click', function() {
                toggleFAQ(this);
            });
        });

        // Add input event to search
        document.getElementById('faqSearch').addEventListener('input', searchFAQ);

        // Initialize scroll animations
        initializeScrollAnimations();
    });

    // Toggle FAQ function
    function toggleFAQ(element) {
        const answer = element.nextElementSibling;
        const icon = element.querySelector('.faq-icon');
        
        // Close all other FAQs
        document.querySelectorAll('.faq-question.active').forEach(item => {
            if (item !== element) {
                item.classList.remove('active');
                item.nextElementSibling.classList.remove('active');
                item.querySelector('.faq-icon').classList.remove('active');
            }
        });
        
        // Toggle current FAQ
        element.classList.toggle('active');
        answer.classList.toggle('active');
        icon.classList.toggle('active');
    }
    
    // Search FAQ function
    function searchFAQ() {
        const searchTerm = document.getElementById('faqSearch').value.toLowerCase().trim();
        const faqItems = document.querySelectorAll('.faq-item');
        const faqCategories = document.querySelectorAll('.faq-category');
        const noResults = document.getElementById('noResults');
        let hasResults = false;
        
        // If search is empty, show all
        if (searchTerm === '') {
            faqItems.forEach(item => item.style.display = 'block');
            faqCategories.forEach(category => category.style.display = 'block');
            noResults.style.display = 'none';
            return;
        }
        
        faqItems.forEach(item => {
            const question = item.querySelector('.faq-question strong').textContent.toLowerCase();
            const answer = item.querySelector('.faq-answer').textContent.toLowerCase();
            
            if (question.includes(searchTerm) || answer.includes(searchTerm)) {
                item.style.display = 'block';
                hasResults = true;
                
                // Ensure parent category is visible
                const category = item.closest('.faq-category');
                if (category) {
                    category.style.display = 'block';
                }
            } else {
                item.style.display = 'none';
            }
        });
        
        // Hide empty categories
        faqCategories.forEach(category => {
            const visibleItems = category.querySelectorAll('.faq-item[style="display: block"]');
            if (visibleItems.length === 0) {
                category.style.display = 'none';
            }
        });
        
        // Show/hide no results message
        noResults.style.display = hasResults ? 'none' : 'block';
    }
    
    // Initialize scroll animations
    function initializeScrollAnimations() {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);
        
        // Observe all FAQ categories
        document.querySelectorAll('.faq-category').forEach(category => {
            category.style.opacity = '0';
            category.style.transform = 'translateY(20px)';
            category.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(category);
        });
    }
</script>
@endsection