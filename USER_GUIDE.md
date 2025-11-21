# 📚 USER GUIDE - SISTEM PPDB SMK BAKTI NUSANTARA 666

## 📋 Daftar Isi
1. [Pengenalan Sistem](#pengenalan-sistem)
2. [Panduan untuk Calon Siswa](#panduan-untuk-calon-siswa)
3. [Panduan untuk Admin](#panduan-untuk-admin)
4. [Panduan untuk Verifikator](#panduan-untuk-verifikator)
5. [Panduan untuk Keuangan](#panduan-untuk-keuangan)
6. [Panduan untuk Kepala Sekolah](#panduan-untuk-kepala-sekolah)
7. [FAQ & Troubleshooting](#faq--troubleshooting)

---

## 🎯 Pengenalan Sistem

Sistem PPDB (Penerimaan Peserta Didik Baru) SMK Bakti Nusantara 666 adalah aplikasi web yang memfasilitasi proses pendaftaran siswa baru secara online dengan workflow yang terintegrasi.

### Fitur Utama:
- ✅ Pendaftaran online multi-step
- ✅ Verifikasi OTP via email
- ✅ Upload berkas digital
- ✅ Sistem multi-role (Admin, Verifikator, Keuangan, Kepsek)
- ✅ Laporan dan export data
- ✅ Peta sebaran pendaftar
- ✅ Notifikasi real-time

---

## 👨‍🎓 Panduan untuk Calon Siswa

### 1. Mengakses Sistem
- Buka browser dan kunjungi website sekolah
- Klik menu **"Pendaftaran"** di halaman utama

### 2. Proses Pendaftaran (6 Langkah)

#### **Step 1: Data Akun**
1. Isi form pendaftaran:
   - Email (akan digunakan untuk login)
   - Password
   - Konfirmasi password
2. Klik **"Lanjut ke Step 2"**
3. Cek email untuk kode OTP
4. Masukkan kode OTP untuk verifikasi

#### **Step 2: Data Pribadi Siswa**
1. Isi data lengkap:
   - NISN (akan divalidasi otomatis)
   - Nama lengkap
   - Tempat, tanggal lahir
   - Jenis kelamin
   - Agama
   - Alamat lengkap
2. Pilih wilayah (Provinsi → Kabupaten → Kecamatan → Kelurahan)
3. Klik **"Lanjut ke Step 3"**

#### **Step 3: Data Orang Tua**
1. Isi data ayah dan ibu:
   - Nama lengkap
   - Pekerjaan
   - Penghasilan
   - No. HP
2. Klik **"Lanjut ke Step 4"**

#### **Step 4: Data Asal Sekolah**
1. Isi informasi sekolah asal:
   - Nama sekolah
   - Alamat sekolah
   - Tahun lulus
   - Nilai rata-rata
2. Klik **"Lanjut ke Step 5"**

#### **Step 5: Pilihan Jurusan**
1. Pilih gelombang pendaftaran
2. Pilih jurusan yang diinginkan
3. Lihat kuota yang tersedia
4. Klik **"Lanjut ke Step 6"**

#### **Step 6: Upload Berkas**
1. Upload berkas yang diperlukan:
   - Foto 3x4
   - Kartu Keluarga
   - Akta Kelahiran
   - Ijazah/SKHUN
   - Rapor semester terakhir
2. Format file: JPG, PNG, PDF (max 2MB)
3. Klik **"Selesaikan Pendaftaran"**

### 3. Setelah Pendaftaran

#### **Login ke Dashboard**
1. Gunakan email dan password yang sudah didaftarkan
2. Akses dashboard peserta

#### **Fitur Dashboard Peserta:**
- **Status Pendaftaran**: Lihat progress verifikasi
- **Notifikasi**: Pesan dari admin/verifikator
- **Upload Ulang**: Jika berkas ditolak
- **Bukti Pembayaran**: Upload setelah transfer
- **Kartu Pendaftaran**: Download PDF

#### **Status Pendaftaran:**
- 🟡 **PENDING**: Menunggu verifikasi admin
- 🟢 **ADM_PASS**: Lolos verifikasi administrasi
- 🔴 **ADM_REJECT**: Ditolak verifikasi administrasi
- 💰 **PAID**: Pembayaran sudah diverifikasi
- 🎉 **LULUS**: Diterima sebagai siswa baru

### 4. Pembayaran
1. Setelah status **ADM_PASS**, lakukan pembayaran sesuai instruksi
2. Upload bukti pembayaran di dashboard
3. Tunggu verifikasi dari bagian keuangan

### 5. Pengumuman
- Cek pengumuman di halaman **"Pengumuman"**
- Masukkan nomor pendaftaran untuk cek status
- Download kartu pendaftaran jika diterima

---

## 👨‍💼 Panduan untuk Admin

### 1. Login Admin
- Akses: `/admin/login`
- Gunakan kredensial admin yang diberikan

### 2. Dashboard Admin
- Lihat statistik pendaftar
- Monitor aktivitas sistem
- Akses menu navigasi

### 3. Master Data Management

#### **Kelola Jurusan**
1. Menu: **Master Data → Jurusan**
2. Fitur:
   - Tambah jurusan baru
   - Edit nama dan kuota jurusan
   - Hapus jurusan
   - Set status aktif/nonaktif

#### **Kelola Gelombang**
1. Menu: **Master Data → Gelombang**
2. Fitur:
   - Buat gelombang pendaftaran baru
   - Set tanggal mulai dan berakhir
   - Atur biaya pendaftaran
   - Status aktif/nonaktif

#### **Kelola Wilayah**
1. Menu: **Master Data → Wilayah**
2. Fitur:
   - Tambah data wilayah baru
   - Edit koordinat untuk peta
   - Import data wilayah
   - Quick add wilayah

### 4. Monitoring & Laporan

#### **Monitoring Pendaftar**
1. Menu: **Monitoring Pendaftar**
2. Fitur:
   - View semua data pendaftar
   - Filter berdasarkan status
   - Detail lengkap pendaftar
   - Export data

#### **Peta Sebaran**
1. Menu: **Peta Sebaran**
2. Fitur:
   - Visualisasi sebaran pendaftar
   - Filter berdasarkan wilayah
   - Statistik per kecamatan

#### **Laporan**
1. Menu: **Laporan → Pendaftar**
2. Fitur:
   - Generate laporan Excel/PDF
   - Filter berdasarkan periode
   - Export manual/otomatis

### 5. User Management
1. Menu: **Akun**
2. Fitur:
   - Tambah user baru (Verifikator, Keuangan, Kepsek)
   - Edit profil user
   - Reset password
   - Aktifkan/nonaktifkan akun

### 6. Log Aktivitas
1. Menu: **Log Aktivitas**
2. Fitur:
   - Monitor semua aktivitas sistem
   - Filter berdasarkan user/tanggal
   - Export log

---

## 🔍 Panduan untuk Verifikator

### 1. Login Verifikator
- Akses: `/admin/login`
- Pilih role: Verifikator

### 2. Dashboard Verifikator
- Statistik pendaftar yang perlu diverifikasi
- Quick access ke data pendaftar

### 3. Verifikasi Data Pendaftar

#### **Melihat Data Pendaftar**
1. Menu: **Data Pendaftar**
2. Filter berdasarkan:
   - Status verifikasi
   - Gelombang
   - Jurusan
   - Tanggal daftar

#### **Proses Verifikasi**
1. Klik **"Detail"** pada pendaftar
2. Review semua data:
   - Data pribadi siswa
   - Data orang tua
   - Data asal sekolah
   - Berkas yang diupload
3. Beri keputusan:
   - **LULUS**: Jika semua data valid
   - **TOLAK**: Jika ada data yang tidak sesuai
4. Tambahkan catatan jika diperlukan

#### **Fitur Verifikasi:**
- ✅ Zoom berkas untuk detail
- ✅ Download berkas
- ✅ Validasi NISN
- ✅ Cek duplikasi data
- ✅ Catatan verifikasi

### 4. Laporan Verifikasi
1. Menu: **Laporan**
2. Generate laporan verifikasi
3. Export ke Excel/PDF

---

## 💰 Panduan untuk Keuangan

### 1. Login Keuangan
- Akses: `/admin/login`
- Pilih role: Keuangan

### 2. Dashboard Keuangan
- Statistik pembayaran
- Pendaftar yang perlu validasi pembayaran

### 3. Validasi Pembayaran

#### **Melihat Bukti Pembayaran**
1. Menu: **Validasi Pembayaran**
2. Filter berdasarkan:
   - Status pembayaran
   - Tanggal upload
   - Jumlah pembayaran

#### **Proses Validasi**
1. Klik **"Detail"** pada pendaftar
2. Review bukti pembayaran:
   - Cek kesesuaian jumlah
   - Validasi rekening tujuan
   - Cek tanggal transfer
3. Beri keputusan:
   - **VALID**: Jika pembayaran sesuai
   - **INVALID**: Jika ada ketidaksesuaian
4. Tambahkan catatan

### 4. Laporan Keuangan
1. Menu: **Laporan Keuangan**
2. Generate laporan pembayaran
3. Export ke Excel/PDF
4. Rekap per periode

---

## 🏫 Panduan untuk Kepala Sekolah

### 1. Login Kepala Sekolah
- Akses: `/admin/login`
- Pilih role: Kepala Sekolah

### 2. Dashboard Kepala Sekolah
- Overview statistik PPDB
- Grafik pendaftar per jurusan
- Status keseluruhan

### 3. Hasil Seleksi

#### **Melihat Hasil Seleksi**
1. Menu: **Hasil Seleksi**
2. Filter berdasarkan:
   - Jurusan
   - Status seleksi
   - Gelombang

#### **Seleksi Final**
1. Review pendaftar yang sudah lolos administrasi dan pembayaran
2. Lakukan seleksi akhir berdasarkan:
   - Nilai rapor
   - Kuota jurusan
   - Kriteria lainnya
3. Set status final: **DITERIMA** atau **TIDAK DITERIMA**

### 4. Export & Print
1. **Export Excel**: Data lengkap hasil seleksi
2. **Print PDF**: Dokumen resmi pengumuman
3. **Surat Keputusan**: Generate SK penerimaan

---

## ❓ FAQ & Troubleshooting

### Untuk Calon Siswa

**Q: Tidak menerima kode OTP?**
A: 
- Cek folder spam/junk email
- Pastikan email yang dimasukkan benar
- Klik "Kirim Ulang OTP"
- Tunggu 2-3 menit

**Q: NISN tidak valid?**
A: 
- Pastikan NISN 10 digit
- Cek dengan data di sekolah asal
- Hubungi admin jika masih bermasalah

**Q: File tidak bisa diupload?**
A:
- Maksimal ukuran file 2MB
- Format yang diterima: JPG, PNG, PDF
- Pastikan koneksi internet stabil

**Q: Lupa password?**
A: Hubungi admin sekolah untuk reset password

### Untuk Admin/Staff

**Q: Data pendaftar tidak muncul?**
A:
- Refresh halaman
- Cek filter yang diterapkan
- Pastikan koneksi database

**Q: Export gagal?**
A:
- Cek permission folder storage
- Pastikan tidak ada karakter khusus
- Coba dengan data yang lebih sedikit

**Q: Peta tidak muncul?**
A:
- Cek koneksi internet
- Pastikan koordinat wilayah sudah diisi
- Clear browser cache

### Kontak Support
- **Email**: admin@smkbaktinusantara666.sch.id
- **WhatsApp**: 0812-3456-7890
- **Jam Operasional**: 08:00 - 16:00 WIB

---

## 🔧 Informasi Teknis

### Persyaratan Sistem
- **Browser**: Chrome, Firefox, Safari (versi terbaru)
- **Koneksi Internet**: Minimal 1 Mbps
- **JavaScript**: Harus diaktifkan
- **Cookies**: Harus diaktifkan

### Keamanan Data
- Data dienkripsi dengan SSL
- Password di-hash dengan bcrypt
- Session timeout 2 jam
- Log aktivitas tersimpan

### Backup & Recovery
- Backup otomatis setiap hari
- Data tersimpan di cloud storage
- Recovery point 30 hari

---

*User Guide ini dibuat untuk membantu semua pengguna sistem PPDB SMK Bakti Nusantara 666. Jika ada pertanyaan lebih lanjut, silakan hubungi tim support.*

**Versi**: 1.0  
**Terakhir diupdate**: Januari 2025