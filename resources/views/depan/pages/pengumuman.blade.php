@extends('depan.layouts.main')
@section('content')
    <!-- Hero Section -->
<section class="hero" style="padding: 120px 0 60px;">
        <div class="hero-content">
            <h1 data-splitting>Pengumuman SPMB</h1>
            <p style="font-size: 1.2rem; color: var(--white-blue); margin-top: 20px;">
                Hasil seleksi dan informasi kelulusan peserta SPMB 2025/2026
            </p>
        </div>
    </section>

    <!-- Status Check -->
    <section class="section">
            <div class="section-divider"></div>
        <div class="container">
            <h2 class="section-title fade-in">Cek Status Pendaftaran</h2>
            <div class="card fade-in" style="max-width: 600px; margin: 0 auto;">
                <div style="text-align: center; margin-bottom: 30px;">
                    <i class="fas fa-search" style="font-size: 3rem; color: var(--primary-blue); margin-bottom: 20px;"></i>
                    <h3 style="color: var(--primary-blue); margin-bottom: 10px;">Masukkan Nomor Pendaftaran</h3>
                    <p style="color: var(--text-light);">Masukkan nomor pendaftaran Anda untuk melihat status kelulusan</p>
                </div>
                
                <form id="checkStatusForm" style="margin-bottom: 30px;">
                    @csrf
                    <div class="form-group" style="margin-bottom: 20px;">
                        <input type="text" id="registrationNumber" placeholder="Contoh: PDF2025001" style="text-align: center; font-size: 1.1rem; font-weight: 600;">
                    </div>
                    <button type="submit" class="btn btn-primary" style="width: 100%; padding: 15px; font-size: 1.1rem;">
                        <i class="fas fa-search"></i> Cek Status
                    </button>
                </form>
                
                <div style="text-align: center;">
                    <p style="color: var(--text-light); font-size: 0.9rem;">
                        <i class="fas fa-info-circle"></i> Nomor pendaftaran dapat dilihat di bukti pendaftaran Anda
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Status Result -->
    <section class="section" style="background: var(--light-blue); display: none;" id="statusResult">
        <div class="container">
            <div class="card fade-in" style="max-width: 800px; margin: 0 auto;">
                <div id="statusContent"></div>
            </div>
        </div>
    </section>

    <!-- Daftar Siswa Diterima -->
    <section class="section">
        <div class="container">
            <h2 class="section-title fade-in">Daftar Siswa Diterima</h2>
            <div class="card fade-in">
                <div style="margin-bottom: 30px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 15px;">
                        <div style="display: flex; gap: 10px;">
                            <select id="filterJurusan" style="padding: 8px 15px; border: 1px solid rgba(59, 130, 246, 0.3); border-radius: 8px;">
                                <option value="">Semua Jurusan</option>
                                <option value="TKJ">Teknik Komputer Jaringan</option>
                                <option value="RPL">Rekayasa Perangkat Lunak</option>
                                <option value="TEI">Teknik Elektronika Industri</option>
                                <option value="TKR">Teknik Kendaraan Ringan</option>
                                <option value="TBSM">Teknik Bisnis Sepeda Motor</option>
                            </select>
                            <input type="text" id="searchStudent" placeholder="Cari nama..." style="padding: 8px 15px; border: 1px solid rgba(59, 130, 246, 0.3); border-radius: 8px;">
                        </div>
                    </div>
                    
                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse; font-size: 0.9rem;">
                            <thead>
                                <tr style="background: var(--primary-blue); color: white;">
                                    <th style="padding: 12px; text-align: left;">No</th>
                                    <th style="padding: 12px; text-align: left;">Nomor Pendaftaran</th>
                                    <th style="padding: 12px; text-align: left;">Nama Siswa</th>
                                    <th style="padding: 12px; text-align: left;">Jurusan</th>
                                    <th style="padding: 12px; text-align: left;">Jalur</th>
                                    <th style="padding: 12px; text-align: left;">Nilai</th>
                                </tr>
                            </thead>
                            <tbody id="studentList">
                                <tr style="border-bottom: 1px solid rgba(59, 130, 246, 0.1);">
                                    <td style="padding: 12px;">1</td>
                                    <td style="padding: 12px; font-weight: 600;">PDF2025001</td>
                                    <td style="padding: 12px;">Ahmad Fauzan</td>
                                    <td style="padding: 12px;">Teknik Komputer Jaringan</td>
                                    <td style="padding: 12px;">
                                        <span style="background: var(--primary-blue); color: white; padding: 4px 8px; border-radius: 12px; font-size: 0.8rem;">Zonasi</span>
                                    </td>
                                    <td style="padding: 12px; font-weight: bold; color: var(--primary-blue);">92.5</td>
                                </tr>
                                <tr style="border-bottom: 1px solid rgba(59, 130, 246, 0.1);">
                                    <td style="padding: 12px;">2</td>
                                    <td style="padding: 12px; font-weight: 600;">PDF2025002</td>
                                    <td style="padding: 12px;">Siti Nurhaliza</td>
                                    <td style="padding: 12px;">Rekayasa Perangkat Lunak</td>
                                    <td style="padding: 12px;">
                                        <span style="background: var(--primary-blue); color: white; padding: 4px 8px; border-radius: 12px; font-size: 0.8rem;">Zonasi</span>
                                    </td>
                                    <td style="padding: 12px; font-weight: bold; color: var(--primary-blue);">91.8</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div style="margin-top: 20px; text-align: center;">
                        <p style="color: var(--text-light); font-size: 0.9rem;">
                            Menampilkan 2 dari 96 siswa diterima jalur zonasi
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Jadwal Daftar Ulang -->
    <section class="section" style="background: var(--light-blue);">
        <div class="container">
            <h2 class="section-title fade-in">Jadwal Daftar Ulang</h2>
            <div class="card-grid">
                <div class="card fade-in" style="text-align: center;">
                    <i class="fas fa-calendar-check" style="font-size: 3rem; color: #059669; margin-bottom: 20px;"></i>
                    <h3 style="color: #059669; margin-bottom: 15px;">Gelombang 3</h3>
                    <div style="background: var(--light-blue); padding: 20px; border-radius: 10px; margin-bottom: 15px;">
                        <div style="font-size: 1.5rem; font-weight: bold; color: var(--dark-blue); margin-bottom: 5px;">8 Agustus 2025</div>
                        <small style="color: var(--text-light);">Untuk siswa diterima jalur mutasi</small>
                    </div>
                    <div style="color: var(--text-light); font-size: 0.9rem;">
                        <p><strong>Lokasi:</strong> Ruang SPMB BAKNUS 666</p>
                        <p><strong>Waktu:</strong> 08.00 - 15.00 WIB</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Dokumen yang Harus Dibawa -->
    <section class="section">
        <div class="container">
            <h2 class="section-title fade-in">Dokumen yang Harus Dibawa Saat Daftar Ulang</h2>
            <div class="card fade-in" style="max-width: 800px; margin: 0 auto;">
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                    <div style="background: var(--light-blue); padding: 20px; border-radius: 10px;">
                        <h4 style="color: var(--primary-blue); margin-bottom: 15px;">
                            <i class="fas fa-file-alt"></i> Dokumen Asli
                        </h4>
                        <ul style="margin: 0; padding-left: 20px; color: var(--text-dark);">
                            <li>Ijazah SMP/MTs</li>
                            <li>SKHUN/SHUN</li>
                            <li>Kartu Keluarga (KK)</li>
                            <li>Akta Kelahiran</li>
                            <li>Rapor kelas VIII</li>
                        </ul>
                    </div>
                    
                    <div style="background: var(--light-blue); padding: 20px; border-radius: 10px;">
                        <h4 style="color: var(--primary-blue); margin-bottom: 15px;">
                            <i class="fas fa-copy"></i> Fotokopi
                        </h4>
                        <ul style="margin: 0; padding-left: 20px; color: var(--text-dark);">
                            <li>Ijazah SMP/MTs (2 lembar)</li>
                            <li>SKHUN/SHUN (2 lembar)</li>
                            <li>KK (2 lembar)</li>
                            <li>Akta Kelahiran (2 lembar)</li>
                            <li>Pas foto 3x4 (6 lembar)</li>
                        </ul>
                    </div>
                    
                    <div style="background: var(--light-blue); padding: 20px; border-radius: 10px;">
                        <h4 style="color: var(--primary-blue); margin-bottom: 15px;">
                            <i class="fas fa-money-bill"></i> Biaya
                        </h4>
                        <ul style="margin: 0; padding-left: 20px; color: var(--text-dark);">
                            <li>Biaya pendaftaran ulang</li>
                            <li>Seragam sekolah</li>
                            <li>Buku paket</li>
                            <li>Alat praktik</li>
                            <li>Kegiatan ekstrakurikuler</li>
                        </ul>
                    </div>
                    
                    <div style="background: var(--light-blue); padding: 20px; border-radius: 10px;">
                        <h4 style="color: var(--primary-blue); margin-bottom: 15px;">
                            <i class="fas fa-user-shield"></i> Lain-lain
                        </h4>
                        <ul style="margin: 0; padding-left: 20px; color: var(--text-dark);">
                            <li>Surat pernyataan siswa</li>
                            <li>Formulir kesehatan</li>
                            <li>Surat pernyataan orang tua</li>
                            <li>Formulir keamanan</li>
                            <li>Orang tua/wali</li>
                        </ul>
                    </div>
                </div>
                
                <div style="margin-top: 30px; padding: 20px; background: #fef3c7; border-radius: 10px; border-left: 4px solid #f59e0b;">
                    <h4 style="color: #92400e; margin-bottom: 10px;">
                        <i class="fas fa-exclamation-triangle"></i> Penting!
                    </h4>
                    <p style="color: #92400e; margin: 0;">
                        Semua dokumen harus lengkap saat daftar ulang. Jika ada dokumen yang kurang, pendaftaran ulang tidak dapat diproses. Pastikan membawa orang tua/wali untuk menandatangani surat pernyataan.
                    </p>
                </div>
            </div>
        </div>
    </section>

<script>
    // Mock data for students (fallback)
    const studentsData = [];

    // Initialize page
    document.addEventListener('DOMContentLoaded', function() {
        initializeScrollEffects();
        loadSiswaDiterima();
        
        // Auto-check status jika ada parameter
        const urlParams = new URLSearchParams(window.location.search);
        const autoCheck = urlParams.get('auto_check');
        if (autoCheck) {
            document.getElementById('registrationNumber').value = autoCheck;
            checkStatus();
            // Hapus parameter dari URL
            window.history.replaceState({}, document.title, window.location.pathname);
        }
        
        // Setup event listeners
        document.getElementById('checkStatusForm').addEventListener('submit', checkStatus);
        document.getElementById('filterJurusan').addEventListener('change', filterStudents);
        document.getElementById('searchStudent').addEventListener('keyup', searchStudents);
        
        // Animate section title
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

    // Check status function
    async function checkStatus(event) {
        if (event) event.preventDefault();
        
        const regNumber = document.getElementById('registrationNumber').value.trim();
        
        if (!regNumber) {
            showNotification('Masukkan nomor pendaftaran', 'error');
            return;
        }
        
        // Tampilkan loading
        const submitBtn = document.querySelector('#checkStatusForm button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mencari...';
        submitBtn.disabled = true;

        try {
            // Lakukan request ke server
            const response = await fetch('{{ route("pengumuman.check") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ registrationNumber: regNumber })
            });

            const data = await response.json();

            if (data.success) {
                if (data.data) {
                    showStatusResult(data.data);
                } else {
                    showNotification('Nomor pendaftaran tidak ditemukan', 'error');
                    document.getElementById('statusResult').style.display = 'none';
                }
            } else {
                showNotification(data.message || 'Terjadi kesalahan', 'error');
                document.getElementById('statusResult').style.display = 'none';
            }
        } catch (error) {
            console.error('Error:', error);
            showNotification('Terjadi kesalahan jaringan', 'error');
            document.getElementById('statusResult').style.display = 'none';
        } finally {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }
    }
    
    // Show status result
    function showStatusResult(student) {
        const statusResult = document.getElementById('statusResult');
        const statusContent = document.getElementById('statusContent');
        
        const jurusanNames = {
            'TKJ': 'Teknik Komputer dan Jaringan',
            'RPL': 'Rekayasa Perangkat Lunak',
            'TEI': 'Teknik Elektronika Industri',
            'TKR': 'Teknik Kendaraan Ringan',
            'TBSM': 'Teknik Bisnis Sepeda Motor'
        };
        
        // Tampilkan berdasarkan status
        if (student.status === 'DITERIMA') {
            statusContent.innerHTML = `
                <div style="text-align: center; margin-bottom: 30px;">
                    <div style="font-size: 4rem; color: #10b981; margin-bottom: 20px;">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h3 style="color: #10b981; margin-bottom: 10px;">SELAMAT!</h3>
                    <h4 style="color: var(--primary-blue);">Anda diterima di BAKNUS 666</h4>
                </div>
                
                <div style="background: var(--light-blue); padding: 25px; border-radius: 15px; margin-bottom: 25px;">
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
                        <div>
                            <strong style="color: var(--primary-blue);">Nomor Pendaftaran</strong><br>
                            <span style="font-size: 1.1rem; font-weight: bold;">${student.registrationNumber}</span>
                        </div>
                        <div>
                            <strong style="color: var(--primary-blue);">Nama Siswa</strong><br>
                            <span style="font-size: 1.1rem;">${student.name}</span>
                        </div>
                        <div>
                            <strong style="color: var(--primary-blue);">Jurusan</strong><br>
                            <span style="font-size: 1.1rem;">${jurusanNames[student.jurusan_kode] || student.jurusan}</span>
                        </div>
                        <div>
                            <strong style="color: var(--primary-blue);">Jalur Pendaftaran</strong><br>
                            <span style="font-size: 1.1rem; text-transform: capitalize;">${student.jalur}</span>
                        </div>
                        <div>
                            <strong style="color: var(--primary-blue);">Nilai Rata-Rata</strong><br>
                            <span style="font-size: 1.1rem; font-weight: bold; color: var(--primary-blue);">${student.nilai}</span>
                        </div>
                        <div>
                            <strong style="color: var(--primary-blue);">Status</strong><br>
                            <span style="background: #10b981; color: white; padding: 5px 15px; border-radius: 20px; font-weight: bold;">${student.status}</span>
                        </div>
                    </div>
                </div>
                
                <div style="text-align: center; margin-top: 30px;">
                    <p style="color: var(--text-light); margin-bottom: 20px;">
                        Simpan informasi ini dan lakukan daftar ulang sesuai jadwal yang telah ditentukan.
                    </p>
                    <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
                        <button onclick="printRegistrationProof('${student.registrationNumber}')" class="btn btn-primary">
                            <i class="fas fa-print"></i> Cetak Bukti
                        </button>
                        <button onclick="exportKartuPDF('${student.registrationNumber}')" class="btn btn-success">
                            <i class="fas fa-file-pdf"></i> Export PDF
                        </button>
                        <button onclick="shareResult('${student.registrationNumber}', '${student.name}')" class="btn btn-secondary">
                            <i class="fas fa-share"></i> Bagikan
                        </button>
                    </div>
                </div>
            `;
        } else if (student.status === 'Lolos Administrasi') {
            // Tampilkan form upload bukti pembayaran untuk status ADM_PASS
            const hasBukti = student.has_bukti_pembayaran;
            const isOwner = student.is_owner;
            
            // Debug log removed
            
            statusContent.innerHTML = `
                <div style="text-align: center; margin-bottom: 30px;">
                    <div style="font-size: 4rem; color: #f59e0b; margin-bottom: 20px;">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h3 style="color: #f59e0b; margin-bottom: 10px;">LOLOS ADMINISTRASI</h3>
                    <h4 style="color: var(--primary-blue);">Status Pendaftaran Anda</h4>
                </div>
                
                <div style="background: var(--light-blue); padding: 25px; border-radius: 15px; margin-bottom: 25px;">
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
                        <div>
                            <strong style="color: var(--primary-blue);">Nomor Pendaftaran</strong><br>
                            <span style="font-size: 1.1rem; font-weight: bold;">${student.registrationNumber}</span>
                        </div>
                        <div>
                            <strong style="color: var(--primary-blue);">Nama Siswa</strong><br>
                            <span style="font-size: 1.1rem;">${student.name}</span>
                        </div>
                        <div>
                            <strong style="color: var(--primary-blue);">Jurusan</strong><br>
                            <span style="font-size: 1.1rem;">${jurusanNames[student.jurusan_kode] || student.jurusan}</span>
                        </div>
                        <div>
                            <strong style="color: var(--primary-blue);">Jalur Pendaftaran</strong><br>
                            <span style="font-size: 1.1rem; text-transform: capitalize;">${student.jalur}</span>
                        </div>
                        <div>
                            <strong style="color: var(--primary-blue);">Status</strong><br>
                            <span style="background: #f59e0b; color: white; padding: 5px 15px; border-radius: 20px; font-weight: bold;">${student.status}</span>
                        </div>
                    </div>
                    
                    ${student.gelombang_biaya ? `
                        <div style="margin-top:12px;">
                            <strong style="color: var(--primary-blue);">Biaya Pendaftaran</strong><br>
                            <span style="font-size:1.1rem; font-weight:bold; color: #0f766e;">${Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(student.gelombang_biaya)}</span>
                        </div>
                    ` : ''}
                    <!-- Debug info removed for production -->
                </div>
                
                ${hasBukti ? `
                    <div style="background: #d1fae5; padding: 20px; border-radius: 10px; margin-bottom: 25px; border-left: 4px solid #10b981;">
                        <div style="display: flex; align-items: center; gap: 15px;">
                            <i class="fas fa-check-circle" style="color: #10b981; font-size: 1.5rem;"></i>
                            <div>
                                <h4 style="color: #065f46; margin: 0;">Bukti Pembayaran Sudah Diupload</h4>
                                <p style="color: #047857; margin: 5px 0 0 0;">
                                    Bukti pembayaran Anda telah diterima dan sedang menunggu verifikasi.
                                </p>
                                ${student.bukti_pembayaran ? `
                                    <small style="color: #059669;">
                                        File: ${student.bukti_pembayaran.nama_file}
                                    </small>
                                ` : ''}
                            </div>
                        </div>
                    </div>
                ` : `
                    ${isOwner ? `
                        <div style="background: #fffbeb; padding: 25px; border-radius: 15px; margin-bottom: 25px; border-left: 4px solid #f59e0b;">
                            <h4 style="color: #92400e; margin-bottom: 15px;">
                                <i class="fas fa-upload"></i> Upload Bukti Pembayaran
                            </h4>
                            <p style="color: #92400e; margin-bottom: 20px;">
                                Silakan upload bukti pembayaran Anda untuk melanjutkan proses seleksi.
                            </p>
                            
                            <form id="uploadBuktiForm">
                                <input type="hidden" name="registrationNumber" value="${student.registrationNumber}">
                                <div class="form-group" style="margin-bottom: 20px;">
                                    <label style="display: block; margin-bottom: 8px; color: var(--text-dark); font-weight: 500;">
                                        Pilih File Bukti Pembayaran
                                    </label>
                                    <input type="file" id="buktiPembayaran" name="bukti_pembayaran" 
                                           accept=".jpg,.jpeg,.png,.pdf" required
                                           style="width: 100%; padding: 10px; border: 2px dashed #d1d5db; border-radius: 8px;">
                                    <small style="color: var(--text-light); display: block; margin-top: 5px;">
                                        Format: JPG, PNG, PDF (Maksimal 2MB)
                                    </small>
                                </div>
                                <button type="button" onclick="uploadBuktiPembayaran('${student.registrationNumber}')" class="btn btn-primary" style="width: 100%; padding: 12px;">
                                    <i class="fas fa-upload"></i> Upload Bukti Pembayaran
                                </button>
                            </form>
                        </div>
                    ` : `
                        <div style="background: #fef3c7; padding: 25px; border-radius: 15px; margin-bottom: 25px; border-left: 4px solid #f59e0b;">
                            <div style="text-align: center;">
                                <i class="fas fa-exclamation-triangle" style="color: #f59e0b; font-size: 3rem; margin-bottom: 15px;"></i>
                                <h4 style="color: #92400e; margin-bottom: 10px;">Akses Ditolak</h4>
                                <p style="color: #92400e; margin-bottom: 20px;">
                                    ${student.is_logged_in ? 
                                        'Anda tidak memiliki akses untuk mengupload bukti pembayaran untuk nomor pendaftaran ini.<br><small>Pastikan Anda login dengan akun yang sesuai.</small>' :
                                        'Anda harus login untuk mengupload bukti pembayaran.<br><small>Silakan login dengan akun yang sesuai.</small>'
                                    }
                                </p>
                                <div style="display: flex; gap: 10px; justify-content: center; flex-wrap: wrap;">
                                    ${student.is_logged_in ? 
                                        `<button onclick="window.location.href='{{ route('peserta.logout') }}'" class="btn btn-primary">
                                            <i class="fas fa-sign-out-alt"></i> Login dengan Akun Lain
                                        </button>` :
                                        `<button onclick="window.location.href='{{ route('home') }}'" class="btn btn-primary">
                                            <i class="fas fa-sign-in-alt"></i> Login Sekarang
                                        </button>`
                                    }
                                    <button onclick="window.location.href='/'" class="btn btn-secondary">
                                        <i class="fas fa-home"></i> Kembali ke Beranda
                                    </button>
                                </div>
                            </div>
                        </div>
                    `}
                `}
                
                <div style="text-align: center; margin-top: 20px;">
                    <div style="display: flex; gap: 10px; justify-content: center; flex-wrap: wrap; margin-bottom: 15px;">
                        <button onclick="exportKartuPDF('${student.registrationNumber}')" class="btn btn-success">
                            <i class="fas fa-file-pdf"></i> Export Kartu PDF
                        </button>
                    </div>
                    <p style="color: var(--text-light); font-size: 0.9rem;">
                        <i class="fas fa-info-circle"></i> Setelah upload, bukti pembayaran akan diverifikasi oleh admin.
                    </p>
                </div>
            `;
        } else if (student.status === 'TIDAK DITERIMA' || student.status_db === 'ADM_REJECT') {
            // Tampilkan berkas yang ditolak jika ada
            let rejectedBerkasHtml = '';
            if (student.rejected_berkas && student.rejected_berkas.length > 0) {
                rejectedBerkasHtml = `
                    <div style="background: #fef2f2; padding: 20px; border-radius: 10px; margin-bottom: 20px; border-left: 4px solid #ef4444;">
                        <h5 style="color: #dc2626; margin-bottom: 15px;">
                            <i class="fas fa-exclamation-triangle"></i> Berkas yang Ditolak
                        </h5>
                        <div style="display: grid; gap: 15px;">
                            ${student.rejected_berkas.map(berkas => `
                                <div style="background: white; padding: 15px; border-radius: 8px; border-left: 3px solid #ef4444;">
                                    <div style="font-weight: bold; color: #dc2626; margin-bottom: 5px;">
                                        ${berkas.jenis}
                                    </div>
                                    <div style="color: #7f1d1d; font-size: 0.9rem; margin-bottom: 10px;">
                                        ${berkas.catatan || 'Tidak ada catatan khusus'}
                                    </div>

                                    ${student.is_owner && student.is_logged_in ? `
                                        <div style="margin-top: 10px; padding-top: 10px; border-top: 1px solid #fee2e2;">
                                            <div class="form-group" style="margin-bottom: 10px;">
                                                <label style="font-size: 0.9rem; color: var(--text-dark); font-weight: 500; display: block; margin-bottom: 8px;">
                                                    Pilih File untuk ${berkas.jenis}
                                                </label>
                                                <div style="display: flex; gap: 10px; align-items: flex-end;">
                                                    <input type="file" 
                                                           id="reupload_${berkas.id}" 
                                                           name="berkas_file_${berkas.id}"
                                                           accept=".jpg,.jpeg,.png,.pdf" 
                                                           style="flex: 1; padding: 8px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 0.85rem;">
                                                </div>
                                                <small style="color: var(--text-light); display: block; margin-top: 5px;">
                                                    Format: JPG, PNG, PDF (Maksimal 5MB)
                                                </small>
                                            </div>
                                        </div>
                                    ` : ''}
                                </div>
                            `).join('')}
                        </div>
                        ${student.is_owner && student.is_logged_in ? `
                            <!-- Single button to upload all selected files -->
                            <div style="margin-top: 15px; padding: 15px; border-radius: 8px; background: #fff7ed; border: 1px solid #fde3bf;">
                                <h6 style="margin:0 0 8px 0; color:#92400e;">Upload Semua Berkas yang Ditolak</h6>
                                <div style="display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
                                    <button type="button" id="btnUploadAll_${student.registrationNumber.replace(/[^a-zA-Z0-9_-]/g,'')}" onclick="reUploadAll('${student.registrationNumber}')" style="padding:8px 12px; background:#10b981; color:white; border:none; border-radius:6px;">
                                        <i class="fas fa-upload"></i> Upload Semua Berkas
                                    </button>
                                </div>
                                <small style="display:block; margin-top:6px; color:#7c2d12;">Pilih file untuk setiap berkas yang ditolak menggunakan tombol di setiap kartu, lalu klik "Upload Semua Berkas". Maks 5MB per file.</small>
                            </div>
                        ` : ''}
                        ${student.catatan_verifikasi && student.status_db === 'ADM_REJECT' ? `
                            <div style="margin-top: 15px; padding: 10px; background: #fee2e2; border-radius: 6px;">
                                <strong style="color: #dc2626;">Catatan Verifikator:</strong><br>
                                <span style="color: #7f1d1d;">${student.catatan_verifikasi}</span>
                            </div>
                        ` : ''}
                    </div>
                `;
            }
            
            const statusTitle = student.status_db === 'ADM_REJECT' ? 'BERKAS DITOLAK' : 'TIDAK DITERIMA';
            const statusMessage = student.status_db === 'ADM_REJECT' ? 
                'Berkas Anda tidak memenuhi persyaratan' : 
                'Anda belum diterima';
            statusContent.innerHTML = `
                <div style="text-align: center; margin-bottom: 30px;">
                    <div style="font-size: 4rem; color: #ef4444; margin-bottom: 20px;">
                        <i class="fas fa-times-circle"></i>
                    </div>
                    <h3 style="color: #ef4444; margin-bottom: 10px;">${statusTitle}</h3>
                    <h4 style="color: var(--primary-blue);">${statusMessage}</h4>
                </div>
                
                <div style="background: var(--light-blue); padding: 25px; border-radius: 15px; margin-bottom: 25px;">
                    <div style="text-align: center;">
                        <strong style="color: var(--primary-blue);">Nomor Pendaftaran</strong><br>
                        <span style="font-size: 1.3rem; font-weight: bold;">${student.registrationNumber}</span><br>
                        <strong style="color: var(--primary-blue);">Nama Siswa</strong><br>
                        <span style="font-size: 1.1rem;">${student.name}</span>
                    </div>
                </div>
                
                ${rejectedBerkasHtml}
                
                <div style="text-align: center;">
                    <p style="color: var(--text-light); margin-bottom: 20px;">
                        ${student.status_db === 'ADM_REJECT' ? 
                            'Silakan perbaiki berkas yang ditolak dan daftar kembali di gelombang berikutnya.' :
                            'Terima kasih telah berpartisipasi dalam proses seleksi SPMB BAKNUS 666. Jangan putus asa dan tetap semangat!'
                        }
                    </p>
                    <button onclick="window.location.href='/'" class="btn btn-primary">
                        <i class="fas fa-home"></i> Kembali ke Beranda
                    </button>
                </div>
            `;
        } else {
            // Status lainnya (Dalam Proses, Terverifikasi, dll)
            statusContent.innerHTML = `
                <div style="text-align: center; margin-bottom: 30px;">
                    <div style="font-size: 4rem; color: #f59e0b; margin-bottom: 20px;">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h3 style="color: #f59e0b; margin-bottom: 10px;">DALAM PROSES</h3>
                    <h4 style="color: var(--primary-blue);">Pendaftaran Anda sedang diproses</h4>
                </div>
                
                <div style="background: var(--light-blue); padding: 25px; border-radius: 15px; margin-bottom: 25px;">
                    <div style="text-align: center;">
                        <strong style="color: var(--primary-blue);">Nomor Pendaftaran</strong><br>
                        <span style="font-size: 1.3rem; font-weight: bold;">${student.registrationNumber}</span><br>
                        <strong style="color: var(--primary-blue);">Nama Siswa</strong><br>
                        <span style="font-size: 1.1rem;">${student.name}</span><br>
                        <small style="color: var(--text-light);">Status: ${student.status}</small>
                    </div>
                </div>
                
                <div style="text-align: center;">
                    <p style="color: var(--text-light); margin-bottom: 20px;">
                        Hasil seleksi akan diumumkan sesuai jadwal. 
                        Pantau terus website kami untuk informasi lebih lanjut.
                    </p>
                    <div style="display: flex; gap: 10px; justify-content: center; flex-wrap: wrap;">
                        <button onclick="exportKartuPDF('${student.registrationNumber}')" class="btn btn-success">
                            <i class="fas fa-file-pdf"></i> Export Kartu PDF
                        </button>
                        <button onclick="window.location.href='/'" class="btn btn-primary">
                            <i class="fas fa-home"></i> Kembali ke Beranda
                        </button>
                    </div>
                </div>
            `;
        }
        
        statusResult.style.display = 'block';
        statusResult.scrollIntoView({ behavior: 'smooth' });
        
        // Animate result
        if (typeof anime !== 'undefined') {
            anime({
                targets: '#statusContent',
                opacity: [0, 1],
                translateY: [30, 0],
                duration: 800,
                easing: 'easeOutExpo'
            });
        }
    }
    
    // Upload bukti pembayaran
    async function uploadBuktiPembayaran(registrationNumber) {
        // Debug log removed
        
        const fileInput = document.getElementById('buktiPembayaran');
        const file = fileInput.files[0];
        
        if (!file) {
            showNotification('Pilih file bukti pembayaran terlebih dahulu', 'error');
            return;
        }
        
        // Validasi ukuran file
        if (file.size > 2 * 1024 * 1024) {
            showNotification('Ukuran file maksimal 2MB', 'error');
            return;
        }
        
        // Validasi tipe file
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'application/pdf'];
        if (!allowedTypes.includes(file.type)) {
            showNotification('Format file harus JPG, PNG, atau PDF', 'error');
            return;
        }
        
        const formData = new FormData();
        formData.append('bukti_pembayaran', file);
        formData.append('registrationNumber', registrationNumber);
        formData.append('_token', '{{ csrf_token() }}');
        
        // Tampilkan loading
        const submitBtn = document.querySelector('#uploadBuktiForm button');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengupload...';
        submitBtn.disabled = true;
        
        try {
            // Debug log removed
            
            const response = await fetch('{{ route("pengumuman.upload-bukti") }}', {
                method: 'POST',
                body: formData
            });
            
            const data = await response.json();
            // Debug log removed
            
            if (data.success) {
                showNotification('Bukti pembayaran berhasil diupload dan menunggu verifikasi', 'success');
                
                // Langsung refresh status
                const regNumber = document.getElementById('registrationNumber').value.trim();
                if (regNumber) {
                    setTimeout(() => {
                        checkStatus();
                    }, 1000);
                }
            } else {
                showNotification(data.message || 'Gagal mengupload bukti pembayaran', 'error');
            }
        } catch (error) {
            console.error('Error saat upload:', error);
            showNotification('Terjadi kesalahan jaringan: ' + error.message, 'error');
        } finally {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }
    }
    
    // Re-upload berkas yang ditolak
    async function reUploadBerkas(registrationNumber, berkasId, btn = null) {
        // Determine file input: either individual input or combined input
        let fileInput = document.getElementById(`reupload_${berkasId}`);
        if (!fileInput) {
            // try combined input with dynamic id (constructed using registrationNumber)
            fileInput = document.querySelector(`#reupload_combined_file_${registrationNumber}`) || document.querySelector(`#reupload_combined_file_${registrationNumber.replace(/[^a-zA-Z0-9_-]/g,'')}`);
        }
        const file = fileInput ? fileInput.files[0] : null;
        
        if (!file) {
            showNotification('Pilih file berkas terlebih dahulu', 'error');
            return;
        }
        
        // Validasi ukuran file
        if (file.size > 5 * 1024 * 1024) {
            showNotification('Ukuran file maksimal 5MB', 'error');
            return;
        }
        
        // Validasi tipe file
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'application/pdf'];
        if (!allowedTypes.includes(file.type)) {
            showNotification('Format file harus JPG, PNG, atau PDF', 'error');
            return;
        }
        
        const formData = new FormData();
        formData.append('berkas_file', file);
        formData.append('registrationNumber', registrationNumber);
        formData.append('berkas_id', berkasId);
        formData.append('_token', '{{ csrf_token() }}');
        
        // (Optional) disable button to prevent double clicks
        let originalText = null;
        if (btn) {
            try { btn.disabled = true; originalText = btn.innerHTML; btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Uploading...'; } catch(e) {}
        }
        
        try {
            const response = await fetch('{{ route("pengumuman.reupload-berkas") }}', {
                method: 'POST',
                body: formData
            });
            
            const data = await response.json();
            
            if (data.success) {
                // Tampilkan notifikasi yang berbeda untuk BUKTI_BAYAR
                if (data.is_bukti_bayar) {
                    showNotification('✅ Bukti pembayaran berhasil di-reupload. Data Anda akan diproses kembali oleh tim keuangan.', 'success');
                } else {
                    showNotification('✅ Berkas berhasil di-reupload dan menunggu verifikasi ulang oleh verifikator', 'success');
                }
                
                // Refresh status setelah 1.5 detik
                setTimeout(() => {
                    checkStatus();
                }, 1500);
            } else {
                showNotification(data.message || 'Gagal mengupload berkas', 'error');
            }
        } catch (error) {
            console.error('Error saat upload:', error);
            showNotification('Terjadi kesalahan jaringan: ' + error.message, 'error');
        } finally {
            if (btn && originalText !== null) { try { btn.innerHTML = originalText; btn.disabled = false; } catch(e) {} }
        }
    }

    // Re-upload all selected rejected berkas in one request
    async function reUploadAll(registrationNumber) {
        const safeId = registrationNumber.replace(/[^a-zA-Z0-9_-]/g,'');
        const btn = document.getElementById(`btnUploadAll_${safeId}`);

        // Gather all file inputs for rejected berkas
        const inputs = document.querySelectorAll('[id^="reupload_"]');
        const formData = new FormData();
        formData.append('registrationNumber', registrationNumber);
        formData.append('_token', '{{ csrf_token() }}');

        let found = 0;

        for (let i = 0; i < inputs.length; i++) {
            const input = inputs[i];
            // id format: reupload_<berkasId>
            const m = input.id.match(/^reupload_(\d+)$/);
            if (!m) continue;
            const berkasId = m[1];
            if (input.files && input.files[0]) {
                const file = input.files[0];

                // Validate size (<=5MB) and type
                if (file.size > 5 * 1024 * 1024) {
                    showNotification(`Ukuran file untuk berkas ${berkasId} maksimal 5MB`, 'error');
                    return;
                }
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'application/pdf'];
                if (!allowedTypes.includes(file.type)) {
                    showNotification(`Format file untuk berkas ${berkasId} harus JPG, PNG, atau PDF`, 'error');
                    return;
                }

                formData.append(`berkas_files[${berkasId}]`, file);
                found++;
            }
        }

        if (found === 0) {
            showNotification('Pilih minimal satu file untuk diupload', 'error');
            return;
        }

        // Disable button
        let originalText = null;
        if (btn) { originalText = btn.innerHTML; btn.disabled = true; btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengupload...'; }

        try {
            const response = await fetch('{{ route("pengumuman.reupload-multiple") }}', {
                method: 'POST',
                body: formData
            });

            const data = await response.json();

            if (data.success) {
                showNotification(data.message || 'Upload berhasil', 'success');
                setTimeout(() => checkStatus(), 1500);
            } else {
                showNotification(data.message || 'Gagal mengupload berkas', 'error');
            }
        } catch (error) {
            console.error('Error saat upload all:', error);
            showNotification('Terjadi kesalahan jaringan: ' + error.message, 'error');
        } finally {
            if (btn && originalText !== null) { btn.innerHTML = originalText; btn.disabled = false; }
        }
    }
    
    // Load data siswa diterima dari database
    async function loadSiswaDiterima() {
        try {
            const response = await fetch('{{ route("pengumuman.siswa-diterima") }}');
            const data = await response.json();

            if (data.success) {
                // Simpan data untuk filtering
                window.siswaDiterimaData = data.data;
                renderStudentList(data.data.slice(0, 10));
            }
        } catch (error) {
            console.error('Error loading siswa diterima:', error);
            renderStudentList(studentsData.slice(0, 5));
        }
    }

    // Filter students
    function filterStudents() {
        const jurusan = document.getElementById('filterJurusan').value;
        let filteredStudents = window.siswaDiterimaData || [];

        if (jurusan) {
            filteredStudents = filteredStudents.filter(s => s.jurusan === jurusan);
        }

        renderStudentList(filteredStudents.slice(0, 10));
    }
    
    // Search students
    function searchStudents() {
        const searchTerm = document.getElementById('searchStudent').value.toLowerCase();
        let filteredStudents = window.siswaDiterimaData || [];

        if (searchTerm) {
            filteredStudents = filteredStudents.filter(s => 
                s.name.toLowerCase().includes(searchTerm) || 
                s.registrationNumber.toLowerCase().includes(searchTerm)
            );
        }

        renderStudentList(filteredStudents.slice(0, 10));
    }
    
    // Render student list
    function renderStudentList(students) {
        const studentList = document.getElementById('studentList');
        const jurusanNames = {
            'TKJ': 'Teknik Komputer dan Jaringan',
            'RPL': 'Rekayasa Perangkat Lunak',
            'TEI': 'Teknik Elektronika Industri',
            'TKR': 'Teknik Kendaraan Ringan',
            'TBSM': 'Teknik Bisnis Sepeda Motor'
        };

        if (!students || students.length === 0) {
            studentList.innerHTML = `
                <tr>
                    <td colspan="6" style="padding: 40px; text-align: center; color: var(--text-light);">
                        <i class="fas fa-info-circle" style="font-size: 2rem; margin-bottom: 10px;"></i><br>
                        Belum ada data siswa yang diterima
                    </td>
                </tr>
            `;
            return;
        }

        studentList.innerHTML = students.map((student, index) => `
            <tr style="border-bottom: 1px solid rgba(59, 130, 246, 0.1);">
                <td style="padding: 12px;">${index + 1}</td>
                <td style="padding: 12px; font-weight: 600;">${student.registrationNumber}</td>
                <td style="padding: 12px;">${student.name}</td>
                <td style="padding: 12px;">${jurusanNames[student.jurusan] || student.jurusan_nama}</td>
                <td style="padding: 12px;">
                    <span style="background: var(--primary-blue); color: white; padding: 4px 8px; border-radius: 12px; font-size: 0.8rem;">${student.jalur.toUpperCase()}</span>
                </td>
                <td style="padding: 12px; font-weight: bold; color: var(--primary-blue);">${student.nilai}</td>
            </tr>
        `).join('');

        // Update counter
        const counterElement = document.querySelector('#studentList').closest('.card').querySelector('p');
        if (counterElement) {
            counterElement.textContent = `Menampilkan ${students.length} dari ${window.siswaDiterimaData ? window.siswaDiterimaData.length : 0} siswa diterima`;
        }
    }
    
    // Share result
    function shareResult(registrationNumber, name) {
        const shareText = `Saya ${name} telah diterima di BAKNUS 666 dengan nomor pendaftaran ${registrationNumber}!`;
        
        if (navigator.share) {
            navigator.share({
                title: 'Hasil SPMB BAKNUS 666',
                text: shareText,
                url: window.location.href
            });
        } else {
            navigator.clipboard.writeText(shareText).then(() => {
                showNotification('Informasi berhasil disalin ke clipboard', 'success');
            }).catch(() => {
                showNotification(shareText, 'info');
            });
        }
    }

    // Print registration proof
    function printRegistrationProof(registrationNumber) {
        const printContent = `
            <div style="text-align: center; padding: 20px; font-family: Arial, sans-serif;">
                <h2 style="color: #3b82f6;">BUKTI PENDAFTARAN</h2>
                <h3>BAKNUS 666</h3>
                <div style="margin: 20px 0; padding: 20px; border: 2px solid #3b82f6; border-radius: 10px;">
                    <h4>Nomor Pendaftaran</h4>
                    <h1 style="color: #3b82f6;">${registrationNumber}</h1>
                </div>
                <p>Simpan bukti ini untuk keperluan daftar ulang</p>
                <small>Dicetak pada: ${new Date().toLocaleDateString('id-ID')}</small>
            </div>
        `;
        
        const printWindow = window.open('', '_blank');
        printWindow.document.write(`
            <html>
                <head>
                    <title>Bukti Pendaftaran - ${registrationNumber}</title>
                </head>
                <body>${printContent}</body>
            </html>
        `);
        printWindow.document.close();
        printWindow.print();
    }

    // Notification function
    function showNotification(message, type = 'info') {
        // Create notification element
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

        // Auto remove after 5 seconds
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

    // Scroll effects (jika ada)
    function initializeScrollEffects() {
        // Add scroll animations jika diperlukan
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('fade-in-visible');
                }
            });
        }, observerOptions);

        // Observe all fade-in elements
        document.querySelectorAll('.fade-in').forEach(el => {
            observer.observe(el);
        });
    }

    // Export kartu pendaftaran ke PDF
    function exportKartuPDF(registrationNumber) {
        const url = `{{ url('/kartu-pendaftaran') }}/${registrationNumber}`;
        window.open(url, '_blank');
    }

    // Export functions for global use
    window.checkStatus = checkStatus;
    window.filterStudents = filterStudents;
    window.searchStudents = searchStudents;
    window.shareResult = shareResult;
    window.printRegistrationProof = printRegistrationProof;
    window.exportKartuPDF = exportKartuPDF;
    window.showNotification = showNotification;
    window.uploadBuktiPembayaran = uploadBuktiPembayaran;
    window.reUploadBerkas = reUploadBerkas;
</script>