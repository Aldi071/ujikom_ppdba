@extends('depan.layouts.main')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

{{-- Debug block removed for production cleanliness --}}

@php
$jurusan = $jurusan ?? collect();
$gelombang = $gelombang ?? collect();
$wilayah = $wilayah ?? collect();
$pendaftar = $pendaftar ?? null;
@endphp

@if(session('warning'))
<div class="alert alert-warning">
    <i class="fas fa-exclamation-triangle"></i> {{ session('warning') }}
</div>
@endif

@auth
<div class="alert alert-info">
    <i class="fas fa-info-circle"></i>
    Anda login sebagai: <strong>{{ auth()->user()->email }}</strong>
</div>
@endauth

<section class="hero" style="padding: 120px 0 60px;">
    <div class="hero-content">
        <h1 data-splitting>Pendaftaran Online</h1>
        <p style="font-size: 1.2rem; color: var(--white-blue); margin-top: 20px;">
            Isi formulir pendaftaran dengan lengkap dan benar
        </p>
    </div>
</section>

<!-- Registration Form -->
<section class="section">
    <div class="container" style="position: relative;">
        @guest
        <div class="login-overlay">
            <div class="login-overlay-content">
                <div style="text-align: center; margin-bottom: 20px;">
                    <i class="fas fa-lock" style="font-size: 3rem; color: var(--primary-blue);"></i>
                </div>
                <h3 style="color: var(--primary-blue); margin-bottom: 15px;">Login Diperlukan</h3>
                <p style="color: var(--text-light); margin-bottom: 25px;">
                    Silakan login terlebih dahulu untuk mengakses form pendaftaran.
                </p>
                <a href="{{ url('/#login-section') }}" class="btn btn-primary" style="width: 100%;">
                    <i class="fas fa-sign-in-alt"></i> Login Sekarang
                </a>
                <p style="text-align: center; margin-top: 15px; color: var(--text-light);">
                    Belum punya akun?
                    <a href="#" onclick="openModal('registerModal')" style="color: var(--primary-blue); font-weight: 600">Daftar di sini</a>
                </p>
            </div>
        </div>
        @endguest

        @if($gelombang->isEmpty())
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-triangle"></i>
            <strong>Peringatan:</strong> Tidak ada gelombang pendaftaran yang aktif saat ini.
            Silakan hubungi administrator.
        </div>
        @endif

        @if($jurusan->isEmpty())
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-triangle"></i>
            <strong>Peringatan:</strong> Tidak ada jurusan yang tersedia.
            Silakan hubungi administrator.
        </div>
        @endif

        <div class="form-container" id="registrationForm" style="@guest filter: blur(5px); pointer-events: none; @endguest">
            <!-- Navigation Buttons -->
            <div class="form-navigation">
                <button type="button" class="nav-btn prev-btn" onclick="singleFormNavigator.previousSection()">
                    <i class="fas fa-chevron-left"></i> Sebelumnya
                </button>
                <div class="section-indicators">
                    @foreach(['Data Diri', 'Sekolah Asal', 'Orang Tua', 'Berkas', 'Jurusan'] as $index => $label)
                    <div class="section-indicator {{ $index === 0 ? 'active' : '' }}"
                        data-section="{{ $index + 1 }}"
                        onclick="singleFormNavigator.goToSection({{ $index + 1 }})">
                        <span class="indicator-number">{{ $index + 1 }}</span>
                    </div>
                    @endforeach
                </div>
                <button type="button" class="nav-btn next-btn" onclick="singleFormNavigator.nextSection()">
                    Selanjutnya <i class="fas fa-chevron-right"></i>
                </button>
            </div>

            <!-- Single Form Container -->
            <form id="singleRegistrationForm" enctype="multipart/form-data">
                @csrf

                <!-- Section 1: Data Diri -->
                <div class="form-section active" id="section1">
                    <h3 class="section-title">
                        <i class="fas fa-user"></i> Data Pribadi
                    </h3>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="fullName">Nama Lengkap *</label>
                            <input type="text" id="fullName" name="fullName" required placeholder="Sesuai ijazah">
                        </div>

                        <div class="form-group">
                            <label for="nickname">Nama Panggilan</label>
                            <input type="text" id="nickname" name="nickname" placeholder="Opsional">
                        </div>

                        <div class="form-group">
                            <label for="nik">NIK (Nomor Induk Kependudukan) *</label>
                            <input type="text" id="nik" name="nik" required placeholder="16 digit NIK" pattern="[0-9]{16}" maxlength="16">
                            <div class="validation-message" id="nikValidation"></div>
                        </div>

                        <div class="form-group">
                            <label for="nisn">NISN (Nomor Induk Siswa Nasional) *</label>
                            <input type="text" id="nisn" name="nisn" required placeholder="10 digit NISN" pattern="[0-9]{10}" maxlength="10">
                            <div class="validation-message" id="nisnValidation"></div>
                        </div>

                        <div class="form-group">
                            <label for="birthPlace">Tempat Lahir *</label>
                            <input type="text" id="birthPlace" name="birthPlace" required placeholder="Kota/Kabupaten">
                        </div>

                        <div class="form-group">
                            <label for="birthDate">Tanggal Lahir *</label>
                            <input type="date" id="birthDate" name="birthDate" required>
                        </div>

                        <div class="form-group">
                            <label for="gender">Jenis Kelamin *</label>
                            <select id="gender" name="gender" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="religion">Agama *</label>
                            <select id="religion" name="religion" required>
                                <option value="">Pilih Agama</option>
                                <option value="Islam">Islam</option>
                                <option value="Kristen">Kristen</option>
                                <option value="Katolik">Katolik</option>
                                <option value="Hindu">Hindu</option>
                                <option value="Buddha">Buddha</option>
                                <option value="Konghucu">Konghucu</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="wilayah_id">Wilayah *</label>
                            <select id="wilayah_id" name="wilayah_id" required>
                                <option value="">Pilih Wilayah</option>
                                @foreach($wilayah as $item)
                                <option value="{{ $item->id }}">
                                    {{ $item->kelurahan }}, {{ $item->kecamatan }}, {{ $item->kabupaten }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group full-width">
                            <label for="address">Alamat Lengkap *</label>
                            <textarea id="address" name="address" rows="3" required placeholder="Jalan, RT/RW, Kelurahan, Kecamatan, Kota/Kabupaten, Provinsi"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="latitude">Latitude (Opsional)</label>
                            <input type="text" id="latitude" name="latitude" placeholder="Contoh: -6.2088">
                        </div>

                        <div class="form-group">
                            <label for="longitude">Longitude (Opsional)</label>
                            <input type="text" id="longitude" name="longitude" placeholder="Contoh: 106.8456">
                        </div>

                        <div class="form-group">
                            <label for="phone">Nomor Telepon *</label>
                            <input type="tel" id="phone" name="phone" required placeholder="08xxxxxxxxxx" pattern="[0-9]{10,13}">
                        </div>
                    </div>
                </div>

                <!-- Section 2: Sekolah Asal -->
                <div class="form-section" id="section2">
                    <h3 class="section-title">
                        <i class="fas fa-school"></i> Data Sekolah Asal
                    </h3>

                    <div class="form-grid">
                        <div class="form-group full-width">
                            <label for="schoolName">Nama Sekolah Asal *</label>
                            <input type="text" id="schoolName" name="schoolName" required placeholder="SMP Negeri/Swasta">
                        </div>

                        <div class="form-group">
                            <label for="schoolNpsn">NPSN Sekolah *</label>
                            <input type="text" id="schoolNpsn" name="schoolNpsn" required placeholder="8 digit NPSN" pattern="[0-9]{8}" maxlength="8">
                        </div>

                        <div class="form-group">
                            <label for="schoolAddress">Alamat Sekolah *</label>
                            <input type="text" id="schoolAddress" name="schoolAddress" required placeholder="Kota/Kabupaten">
                        </div>

                        <div class="form-group">
                            <label for="averageGrade">Nilai Rata-rata Rapor Kelas VIII *</label>
                            <input type="number" id="averageGrade" name="averageGrade" required placeholder="0-100" min="0" max="100" step="0.01">
                        </div>
                    </div>

                    <h4 class="subsection-title">Nilai Rapor Kelas VIII Semester 2</h4>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="mathGrade">Matematika</label>
                            <input type="number" id="mathGrade" name="mathGrade" placeholder="0-100" min="0" max="100">
                        </div>

                        <div class="form-group">
                            <label for="scienceGrade">IPA</label>
                            <input type="number" id="scienceGrade" name="scienceGrade" placeholder="0-100" min="0" max="100">
                        </div>

                        <div class="form-group">
                            <label for="englishGrade">Bahasa Inggris</label>
                            <input type="number" id="englishGrade" name="englishGrade" placeholder="0-100" min="0" max="100">
                        </div>

                        <div class="form-group">
                            <label for="indonesianGrade">Bahasa Indonesia</label>
                            <input type="number" id="indonesianGrade" name="indonesianGrade" placeholder="0-100" min="0" max="100">
                        </div>
                    </div>
                </div>

                <!-- Section 3: Orang Tua -->
                <div class="form-section" id="section3">
                    <h3 class="section-title">
                        <i class="fas fa-users"></i> Data Orang Tua/Wali
                    </h3>

                    <h4 class="subsection-title">Data Ayah</h4>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="fatherName">Nama Ayah Kandung *</label>
                            <input type="text" id="fatherName" name="fatherName" required>
                        </div>

                        <div class="form-group">
                            <label for="fatherJob">Pekerjaan Ayah *</label>
                            <input type="text" id="fatherJob" name="fatherJob" required>
                        </div>
                    </div>

                    <h4 class="subsection-title">Data Ibu</h4>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="motherName">Nama Ibu Kandung *</label>
                            <input type="text" id="motherName" name="motherName" required>
                        </div>

                        <div class="form-group">
                            <label for="motherJob">Pekerjaan Ibu *</label>
                            <input type="text" id="motherJob" name="motherJob" required>
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="parentPhone">Nomor HP Orang Tua *</label>
                            <input type="tel" id="parentPhone" name="parentPhone" required placeholder="08xxxxxxxxxx">
                        </div>

                        <div class="form-group">
                            <label for="parentIncome">Penghasilan Orang Tua *</label>
                            <select id="parentIncome" name="parentIncome" required>
                                <option value="">Pilih Range Penghasilan</option>
                                <option value="< 2.000.000">&lt; Rp 2.000.000</option>
                                <option value="2.000.000 - 5.000.000">Rp 2.000.000 - Rp 5.000.000</option>
                                <option value="5.000.000 - 10.000.000">Rp 5.000.000 - Rp 10.000.000</option>
                                <option value="> 10.000.000">&gt; Rp 10.000.000</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="waliName">Nama Wali</label>
                            <input type="text" id="waliName" name="waliName" placeholder="Opsional jika sama dengan orang tua">
                        </div>

                        <div class="form-group">
                            <label for="waliPhone">Nomor HP Wali</label>
                            <input type="tel" id="waliPhone" name="waliPhone" placeholder="08xxxxxxxxxx">
                        </div>
                    </div>

                    <div class="form-group full-width">
                        <label for="parentAddress">Alamat Orang Tua *</label>
                        <textarea id="parentAddress" name="parentAddress" rows="3" required placeholder="Jika sama dengan alamat siswa, tulis 'Sama dengan alamat siswa'"></textarea>
                    </div>
                </div>

                <!-- Section 4: Berkas -->
                <div class="form-section" id="section4">
                    <h3 class="section-title">
                        <i class="fas fa-upload"></i> Upload Berkas
                    </h3>

                    <div class="form-grid">
                        <div class="form-group full-width">
                            <label>Kartu Keluarga (KK) *</label>
                            <div class="file-upload-area" onclick="document.getElementById('kkFile').click()">
                                <i class="fas fa-cloud-upload-alt" style="font-size: 2rem; color: var(--primary-blue); margin-bottom: 10px;"></i>
                                <p>Klik untuk upload KK</p>
                                <small style="color: var(--text-light);">Format: PDF/JPG/PNG, Max: 2MB</small>
                            </div>
                            <input type="file" id="kkFile" name="kkFile" accept=".pdf,.jpg,.jpeg,.png" style="display: none;" onchange="singleFormNavigator.handleFileUpload(this, 'kkPreview')">
                            <div id="kkPreview" class="preview-container" style="display: none;"></div>
                        </div>

                        <div class="form-group full-width">
                            <label>Akta Kelahiran *</label>
                            <div class="file-upload-area" onclick="document.getElementById('aktaFile').click()">
                                <i class="fas fa-cloud-upload-alt" style="font-size: 2rem; color: var(--primary-blue); margin-bottom: 10px;"></i>
                                <p>Klik untuk upload Akta Kelahiran</p>
                                <small style="color: var(--text-light);">Format: PDF/JPG/PNG, Max: 2MB</small>
                            </div>
                            <input type="file" id="aktaFile" name="aktaFile" accept=".pdf,.jpg,.jpeg,.png" style="display: none;" onchange="singleFormNavigator.handleFileUpload(this, 'aktaPreview')">
                            <div id="aktaPreview" class="preview-container" style="display: none;"></div>
                        </div>

                        <div class="form-group full-width">
                            <label>Ijazah/SKHUN *</label>
                            <div class="file-upload-area" onclick="document.getElementById('ijazahFile').click()">
                                <i class="fas fa-cloud-upload-alt" style="font-size: 2rem; color: var(--primary-blue); margin-bottom: 10px;"></i>
                                <p>Klik untuk upload Ijazah/SKHUN</p>
                                <small style="color: var(--text-light);">Format: PDF/JPG/PNG, Max: 2MB</small>
                            </div>
                            <input type="file" id="ijazahFile" name="ijazahFile" accept=".pdf,.jpg,.jpeg,.png" style="display: none;" onchange="singleFormNavigator.handleFileUpload(this, 'ijazahPreview')">
                            <div id="ijazahPreview" class="preview-container" style="display: none;"></div>
                        </div>

                        <div class="form-group full-width">
                            <label>Kartu Indonesia Pintar (KIP) - Optional</label>
                            <div class="file-upload-area" onclick="document.getElementById('kipFile').click()">
                                <i class="fas fa-cloud-upload-alt" style="font-size: 2rem; color: var(--primary-blue); margin-bottom: 10px;"></i>
                                <p>Klik untuk upload KIP</p>
                                <small style="color: var(--text-light);">Format: PDF/JPG/PNG, Max: 2MB</small>
                            </div>
                            <input type="file" id="kipFile" name="kipFile" accept=".pdf,.jpg,.jpeg,.png" style="display: none;" onchange="singleFormNavigator.handleFileUpload(this, 'kipPreview')">
                            <div id="kipPreview" class="preview-container" style="display: none;"></div>
                        </div>

                        <div class="form-group full-width">
                            <label>Kartu Keluarga Sejahtera (KKS) - Optional</label>
                            <div class="file-upload-area" onclick="document.getElementById('kksFile').click()">
                                <i class="fas fa-cloud-upload-alt" style="font-size: 2rem; color: var(--primary-blue); margin-bottom: 10px;"></i>
                                <p>Klik untuk upload KKS</p>
                                <small style="color: var(--text-light);">Format: PDF/JPG/PNG, Max: 2MB</small>
                            </div>
                            <input type="file" id="kksFile" name="kksFile" accept=".pdf,.jpg,.jpeg,.png" style="display: none;" onchange="singleFormNavigator.handleFileUpload(this, 'kksPreview')">
                            <div id="kksPreview" class="preview-container" style="display: none;"></div>
                        </div>

                        <div class="form-group full-width">
                            <label>Rapor Kelas VIII *</label>
                            <div class="file-upload-area" onclick="document.getElementById('raporFile').click()">
                                <i class="fas fa-cloud-upload-alt" style="font-size: 2rem; color: var(--primary-blue); margin-bottom: 10px;"></i>
                                <p>Klik untuk upload Rapor</p>
                                <small style="color: var(--text-light);">Format: PDF/JPG/PNG, Max: 2MB</small>
                            </div>
                            <input type="file" id="raporFile" name="raporFile" accept=".pdf,.jpg,.jpeg,.png" style="display: none;" onchange="singleFormNavigator.handleFileUpload(this, 'raporPreview')">
                            <div id="raporPreview" class="preview-container" style="display: none;"></div>
                        </div>

                        <div class="form-group full-width">
                            <label>Pas Foto 3x4 *</label>
                            <div class="file-upload-area" onclick="document.getElementById('photoFile').click()">
                                <i class="fas fa-cloud-upload-alt" style="font-size: 2rem; color: var(--primary-blue); margin-bottom: 10px;"></i>
                                <p>Klik untuk upload Pas Foto</p>
                                <small style="color: var(--text-light);">Format: JPG/PNG, Max: 1MB, Background merah/blue</small>
                            </div>
                            <input type="file" id="photoFile" name="photoFile" accept=".jpg,.jpeg,.png" style="display: none;" onchange="singleFormNavigator.handleFileUpload(this, 'photoPreview')">
                            <div id="photoPreview" class="preview-container" style="display: none;"></div>
                        </div>

                        <div class="form-group full-width">
                            <label>Sertifikat Prestasi (Optional)</label>
                            <div class="file-upload-area" onclick="document.getElementById('certificateFile').click()">
                                <i class="fas fa-cloud-upload-alt" style="font-size: 2rem; color: var(--primary-blue); margin-bottom: 10px;"></i>
                                <p>Klik untuk upload Sertifikat</p>
                                <small style="color: var(--text-light);">Format: PDF/JPG/PNG, Max: 2MB</small>
                            </div>
                            <input type="file" id="certificateFile" name="certificateFile" accept=".pdf,.jpg,.jpeg,.png" style="display: none;" onchange="singleFormNavigator.handleFileUpload(this, 'certificatePreview')">
                            <div id="certificatePreview" class="preview-container" style="display: none;"></div>
                        </div>
                    </div>
                </div>

                <!-- Section 5: Jurusan -->
                <div class="form-section" id="section5">
                    <h3 class="section-title">
                        <i class="fas fa-graduation-cap"></i> Pilihan Jurusan
                    </h3>

                    @if($jurusan->isEmpty())
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle"></i>
                        <strong>Error:</strong> Data jurusan belum tersedia.
                        <br><small>Silakan hubungi administrator atau refresh halaman.</small>
                    </div>
                    @else
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="gelombang_id">Gelombang Pendaftaran *</label>
                            <select id="gelombang_id" name="gelombang_id" required>
                                <option value="">Pilih Gelombang</option>
                                @foreach($gelombang as $item)
                                <option value="{{ $item->id }}">
                                    {{ $item->nama }}
                                    @if(isset($item->tgl_mulai) && isset($item->tgl_selesai))
                                    ({{ \Carbon\Carbon::parse($item->tgl_mulai)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($item->tgl_selesai)->format('d/m/Y') }})
                                    @endif
                                    @if(isset($item->biaya_daftar))
                                    - Rp {{ number_format($item->biaya_daftar, 0, ',', '.') }}
                                    @endif
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="jurusan_id">Pilihan Jurusan *</label>
                            <select id="jurusan_id" name="jurusan_id" required>
                                <option value="">Pilih Jurusan</option>
                                @foreach($jurusan as $item)
                                <option value="{{ $item->id }}">
                                    {{ $item->kode }} - {{ $item->nama }}
                                    @if(isset($item->kuota))
                                    (Kuota: {{ $item->kuota }})
                                    @endif
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Submit Section -->
                <div class="form-section" id="submitSection">
                    <div class="agreement-section">
                        <label class="agreement-checkbox">
                            <input type="checkbox" id="agreement" name="agreement" required>
                            <span class="checkmark"></span>
                            Saya menyatakan bahwa semua data yang saya isi adalah benar dan dapat dipertanggungjawabkan.
                        </label>
                    </div>

                    <div class="submit-actions">
                        <button type="button" onclick="singleFormNavigator.previousSection()" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali ke Data Jurusan
                        </button>
                        <button type="button" onclick="singleFormNavigator.submitForm()" class="btn btn-primary btn-submit">
                            <i class="fas fa-paper-plane"></i> Kirim Pendaftaran
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<style>
    /* Navigation Styles */
    .form-navigation {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 2rem;
        padding: 1rem;
        background: var(--light-blue);
        border-radius: 15px;
        gap: 1rem;
    }

    .nav-btn {
        background: var(--primary-blue);
        color: white;
        border: none;
        padding: 12px 20px;
        border-radius: 10px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
        white-space: nowrap;
    }

    .nav-btn:hover:not(:disabled) {
        background: var(--dark-blue);
        transform: translateY(-2px);
    }

    .nav-btn:disabled {
        background: #ccc;
        cursor: not-allowed;
        transform: none;
        opacity: 0.6;
    }

    .section-indicators {
        display: flex;
        gap: 0.5rem;
        flex: 1;
        justify-content: center;
        flex-wrap: wrap;
    }

    .section-indicator {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
        padding: 0.5rem;
        border-radius: 10px;
        transition: all 0.3s ease;
        min-width: 80px;
    }

    .section-indicator:hover {
        background: rgba(59, 130, 246, 0.1);
    }

    .section-indicator.active {
        background: var(--primary-blue);
        color: white;
    }

    .indicator-number {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 0.9rem;
        background: #e5e7eb;
        color: #6b7280;
        transition: all 0.3s ease;
    }

    .section-indicator.active .indicator-number {
        background: white;
        color: var(--primary-blue);
    }

    .indicator-label {
        font-size: 0.75rem;
        text-align: center;
        font-weight: 500;
    }

    /* Form Sections */
    .form-section {
        display: none;
        animation: fadeIn 0.5s ease-in;
        padding: 2rem;
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        margin-bottom: 2rem;
    }

    .form-section.active {
        display: block;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .section-title {
        text-align: center;
        margin-bottom: 2rem;
        color: var(--primary-blue);
        font-size: 1.5rem;
        border-bottom: 2px solid var(--light-blue);
        padding-bottom: 1rem;
    }

    .subsection-title {
        color: var(--primary-blue);
        margin: 2rem 0 1rem 0;
        font-size: 1.2rem;
        border-left: 4px solid var(--primary-blue);
        padding-left: 1rem;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
    }

    .form-group.full-width {
        grid-column: 1 / -1;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group label {
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--dark-blue);
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        padding: 12px 15px;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        border-color: var(--primary-blue);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        outline: none;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .form-navigation {
            flex-direction: column;
            gap: 1rem;
        }

        .section-indicators {
            order: -1;
            width: 100%;
            overflow-x: auto;
            justify-content: flex-start;
            padding-bottom: 0.5rem;
        }

        .nav-btn {
            width: 100%;
            justify-content: center;
        }

        .form-grid {
            grid-template-columns: 1fr;
        }

        .form-section {
            padding: 1.5rem;
            margin-bottom: 1rem;
        }
    }

    /* Agreement Checkbox */
    .agreement-section {
        margin: 2rem 0;
        padding: 1.5rem;
        background: var(--light-blue);
        border-radius: 10px;
        border-left: 4px solid var(--primary-blue);
    }

    .agreement-checkbox {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        cursor: pointer;
        font-weight: 500;
        color: var(--dark-blue);
        margin: 0;
    }

    .agreement-checkbox input {
        margin-top: 0.25rem;
        transform: scale(1.2);
    }

    .submit-actions {
        display: flex;
        gap: 1rem;
        justify-content: center;
        margin-top: 2rem;
    }

    .btn-submit {
        padding: 1rem 2rem;
        font-size: 1.1rem;
        background: linear-gradient(135deg, #10b981, #059669);
        border: none;
        flex: 1;
        max-width: 300px;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(16, 185, 129, 0.3);
    }

    /* File Upload Styles */
    .file-upload-area {
        border: 2px dashed #e5e7eb;
        border-radius: 10px;
        padding: 30px 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        background: #f9fafb;
    }

    .file-upload-area:hover {
        border-color: var(--primary-blue);
        background: var(--light-blue);
    }

    .preview-container {
        margin-top: 10px;
    }

    .file-preview {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px;
        background: #f3f4f6;
        border-radius: 8px;
        margin-top: 10px;
    }

    /* Validation Messages */
    .validation-message {
        font-size: 0.875rem;
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .validation-message.error {
        color: #ef4444;
    }

    .validation-message.success {
        color: #10b981;
    }

    /* Alert Styles */
    .alert {
        padding: 1rem 1.5rem;
        border-radius: 10px;
        margin-bottom: 2rem;
        border-left: 4px solid;
    }

    .alert-danger {
        background: #fef2f2;
        border-color: #ef4444;
        color: #dc2626;
    }

    .alert-warning {
        background: #fffbeb;
        border-color: #f59e0b;
        color: #d97706;
    }

    .alert-info {
        background: #eff6ff;
        border-color: #3b82f6;
        color: #1d4ed8;
    }
</style>

<script>
    class SingleFormNavigator {
        constructor() {
            this.currentSection = 1;
            this.totalSections = 5; // Diubah dari 6 menjadi 5
            this.formData = new FormData();
            this.init();
        }

        init() {
            this.showSection(this.currentSection);
            this.updateNavigation();
            this.setupEventListeners();
            this.loadFromLocalStorage();
        }

        setupEventListeners() {
            // Real-time validation
            this.setupRealTimeValidation();

            // Auto-save on input change
            document.querySelectorAll('#singleRegistrationForm input, #singleRegistrationForm select, #singleRegistrationForm textarea').forEach(element => {
                element.addEventListener('change', () => {
                    this.saveToLocalStorage();
                });

                element.addEventListener('input', () => {
                    this.saveToLocalStorage();
                });
            });

            // Keyboard navigation
            document.addEventListener('keydown', (e) => {
                if (e.key === 'ArrowLeft' && !e.ctrlKey && !e.metaKey) {
                    this.previousSection();
                } else if (e.key === 'ArrowRight' && !e.ctrlKey && !e.metaKey) {
                    this.nextSection();
                }
            });
        }

        showSection(sectionNumber) {
            // Hide all sections
            document.querySelectorAll('.form-section').forEach(section => {
                section.classList.remove('active');
            });

            // Show current section
            const currentSection = document.getElementById(`section${sectionNumber}`);
            if (currentSection) {
                currentSection.classList.add('active');
            }

            // Show submit section only on last section
            const submitSection = document.getElementById('submitSection');
            if (submitSection) {
                if (sectionNumber === this.totalSections) {
                    submitSection.classList.add('active');
                } else {
                    submitSection.classList.remove('active');
                }
            }

            this.updateNavigation();

            // Scroll to top of form
            const formContainer = document.querySelector('.form-container');
            if (formContainer) {
                formContainer.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                })
            }
        }

        validateSection(sectionNumber) {
            const section = document.getElementById(`section${sectionNumber}`);
            if (!section) return true;

            const requiredFields = section.querySelectorAll('[required]');
            let isValid = true;

            requiredFields.forEach(field => {
                // Skip validation for optional file fields
                if (field.type === 'file' && !field.files.length && field.hasAttribute('required')) {
                    const label = field.closest('.form-group')?.querySelector('label');
                    if (label && label.textContent.includes('Optional')) {
                        return;
                    }
                }

                if (!field.value.trim() && field.type !== 'file') {
                    isValid = false;
                    this.highlightError(field);
                } else {
                    this.removeErrorHighlight(field);
                }

                // Special validations
                if (field.id === 'nisn' && field.value) {
                    if (field.value.length !== 10 || !/^\d+$/.test(field.value)) {
                        isValid = false;
                        this.highlightError(field);
                    }
                }

                if (field.id === 'nik' && field.value) {
                    if (field.value.length !== 16 || !/^\d+$/.test(field.value)) {
                        isValid = false;
                        this.highlightError(field);
                    }
                }

                if (field.id === 'schoolNpsn' && field.value) {
                    if (field.value.length !== 8 || !/^\d+$/.test(field.value)) {
                        isValid = false;
                        this.highlightError(field);
                    }
                }
            });

            return isValid;
        }

        updateNavigation() {
            // Update section indicators
            document.querySelectorAll('.section-indicator').forEach((indicator, index) => {
                if (index + 1 === this.currentSection) {
                    indicator.classList.add('active');
                } else {
                    indicator.classList.remove('active');
                }
            });

            // Update navigation buttons
            const prevBtn = document.querySelector('.prev-btn');
            const nextBtn = document.querySelector('.next-btn');

            if (prevBtn) {
                prevBtn.disabled = this.currentSection === 1;
                if (this.currentSection === 1) {
                    prevBtn.style.visibility = 'hidden';
                } else {
                    prevBtn.style.visibility = 'visible';
                }
            }

            if (nextBtn) {
                if (this.currentSection === this.totalSections) {
                    nextBtn.style.display = 'none';
                } else {
                    nextBtn.style.display = 'flex';
                    nextBtn.disabled = false;
                }
            }
        }

        nextSection() {
            if (this.validateCurrentSection()) {
                if (this.currentSection < this.totalSections) {
                    this.currentSection++;
                    this.showSection(this.currentSection);
                }
            } else {
                this.showNotification('Mohon lengkapi semua field yang wajib diisi pada section ini', 'error');
            }
        }

        previousSection() {
            if (this.currentSection > 1) {
                this.currentSection--;
                this.showSection(this.currentSection);
            }
        }

        goToSection(sectionNumber) {
            if (sectionNumber >= 1 && sectionNumber <= this.totalSections) {
                // Validate all previous sections
                let canNavigate = true;
                for (let i = 1; i < sectionNumber; i++) {
                    if (!this.validateSection(i)) {
                        canNavigate = false;
                        this.showNotification(`Mohon lengkapi section ${i} terlebih dahulu`, 'error');
                        break;
                    }
                }

                if (canNavigate) {
                    this.currentSection = sectionNumber;
                    this.showSection(this.currentSection);
                }
            }
        }

        validateCurrentSection() {
            return this.validateSection(this.currentSection);
        }

        validateEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }

        highlightError(field) {
            field.style.borderColor = '#ef4444';
            field.style.boxShadow = '0 0 0 3px rgba(239, 68, 68, 0.1)';
        }

        removeErrorHighlight(field) {
            field.style.borderColor = '';
            field.style.boxShadow = '';
        }

        setupRealTimeValidation() {
            const nisnInput = document.getElementById('nisn');
            if (nisnInput) {
                nisnInput.addEventListener('blur', () => {
                    this.validateNisnField(nisnInput.value);
                });
            }

            const nikInput = document.getElementById('nik');
            if (nikInput) {
                nikInput.addEventListener('blur', () => {
                    this.validateNikField(nikInput.value);
                });
            }
        }

        validateNisnField(nisn) {
            const validationElement = document.getElementById('nisnValidation');
            if (nisn.length !== 10 || !/^\d+$/.test(nisn)) {
                this.showFieldError(validationElement, 'NISN harus 10 digit angka');
                return false;
            } else {
                // Check if NISN already exists
                fetch(`/pendaftaran/check-nisn/${nisn}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.exists) {
                            this.showFieldError(validationElement, 'NISN sudah terdaftar');
                        } else {
                            this.showFieldSuccess(validationElement, 'NISN valid');
                        }
                    });
                return true;
            }
        }

        validateNikField(nik) {
            const validationElement = document.getElementById('nikValidation');
            if (nik.length !== 16 || !/^\d+$/.test(nik)) {
                this.showFieldError(validationElement, 'NIK harus 16 digit angka');
                return false;
            } else {
                // Check if NIK already exists
                fetch(`/pendaftaran/check-nik/${nik}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.exists) {
                            this.showFieldError(validationElement, 'NIK sudah terdaftar');
                        } else {
                            this.showFieldSuccess(validationElement, 'NIK valid');
                        }
                    });
                return true;
            }
        }

        showFieldError(element, message) {
            if (element) {
                element.innerHTML = `<i class="fas fa-times-circle"></i> ${message}`;
                element.className = 'validation-message error';
            }
        }

        showFieldSuccess(element, message) {
            if (element) {
                element.innerHTML = `<i class="fas fa-check-circle"></i> ${message}`;
                element.className = 'validation-message success';
            }
        }

        async submitForm() {
            if (!this.validateAllSections()) {
                this.showNotification('Mohon lengkapi semua field yang wajib diisi', 'error');
                return;
            }

            if (!document.getElementById('agreement').checked) {
                this.showNotification('Anda harus menyetujui persyaratan', 'error');
                return;
            }

            const submitBtn = document.querySelector('.btn-submit');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengirim Pendaftaran...';
            submitBtn.disabled = true;

            try {
                const formData = new FormData(document.getElementById('singleRegistrationForm'));

                // Removed debug console logs

                const response = await fetch('{{ route("pendaftaran.complete") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (data.success) {
                    this.showRegistrationSuccess(data.no_pendaftaran);
                    this.clearLocalStorage();
                } else {
                    let errorMessage = data.message || 'Terjadi kesalahan';
                    if (data.errors) {
                        const errorDetails = Object.values(data.errors).flat().join(', ');
                        errorMessage += ': ' + errorDetails;
                    }
                    this.showNotification(errorMessage, 'error');
                    console.error('Validation errors:', data.errors);
                }
            } catch (error) {
                console.error('Submit error:', error);
                this.showNotification('Terjadi kesalahan jaringan: ' + error.message, 'error');
            } finally {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
        }

        validateAllSections() {
            for (let i = 1; i <= this.totalSections; i++) {
                if (!this.validateSection(i)) {
                    this.goToSection(i);
                    return false;
                }
            }
            return true;
        }

        saveToLocalStorage() {
            try {
                const formData = {};
                document.querySelectorAll('#singleRegistrationForm input, #singleRegistrationForm select, #singleRegistrationForm textarea').forEach(element => {
                    if (element.name && !element.type.includes('file')) {
                        formData[element.name] = element.value;
                    }
                });
                localStorage.setItem('pendaftaranForm', JSON.stringify(formData));
            } catch (e) {
                console.error('Error saving to localStorage:', e);
            }
        }

        loadFromLocalStorage() {
            try {
                const savedData = localStorage.getItem('pendaftaranForm');
                if (savedData) {
                    const formData = JSON.parse(savedData);
                    Object.keys(formData).forEach(key => {
                        const element = document.querySelector(`[name="${key}"]`);
                        if (element && element.type !== 'file') {
                            element.value = formData[key];
                        }
                    });

                    // Show success message
                    this.showNotification('Data sebelumnya berhasil dimuat', 'success');
                }
            } catch (e) {
                console.error('Error loading from localStorage:', e);
            }
        }

        clearLocalStorage() {
            localStorage.removeItem('pendaftaranForm');
        }

        showNotification(message, type = 'info') {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `alert alert-${type === 'error' ? 'danger' : type === 'success' ? 'success' : 'info'}`;
            notification.innerHTML = `
            <i class="fas fa-${this.getNotificationIcon(type)}"></i> 
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

        getNotificationIcon(type) {
            const icons = {
                success: 'check-circle',
                error: 'exclamation-triangle',
                warning: 'exclamation-circle',
                info: 'info-circle'
            };
            return icons[type] || 'info-circle';
        }

        showRegistrationSuccess(registrationNumber) {
            const successModal = document.createElement('div');
            successModal.className = 'modal';
            successModal.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10000;
        `;

            successModal.innerHTML = `
            <div class="modal-content" style="
                background: white;
                padding: 40px;
                border-radius: 20px;
                text-align: center;
                max-width: 500px;
                width: 90%;
                box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            ">
                <div style="font-size: 4rem; color: #10b981; margin-bottom: 20px;">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h3 style="color: var(--primary-blue); margin-bottom: 15px;">Pendaftaran Berhasil!</h3>
                <p style="color: var(--text-light); margin-bottom: 20px;">
                    Selamat! Anda telah berhasil mendaftar SPMB.
                </p>
                <div style="background: var(--light-blue); padding: 20px; border-radius: 10px; margin: 20px 0;">
                    <h4 style="color: var(--primary-blue); margin-bottom: 10px;">Nomor Pendaftaran Anda</h4>
                    <div style="font-size: 1.5rem; font-weight: bold; color: var(--dark-blue);">${registrationNumber}</div>
                    <small style="color: var(--text-light);">Simpan nomor ini untuk cek status pendaftaran</small>
                </div>
                <div style="display: flex; gap: 15px; justify-content: center; margin-top: 30px; flex-wrap: wrap;">
                    <button onclick="window.print()" class="btn btn-primary">
                        <i class="fas fa-print"></i> Cetak Bukti
                    </button>
                    <button onclick="window.location.href='/dashboard'" class="btn btn-secondary">
                        <i class="fas fa-tachometer-alt"></i> Ke Dashboard
                    </button>
                    <button onclick="this.closest('.modal').remove()" class="btn btn-outline">
                        <i class="fas fa-times"></i> Tutup
                    </button>
                </div>
            </div>
        `;

            document.body.appendChild(successModal);
        }

        handleFileUpload(inputElement, previewId) {
            const file = inputElement.files[0];
            const previewContainer = document.getElementById(previewId);

            if (file) {
                previewContainer.style.display = 'block';
                previewContainer.innerHTML = `
                <div class="file-preview">
                    <i class="fas fa-file"></i>
                    <span>${file.name}</span>
                    <small>(${(file.size / 1024 / 1024).toFixed(2)} MB)</small>
                    <button onclick="this.parentElement.remove(); document.getElementById('${inputElement.id}').value = '';" 
                            style="margin-left: auto; background: none; border: none; color: #ef4444; cursor: pointer;">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
            }
        }
    }

    // Initialize the form navigator
    const singleFormNavigator = new SingleFormNavigator();
</script>
@endsection