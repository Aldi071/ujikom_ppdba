-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 12 Nov 2025 pada 15.42
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ujikom_ppdb`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `biaya`
--

CREATE TABLE `biaya` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `jumlah` decimal(12,2) NOT NULL,
  `jenis` enum('TUNAI','TRANSFER') NOT NULL DEFAULT 'TUNAI',
  `kategori` enum('DAFTAR','PANGKAL','SPP','LAINNYA') NOT NULL DEFAULT 'LAINNYA',
  `wajib` tinyint(1) NOT NULL DEFAULT 1,
  `aktif` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `biaya`
--

INSERT INTO `biaya` (`id`, `kode`, `nama`, `deskripsi`, `jumlah`, `jenis`, `kategori`, `wajib`, `aktif`, `created_at`, `updated_at`) VALUES
(1, 'PEPEK221', 'Aldi', 'asasa', 100000.00, 'TRANSFER', 'DAFTAR', 1, 1, '2025-11-11 21:30:46', '2025-11-11 21:31:19');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `gelombang`
--

CREATE TABLE `gelombang` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(50) NOT NULL,
  `tahun` int(11) NOT NULL,
  `tgl_mulai` date NOT NULL,
  `tgl_selesai` date NOT NULL,
  `biaya_daftar` decimal(12,2) NOT NULL,
  `aktif` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `gelombang`
--

INSERT INTO `gelombang` (`id`, `nama`, `tahun`, `tgl_mulai`, `tgl_selesai`, `biaya_daftar`, `aktif`, `created_at`, `updated_at`) VALUES
(1, 'Gelombang 1', 2025, '2025-01-01', '2025-06-30', 200000.00, 1, '2025-11-12 00:05:40', '2025-11-12 00:05:40'),
(2, 'Gelombang 2', 2025, '2025-07-01', '2025-12-31', 250000.00, 1, '2025-11-12 00:05:40', '2025-11-12 00:05:40');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jurusan`
--

CREATE TABLE `jurusan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode` varchar(10) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `kuota` int(11) NOT NULL DEFAULT 0,
  `deskripsi` text DEFAULT NULL,
  `aktif` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `jurusan`
--

INSERT INTO `jurusan` (`id`, `kode`, `nama`, `kuota`, `deskripsi`, `aktif`, `created_at`, `updated_at`) VALUES
(1, 'TKJ', 'Teknik Komputer dan Jaringan', 100, 'Jurusan yang mempelajari tentang jaringan komputer, server, dan sistem keamanan jaringan', 1, '2025-11-11 23:58:51', '2025-11-11 23:58:51'),
(2, 'RPL', 'Rekayasa Perangkat Lunak', 80, 'Jurusan yang mempelajari tentang pengembangan software dan pemrograman', 1, '2025-11-11 23:58:51', '2025-11-11 23:58:51'),
(3, 'TEI', 'Teknik Elektronika Industri', 60, 'Jurusan yang mempelajari tentang sistem kontrol dan elektronika industri', 1, '2025-11-11 23:58:51', '2025-11-11 23:58:51'),
(4, 'TKR', 'Teknik Kendaraan Ringan', 70, 'Jurusan yang mempelajari tentang perbaikan dan perawatan kendaraan ringan', 1, '2025-11-11 23:58:51', '2025-11-11 23:58:51'),
(5, 'TBSM', 'Teknik Bisnis Sepeda Motor', 50, 'Jurusan yang mempelajari tentang bisnis dan perbaikan sepeda motor', 1, '2025-11-11 23:58:51', '2025-11-11 23:58:51');

-- --------------------------------------------------------

--
-- Struktur dari tabel `log_aktivitas`
--

CREATE TABLE `log_aktivitas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `aksi` varchar(100) NOT NULL,
  `objek` varchar(100) NOT NULL,
  `objek_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`objek_data`)),
  `waktu` datetime NOT NULL,
  `ip` varchar(45) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2025_11_12_012910_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 2),
(3, '0001_01_01_000002_create_jobs_table', 2),
(4, '2025_11_09_133151_create_jurusan_table', 2),
(5, '2025_11_09_133219_create_gelombang_table', 2),
(6, '2025_11_09_133233_create_wilayah_table', 2),
(7, '2025_11_09_133303_create_pendaftar_table', 2),
(8, '2025_11_09_133317_create_pendaftar_data_siswa_table', 2),
(9, '2025_11_09_133330_create_pendaftar_data_ortu_table', 2),
(10, '2025_11_09_133344_create_pendaftar_asal_sekolah_table', 2),
(11, '2025_11_09_133355_create_pendaftar_berkas_table', 2),
(12, '2025_11_09_133407_create_log_aktivitas_table', 2),
(13, '2025_11_10_030930_create_pengguna_table', 2),
(14, '2025_11_12_013138_create_sessions_table', 3),
(15, '2025_11_12_015558_create_sessions_table', 4),
(16, '2025_11_12_033836_create_biaya_table', 5),
(17, '2025_11_12_065728_create_jurusan_table', 6),
(18, '2025_11_12_070429_create_gelombang_table', 7);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pendaftar`
--

CREATE TABLE `pendaftar` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal_daftar` datetime NOT NULL,
  `no_pendaftaran` varchar(20) NOT NULL,
  `gelombang_id` bigint(20) UNSIGNED NOT NULL,
  `jurusan_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('DRAFT','SUBMIT','ADM_PASS','ADM_REJECT','PAID','LULUS','TIDAK_LULUS','CADANGAN') NOT NULL DEFAULT 'DRAFT',
  `user_verifikasi_adm` varchar(100) DEFAULT NULL,
  `tgl_verifikasi_adm` datetime DEFAULT NULL,
  `user_verifikasi_payment` varchar(100) DEFAULT NULL,
  `tgl_verifikasi_payment` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pendaftar_asal_sekolah`
--

CREATE TABLE `pendaftar_asal_sekolah` (
  `pendaftar_id` bigint(20) UNSIGNED NOT NULL,
  `npsn` varchar(20) DEFAULT NULL,
  `nama_sekolah` varchar(150) NOT NULL,
  `kabupaten` varchar(100) NOT NULL,
  `nilai_rata` decimal(5,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pendaftar_berkas`
--

CREATE TABLE `pendaftar_berkas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pendaftar_id` bigint(20) UNSIGNED NOT NULL,
  `jenis` enum('IJAZAH','RAPOR','KIP','KKS','AKTA','KK','LAINNYA') NOT NULL,
  `nama_file` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `ukuran_kb` int(11) NOT NULL,
  `valid` tinyint(1) NOT NULL DEFAULT 0,
  `catatan` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pendaftar_data_ortu`
--

CREATE TABLE `pendaftar_data_ortu` (
  `pendaftar_id` bigint(20) UNSIGNED NOT NULL,
  `nama_ayah` varchar(120) NOT NULL,
  `pekerjaan_ayah` varchar(100) NOT NULL,
  `hp_ayah` varchar(20) DEFAULT NULL,
  `nama_ibu` varchar(120) NOT NULL,
  `pekerjaan_ibu` varchar(100) NOT NULL,
  `hp_ibu` varchar(20) DEFAULT NULL,
  `wali_nama` varchar(120) DEFAULT NULL,
  `wali_hp` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pendaftar_data_siswa`
--

CREATE TABLE `pendaftar_data_siswa` (
  `pendaftar_id` bigint(20) UNSIGNED NOT NULL,
  `nik` varchar(20) DEFAULT NULL,
  `nisn` varchar(20) DEFAULT NULL,
  `nama` varchar(120) NOT NULL,
  `jk` enum('L','P') NOT NULL,
  `tmp_lahir` varchar(60) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `alamat` text NOT NULL,
  `wilayah_id` bigint(20) UNSIGNED NOT NULL,
  `lat` decimal(10,7) DEFAULT NULL,
  `lng` decimal(10,7) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengguna`
--

CREATE TABLE `pengguna` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(120) NOT NULL,
  `hp` varchar(20) DEFAULT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('pendaftar','admin','verifikator_adm','keuangan','kepsek') NOT NULL DEFAULT 'pendaftar',
  `aktif` tinyint(1) NOT NULL DEFAULT 1,
  `otp_code` varchar(6) DEFAULT NULL,
  `otp_expires_at` timestamp NULL DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pengguna`
--

INSERT INTO `pengguna` (`id`, `nama`, `email`, `hp`, `password_hash`, `role`, `aktif`, `otp_code`, `otp_expires_at`, `is_verified`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Atmin', 'admin@gmail.com', '08123456789', '$2y$12$cE78S9eJifbiTkyRyo087.8PZXTjcEqb6nfWkElJ4.h3Cr4NHdbB.', 'admin', 1, NULL, NULL, 0, NULL, '2025-11-11 18:33:22', '2025-11-11 18:33:22'),
(2, 'Verifikator', 'verif@gmail.com', '08123456789', '$2y$12$qqIZ5oJ9zf1gQXN.vnhyvu3XQG23RfSgRe08UOQJknCcXzWWsWmQC', 'verifikator_adm', 1, NULL, NULL, 0, NULL, '2025-11-11 18:33:50', '2025-11-11 18:33:50'),
(3, 'Keuangan', 'money@gmail.com', '08123456789', '$2y$12$bmRXpReP6fODhqL34QhXQ.WUk9aIBiv5DgWswEKNQ77uXa/lm2KVy', 'keuangan', 1, NULL, NULL, 0, NULL, '2025-11-11 18:34:07', '2025-11-11 18:34:07'),
(4, 'Kepsek', 'kepsek@gmail.com', '08123456789', '$2y$12$LcuzW1gvXG400xfZ6fsHRua8z7UXK9arXw7ZIL5YFsN1yap9UJs7i', 'kepsek', 1, NULL, NULL, 0, NULL, '2025-11-11 18:34:47', '2025-11-11 18:34:47'),
(15, 'Siswa 0987654321', 'hekate071@gmail.com', '0987654321', '$2y$12$LJqm5E.Mzk8Y2U9vYFr/0u3q1GMsGrZXjPSGlnG4zTbgsQPw3D3sG', 'pendaftar', 1, NULL, NULL, 1, NULL, '2025-11-11 19:19:15', '2025-11-11 19:19:42'),
(16, 'Atmin 2', 'admin2@gmail.com', '08123456789', '$2y$12$f.0yjDwsMxDTqzfK9vVaKunplzSYFqOmqrYVW/Cez1wdbTfUw9PV2', 'admin', 1, NULL, NULL, 0, NULL, '2025-11-11 21:41:17', '2025-11-11 21:41:17');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('qyWyn5xAXTkG9gMKRfT388zQx8jLvsI7UOZaJPrq', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiejVrRnpDRXFFTGd4anJNM21kc2FLZHlIMlNqRTFxZmx5Rmx1THVLeiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1762912618);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `wilayah`
--

CREATE TABLE `wilayah` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `provinsi` varchar(100) NOT NULL,
  `kabupaten` varchar(100) NOT NULL,
  `kecamatan` varchar(100) NOT NULL,
  `kelurahan` varchar(100) NOT NULL,
  `kodepos` varchar(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `wilayah`
--

INSERT INTO `wilayah` (`id`, `provinsi`, `kabupaten`, `kecamatan`, `kelurahan`, `kodepos`, `created_at`, `updated_at`) VALUES
(37, 'DKI Jakarta', 'Jakarta Pusat', 'Gambir', 'Gambir', '10110', '2025-11-11 21:10:23', '2025-11-11 21:10:23'),
(38, 'DKI Jakarta', 'Jakarta Pusat', 'Gambir', 'Kebon Kelapa', '10120', '2025-11-11 21:10:23', '2025-11-11 21:10:23'),
(39, 'DKI Jakarta', 'Jakarta Pusat', 'Senen', 'Senen', '10410', '2025-11-11 21:10:23', '2025-11-11 21:10:23'),
(40, 'Jawa Barat', 'Kota Bandung', 'Coblong', 'Dago', '40135', '2025-11-11 21:10:23', '2025-11-11 21:10:23'),
(41, 'Jawa Barat', 'Kota Bandung', 'Coblong', 'Lebak Siliwangi', '40132', '2025-11-11 21:10:23', '2025-11-11 21:10:23'),
(42, 'Jawa Barat', 'Kota Bandung', 'Bandung Wetan', 'Cihapit', '40114', '2025-11-11 21:10:23', '2025-11-11 21:10:23'),
(43, 'Banten', 'Kota Tangerang', 'Tangerang', 'Sukarasa', '15111', '2025-11-11 21:10:23', '2025-11-11 21:10:23'),
(44, 'Banten', 'Kota Tangerang', 'Ciledug', 'Parung Serab', '15152', '2025-11-11 21:10:23', '2025-11-11 21:10:23'),
(45, 'Jawa Tengah', 'Kota Semarang', 'Semarang Tengah', 'Pekunden', '50134', '2025-11-11 21:10:23', '2025-11-11 21:10:23'),
(46, 'DKI Jakarta', 'Jakarta Pusat', 'Gambir', 'Gambir', '10110', '2025-11-11 21:20:56', '2025-11-11 21:20:56'),
(47, 'DKI Jakarta', 'Jakarta Pusat', 'Gambir', 'Kebon Kelapa', '10120', '2025-11-11 21:20:56', '2025-11-11 21:20:56'),
(48, 'DKI Jakarta', 'Jakarta Pusat', 'Senen', 'Senen', '10410', '2025-11-11 21:20:56', '2025-11-11 21:20:56'),
(49, 'Jawa Barat', 'Kota Bandung', 'Coblong', 'Dago', '40135', '2025-11-11 21:20:56', '2025-11-11 21:20:56'),
(50, 'Jawa Barat', 'Kota Bandung', 'Coblong', 'Lebak Siliwangi', '40132', '2025-11-11 21:20:56', '2025-11-11 21:20:56'),
(51, 'Jawa Barat', 'Kota Bandung', 'Bandung Wetan', 'Cihapit', '40114', '2025-11-11 21:20:56', '2025-11-11 21:20:56'),
(52, 'Banten', 'Kota Tangerang', 'Tangerang', 'Sukarasa', '15111', '2025-11-11 21:20:56', '2025-11-11 21:20:56'),
(53, 'Banten', 'Kota Tangerang', 'Ciledug', 'Parung Serab', '15152', '2025-11-11 21:20:56', '2025-11-11 21:20:56'),
(54, 'Jawa Tengah', 'Kota Semarang', 'Semarang Tengah', 'Pekunden', '50134', '2025-11-11 21:20:56', '2025-11-11 21:20:56'),
(55, 'DKI Jakarta', 'Jakarta Pusat', 'Gambir', 'Gambir', '10110', '2025-11-12 00:03:33', '2025-11-12 00:03:33'),
(56, 'DKI Jakarta', 'Jakarta Pusat', 'Gambir', 'Kebon Kelapa', '10120', '2025-11-12 00:03:33', '2025-11-12 00:03:33'),
(57, 'DKI Jakarta', 'Jakarta Pusat', 'Senen', 'Senen', '10410', '2025-11-12 00:03:33', '2025-11-12 00:03:33'),
(58, 'Jawa Barat', 'Kota Bandung', 'Coblong', 'Dago', '40135', '2025-11-12 00:03:33', '2025-11-12 00:03:33'),
(59, 'Jawa Barat', 'Kota Bandung', 'Coblong', 'Lebak Siliwangi', '40132', '2025-11-12 00:03:33', '2025-11-12 00:03:33'),
(60, 'Jawa Barat', 'Kota Bandung', 'Bandung Wetan', 'Cihapit', '40114', '2025-11-12 00:03:33', '2025-11-12 00:03:33'),
(61, 'Banten', 'Kota Tangerang', 'Tangerang', 'Sukarasa', '15111', '2025-11-12 00:03:33', '2025-11-12 00:03:33'),
(62, 'Banten', 'Kota Tangerang', 'Ciledug', 'Parung Serab', '15152', '2025-11-12 00:03:33', '2025-11-12 00:03:33'),
(63, 'Jawa Tengah', 'Kota Semarang', 'Semarang Tengah', 'Pekunden', '50134', '2025-11-12 00:03:33', '2025-11-12 00:03:33');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `biaya`
--
ALTER TABLE `biaya`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `biaya_kode_unique` (`kode`);

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `gelombang`
--
ALTER TABLE `gelombang`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jurusan`
--
ALTER TABLE `jurusan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `jurusan_kode_unique` (`kode`);

--
-- Indeks untuk tabel `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `log_aktivitas_user_id_waktu_index` (`user_id`,`waktu`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pendaftar`
--
ALTER TABLE `pendaftar`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pendaftar_no_pendaftaran_unique` (`no_pendaftaran`),
  ADD KEY `pendaftar_user_id_foreign` (`user_id`),
  ADD KEY `pendaftar_gelombang_id_foreign` (`gelombang_id`),
  ADD KEY `pendaftar_jurusan_id_foreign` (`jurusan_id`),
  ADD KEY `pendaftar_status_index` (`status`);

--
-- Indeks untuk tabel `pendaftar_asal_sekolah`
--
ALTER TABLE `pendaftar_asal_sekolah`
  ADD PRIMARY KEY (`pendaftar_id`);

--
-- Indeks untuk tabel `pendaftar_berkas`
--
ALTER TABLE `pendaftar_berkas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pendaftar_berkas_pendaftar_id_jenis_index` (`pendaftar_id`,`jenis`);

--
-- Indeks untuk tabel `pendaftar_data_ortu`
--
ALTER TABLE `pendaftar_data_ortu`
  ADD PRIMARY KEY (`pendaftar_id`);

--
-- Indeks untuk tabel `pendaftar_data_siswa`
--
ALTER TABLE `pendaftar_data_siswa`
  ADD PRIMARY KEY (`pendaftar_id`),
  ADD KEY `pendaftar_data_siswa_wilayah_id_foreign` (`wilayah_id`);

--
-- Indeks untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pengguna_email_unique` (`email`),
  ADD KEY `pengguna_role_index` (`role`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indeks untuk tabel `wilayah`
--
ALTER TABLE `wilayah`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wilayah_kecamatan_kelurahan_index` (`kecamatan`,`kelurahan`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `biaya`
--
ALTER TABLE `biaya`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `gelombang`
--
ALTER TABLE `gelombang`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jurusan`
--
ALTER TABLE `jurusan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `pendaftar`
--
ALTER TABLE `pendaftar`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `pendaftar_berkas`
--
ALTER TABLE `pendaftar_berkas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `wilayah`
--
ALTER TABLE `wilayah`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  ADD CONSTRAINT `log_aktivitas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pendaftar`
--
ALTER TABLE `pendaftar`
  ADD CONSTRAINT `pendaftar_gelombang_id_foreign` FOREIGN KEY (`gelombang_id`) REFERENCES `gelombang` (`id`),
  ADD CONSTRAINT `pendaftar_jurusan_id_foreign` FOREIGN KEY (`jurusan_id`) REFERENCES `jurusan` (`id`),
  ADD CONSTRAINT `pendaftar_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pendaftar_asal_sekolah`
--
ALTER TABLE `pendaftar_asal_sekolah`
  ADD CONSTRAINT `pendaftar_asal_sekolah_pendaftar_id_foreign` FOREIGN KEY (`pendaftar_id`) REFERENCES `pendaftar` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pendaftar_berkas`
--
ALTER TABLE `pendaftar_berkas`
  ADD CONSTRAINT `pendaftar_berkas_pendaftar_id_foreign` FOREIGN KEY (`pendaftar_id`) REFERENCES `pendaftar` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pendaftar_data_ortu`
--
ALTER TABLE `pendaftar_data_ortu`
  ADD CONSTRAINT `pendaftar_data_ortu_pendaftar_id_foreign` FOREIGN KEY (`pendaftar_id`) REFERENCES `pendaftar` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pendaftar_data_siswa`
--
ALTER TABLE `pendaftar_data_siswa`
  ADD CONSTRAINT `pendaftar_data_siswa_pendaftar_id_foreign` FOREIGN KEY (`pendaftar_id`) REFERENCES `pendaftar` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pendaftar_data_siswa_wilayah_id_foreign` FOREIGN KEY (`wilayah_id`) REFERENCES `wilayah` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
