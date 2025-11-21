-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 18 Nov 2025 pada 14.23
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
-- Database: `pepedebe`
--

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
(1, 'Gelombang 1', 2025, '2025-11-19', '2025-11-30', 550000.00, 1, '2025-11-18 06:02:30', '2025-11-18 06:02:30');

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
(1, 'RPL071', 'Rekayasa Perangkat Lunak', 50, NULL, 1, '2025-11-18 05:59:14', '2025-11-18 05:59:14'),
(2, 'BDP195', 'Bisnis Daring dan Pemasaran', 35, NULL, 1, '2025-11-18 06:00:44', '2025-11-18 06:00:44'),
(3, 'AKT009', 'Akuntansi dan Keuangan Lembaga', 75, NULL, 1, '2025-11-18 06:01:11', '2025-11-18 06:01:11'),
(4, 'DKV555', 'Desain Komunikasi Visual', 50, NULL, 1, '2025-11-18 06:01:36', '2025-11-18 06:01:36'),
(5, 'ANM999', 'Animasi', 45, NULL, 1, '2025-11-18 06:01:51', '2025-11-18 06:01:51');

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
(1, '0001_01_01_000001_create_cache_table', 1),
(2, '0001_01_01_000002_create_jobs_table', 1),
(3, '2025_11_12_012910_create_users_table', 1),
(4, '2025_11_18_071804_create_jurusan_table', 1),
(5, '2025_11_18_071823_create_gelombang_table', 1),
(6, '2025_11_18_071845_create_wilayah_table', 1),
(7, '2025_11_18_071906_create_pengguna_table', 1),
(8, '2025_11_18_071922_create_pendaftar_table', 1),
(9, '2025_11_18_071944_create_pendaftar_data_siswa_table', 1),
(10, '2025_11_18_072000_create_pendaftar_data_ortu_table', 1),
(11, '2025_11_18_072020_create_pendaftar_asal_sekolah_table', 1),
(12, '2025_11_18_072036_create_pendaftar_berkas_table', 1),
(13, '2025_11_18_072103_create_log_aktivitas_table', 1);

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
  `catatan_verifikasi` text DEFAULT NULL,
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
  `jenis` enum('IJAZAH','RAPOR','KIP','KKS','AKTA','KK','BUKTI_BAYAR','LAINNYA') NOT NULL,
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
(1, 'Atmin 1', 'admin1@gmail.com', '08123456789', '$2y$12$N2hidHsgZXmjnkcPY619LOxNMNV95Tj.C4JawvAaLQDkCQJ3VQbcO', 'admin', 1, NULL, NULL, 0, NULL, '2025-11-18 05:56:40', '2025-11-18 05:56:40'),
(2, 'Verifikator 1', 'verif1@gmail.com', '09876543456', '$2y$12$d7EzyWQ9etnvWWjvr4262OZn3FE6mkyXz3MKCR/VBDmxYhH.foKtq', 'verifikator_adm', 1, NULL, NULL, 1, NULL, '2025-11-18 06:15:01', '2025-11-18 06:15:01'),
(3, 'Keuangan 1', 'duit@gmail.com', '089543545666', '$2y$12$O6tFMsjFPlda4RvrXbqnIep0vW6zE./QLjHJd4FiGKHnhbs/jNq9m', 'keuangan', 1, NULL, NULL, 1, NULL, '2025-11-18 06:15:41', '2025-11-18 06:15:41'),
(4, 'Kepala Sekolah', 'kepsek@gmail.com', '089777886789', '$2y$12$fkJXc2CBoRZxkPy/CKN3M.1ENLlfsyha26OXUxgLb1P.O.renSOf6', 'kepsek', 1, NULL, NULL, 1, NULL, '2025-11-18 06:16:21', '2025-11-18 06:16:21');

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
(1, 'Jawa Barat', 'Kota Bandung', 'Arcamanik', 'Cisaranten Bina Harapan', '40293', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(2, 'Jawa Barat', 'Kota Bandung', 'Arcamanik', 'Sukamiskin', '40294', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(3, 'Jawa Barat', 'Kota Bandung', 'Astana Anyar', 'Karang Anyar', '40242', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(4, 'Jawa Barat', 'Kota Bandung', 'Astana Anyar', 'Panjunan', '40242', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(5, 'Jawa Barat', 'Kota Bandung', 'Babakan Ciparay', 'Babakan Ciparay', '40223', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(6, 'Jawa Barat', 'Kota Bandung', 'Babakan Ciparay', 'Sukahaji', '40224', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(7, 'Jawa Barat', 'Kota Bandung', 'Bandung Kidul', 'Batununggal', '40266', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(8, 'Jawa Barat', 'Kota Bandung', 'Bandung Kidul', 'Mengger', '40267', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(9, 'Jawa Barat', 'Kota Bandung', 'Bandung Kulon', 'Caringin', '40213', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(10, 'Jawa Barat', 'Kota Bandung', 'Bandung Kulon', 'Cibuntu', '40212', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(11, 'Jawa Barat', 'Kota Bandung', 'Bandung Wetan', 'Cihapit', '40114', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(12, 'Jawa Barat', 'Kota Bandung', 'Bandung Wetan', 'Tamansari', '40116', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(13, 'Jawa Barat', 'Kota Bandung', 'Batununggal', 'Kacapiring', '40272', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(14, 'Jawa Barat', 'Kota Bandung', 'Batununggal', 'Kebon Waru', '40272', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(15, 'Jawa Barat', 'Kota Bandung', 'Bojongloa Kaler', 'Cibadak', '40232', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(16, 'Jawa Barat', 'Kota Bandung', 'Bojongloa Kaler', 'Kebon Gedang', '40233', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(17, 'Jawa Barat', 'Kota Bandung', 'Bojongloa Kidul', 'Cibaduyut', '40236', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(18, 'Jawa Barat', 'Kota Bandung', 'Bojongloa Kidul', 'Cibaduyut Kidul', '40237', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(19, 'Jawa Barat', 'Kota Bandung', 'Buahbatu', 'Cijawura', '40287', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(20, 'Jawa Barat', 'Kota Bandung', 'Buahbatu', 'Margasari', '40286', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(21, 'Jawa Barat', 'Kota Bandung', 'Cibeunying Kaler', 'Cigadung', '40191', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(22, 'Jawa Barat', 'Kota Bandung', 'Cibeunying Kaler', 'Cihaurgeulis', '40192', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(23, 'Jawa Barat', 'Kota Bandung', 'Cibeunying Kidul', 'Cicadas', '40122', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(24, 'Jawa Barat', 'Kota Bandung', 'Cibeunying Kidul', 'Sukamaju', '40123', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(25, 'Jawa Barat', 'Kota Bandung', 'Cibiru', 'Cipadung', '40614', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(26, 'Jawa Barat', 'Kota Bandung', 'Cibiru', 'Palasari', '40615', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(27, 'Jawa Barat', 'Kota Bandung', 'Cicendo', 'Arjuna', '40172', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(28, 'Jawa Barat', 'Kota Bandung', 'Cicendo', 'Pamoyanan', '40173', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(29, 'Jawa Barat', 'Kota Bandung', 'Cidadap', 'Hegarmanah', '40141', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(30, 'Jawa Barat', 'Kota Bandung', 'Cidadap', 'Ciumbuleuit', '40142', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(31, 'Jawa Barat', 'Kota Bandung', 'Cinambo', 'Cisaranten Wetan', '40294', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(32, 'Jawa Barat', 'Kota Bandung', 'Cinambo', 'Pakemitan', '40294', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(33, 'Jawa Barat', 'Kota Bandung', 'Coblong', 'Dago', '40135', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(34, 'Jawa Barat', 'Kota Bandung', 'Coblong', 'Lebak Siliwangi', '40132', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(35, 'Jawa Barat', 'Kota Bandung', 'Gedebage', 'Cisaranten Kidul', '40295', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(36, 'Jawa Barat', 'Kota Bandung', 'Gedebage', 'Rancabolang', '40296', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(37, 'Jawa Barat', 'Kota Bandung', 'Kiaracondong', 'Babakan Surabaya', '40272', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(38, 'Jawa Barat', 'Kota Bandung', 'Kiaracondong', 'Kebon Kangkung', '40272', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(39, 'Jawa Barat', 'Kota Bandung', 'Lengkong', 'Burangrang', '40262', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(40, 'Jawa Barat', 'Kota Bandung', 'Lengkong', 'Kebon Jayanti', '40261', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(41, 'Jawa Barat', 'Kota Bandung', 'Mandalajati', 'Jatihandap', '40194', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(42, 'Jawa Barat', 'Kota Bandung', 'Mandalajati', 'Karang Pamulang', '40195', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(43, 'Jawa Barat', 'Kota Bandung', 'Panyileukan', 'Cipadung Kidul', '40614', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(44, 'Jawa Barat', 'Kota Bandung', 'Panyileukan', 'Mekar Mulya', '40614', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(45, 'Jawa Barat', 'Kota Bandung', 'Rancasari', 'Cipamokolan', '40292', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(46, 'Jawa Barat', 'Kota Bandung', 'Rancasari', 'Derwati', '40286', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(47, 'Jawa Barat', 'Kota Bandung', 'Regol', 'Ciseureuh', '40254', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(48, 'Jawa Barat', 'Kota Bandung', 'Regol', 'Ancol', '40254', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(49, 'Jawa Barat', 'Kota Bandung', 'Sukajadi', 'Cipedes', '40162', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(50, 'Jawa Barat', 'Kota Bandung', 'Sukajadi', 'Pasteur', '40161', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(51, 'Jawa Barat', 'Kota Bandung', 'Sukasari', 'Gegerkalong', '40153', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(52, 'Jawa Barat', 'Kota Bandung', 'Sukasari', 'Sarijadi', '40151', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(53, 'Jawa Barat', 'Kota Bandung', 'Sumur Bandung', 'Braga', '40111', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(54, 'Jawa Barat', 'Kota Bandung', 'Sumur Bandung', 'Kebon Pisang', '40112', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(55, 'Jawa Barat', 'Kota Bandung', 'Ujung Berung', 'Cigending', '40611', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(56, 'Jawa Barat', 'Kota Bandung', 'Ujung Berung', 'Pasanggrahan', '40612', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(57, 'Jawa Barat', 'Kabupaten Bandung', 'Baleendah', 'Andir', '40375', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(58, 'Jawa Barat', 'Kabupaten Bandung', 'Baleendah', 'Baleendah', '40375', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(59, 'Jawa Barat', 'Kabupaten Bandung', 'Cangkuang', 'Bandasari', '40238', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(60, 'Jawa Barat', 'Kabupaten Bandung', 'Cangkuang', 'Cangkuang', '40238', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(61, 'Jawa Barat', 'Kabupaten Bandung', 'Cileunyi', 'Cileunyi Kulon', '40622', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(62, 'Jawa Barat', 'Kabupaten Bandung', 'Cileunyi', 'Cileunyi Wetan', '40621', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(63, 'Jawa Barat', 'Kabupaten Bandung', 'Cimenyan', 'Cimenyan', '40191', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(64, 'Jawa Barat', 'Kabupaten Bandung', 'Cimenyan', 'Mekarsaluyu', '40198', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(65, 'Jawa Barat', 'Kabupaten Bandung', 'Cinambo', 'Babakan', '40294', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(66, 'Jawa Barat', 'Kabupaten Bandung', 'Cinambo', 'Cipadung', '40614', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(67, 'Jawa Barat', 'Kabupaten Bandung', 'Dayeuhkolot', 'Citeureup', '40257', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(68, 'Jawa Barat', 'Kabupaten Bandung', 'Dayeuhkolot', 'Dayeuhkolot', '40257', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(69, 'Jawa Barat', 'Kabupaten Bandung', 'Jatinangor', 'Cibeusi', '45363', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(70, 'Jawa Barat', 'Kabupaten Bandung', 'Jatinangor', 'Cikeruh', '45363', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(71, 'Jawa Barat', 'Kabupaten Bandung', 'Jatinangor', 'Cileles', '45363', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(72, 'Jawa Barat', 'Kabupaten Bandung', 'Jatinangor', 'Cipacing', '45363', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(73, 'Jawa Barat', 'Kabupaten Bandung', 'Kutawaringin', 'Jatisari', '40383', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(74, 'Jawa Barat', 'Kabupaten Bandung', 'Kutawaringin', 'Pasanggrahan', '40383', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(75, 'Jawa Barat', 'Kabupaten Bandung', 'Margahayu', 'Margahayu Selatan', '40225', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(76, 'Jawa Barat', 'Kabupaten Bandung', 'Margahayu', 'Margahayu Tengah', '40226', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(77, 'Jawa Barat', 'Kabupaten Bandung', 'Margaasih', 'Cigondewah Hilir', '40217', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(78, 'Jawa Barat', 'Kabupaten Bandung', 'Margaasih', 'Lagadar', '40218', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(79, 'Jawa Barat', 'Kabupaten Bandung', 'Nagreg', 'Nagreg', '40215', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(80, 'Jawa Barat', 'Kabupaten Bandung', 'Nagreg', 'Bojong', '40215', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(81, 'Jawa Barat', 'Kabupaten Bandung', 'Pameungpeuk', 'Bojong Kunci', '40376', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(82, 'Jawa Barat', 'Kabupaten Bandung', 'Pameungpeuk', 'Pameungpeuk', '40376', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(83, 'Jawa Barat', 'Kabupaten Bandung', 'Pangalengan', 'Pangalengan', '40378', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(84, 'Jawa Barat', 'Kabupaten Bandung', 'Pangalengan', 'Sukamanah', '40378', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(85, 'Jawa Barat', 'Kabupaten Bandung', 'Rancaekek', 'Rancaekek Kencana', '40394', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(86, 'Jawa Barat', 'Kabupaten Bandung', 'Rancaekek', 'Rancaekek Wetan', '40394', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(87, 'Jawa Barat', 'Kabupaten Bandung', 'Solokan Jeruk', 'Cibodas', '40376', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(88, 'Jawa Barat', 'Kabupaten Bandung', 'Solokan Jeruk', 'Langensari', '40376', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(89, 'Jawa Barat', 'Kota Cirebon', 'Harjamukti', 'Kesepuhan', '45121', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(90, 'Jawa Barat', 'Kota Cirebon', 'Harjamukti', 'Pegambiran', '45122', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(91, 'Jawa Barat', 'Kota Cirebon', 'Kejaksan', 'Kebonbaru', '45123', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(92, 'Jawa Barat', 'Kota Cirebon', 'Kejaksan', 'Sukapura', '45124', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(93, 'Jawa Barat', 'Kota Cirebon', 'Kesambi', 'Drajat', '45133', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(94, 'Jawa Barat', 'Kota Cirebon', 'Kesambi', 'Karyamulya', '45134', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(95, 'Jawa Barat', 'Kota Cirebon', 'Lemahwungkuk', 'Panjunan', '45111', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(96, 'Jawa Barat', 'Kota Cirebon', 'Lemahwungkuk', 'Pegambiran', '45112', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(97, 'Jawa Barat', 'Kota Cirebon', 'Pekalipan', 'Pekalipan', '45115', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(98, 'Jawa Barat', 'Kota Cirebon', 'Pekalipan', 'Pulasaren', '45116', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(99, 'Jawa Barat', 'Kabupaten Bandung Barat', 'Batujajar', 'Batujajar', '40561', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(100, 'Jawa Barat', 'Kabupaten Bandung Barat', 'Batujajar', 'Galanggang', '40562', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(101, 'Jawa Barat', 'Kabupaten Bandung Barat', 'Cihampelas', 'Cihampelas', '40562', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(102, 'Jawa Barat', 'Kabupaten Bandung Barat', 'Cihampelas', 'Mekarjaya', '40563', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(103, 'Jawa Barat', 'Kabupaten Bandung Barat', 'Cikalong Wetan', 'Cikalong', '40556', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(104, 'Jawa Barat', 'Kabupaten Bandung Barat', 'Cikalong Wetan', 'Mekarjaya', '40557', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(105, 'Jawa Barat', 'Kabupaten Bandung Barat', 'Cipeundeuy', 'Cipeundeuy', '40558', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(106, 'Jawa Barat', 'Kabupaten Bandung Barat', 'Cipeundeuy', 'Bojong', '40559', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(107, 'Jawa Barat', 'Kabupaten Bandung Barat', 'Cipongkor', 'Cipongkor', '40564', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(108, 'Jawa Barat', 'Kabupaten Bandung Barat', 'Cipongkor', 'Baranangsiang', '40565', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(109, 'Jawa Barat', 'Kabupaten Bandung Barat', 'Gununghalu', 'Gununghalu', '40565', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(110, 'Jawa Barat', 'Kabupaten Bandung Barat', 'Gununghalu', 'Bunijaya', '40566', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(111, 'Jawa Barat', 'Kabupaten Bandung Barat', 'Lembang', 'Lembang', '40391', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(112, 'Jawa Barat', 'Kabupaten Bandung Barat', 'Lembang', 'Cikidang', '40392', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(113, 'Jawa Barat', 'Kabupaten Bandung Barat', 'Ngamprah', 'Ngamprah', '40552', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(114, 'Jawa Barat', 'Kabupaten Bandung Barat', 'Ngamprah', 'Cilame', '40553', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(115, 'Jawa Barat', 'Kabupaten Bandung Barat', 'Padalarang', 'Padalarang', '40553', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(116, 'Jawa Barat', 'Kabupaten Bandung Barat', 'Padalarang', 'Cimerang', '40554', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(117, 'Jawa Barat', 'Kabupaten Bandung Barat', 'Parongpong', 'Parongpong', '40559', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(118, 'Jawa Barat', 'Kabupaten Bandung Barat', 'Parongpong', 'Cigugur Girang', '40560', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(119, 'Jawa Barat', 'Kota Bekasi', 'Bantar Gebang', 'Ciketing Udik', '17153', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(120, 'Jawa Barat', 'Kota Bekasi', 'Bantar Gebang', 'Sumur Batu', '17154', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(121, 'Jawa Barat', 'Kota Bekasi', 'Bekasi Barat', 'Bintara', '17134', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(122, 'Jawa Barat', 'Kota Bekasi', 'Bekasi Barat', 'Kranji', '17135', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(123, 'Jawa Barat', 'Kota Bekasi', 'Bekasi Selatan', 'Margahayu', '17141', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(124, 'Jawa Barat', 'Kota Bekasi', 'Bekasi Selatan', 'Duren Jaya', '17142', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(125, 'Jawa Barat', 'Kota Bekasi', 'Bekasi Timur', 'Aren Jaya', '17111', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(126, 'Jawa Barat', 'Kota Bekasi', 'Bekasi Timur', 'Duren Jaya', '17112', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(127, 'Jawa Barat', 'Kota Bekasi', 'Bekasi Utara', 'Harapan Baru', '17123', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(128, 'Jawa Barat', 'Kota Bekasi', 'Bekasi Utara', 'Karang Satria', '17124', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(129, 'Jawa Barat', 'Kota Bekasi', 'Jatiasih', 'Jatiasih', '17423', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(130, 'Jawa Barat', 'Kota Bekasi', 'Jatiasih', 'Jatikramat', '17424', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(131, 'Jawa Barat', 'Kota Bekasi', 'Jati Sempurna', 'Jatibening', '17412', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(132, 'Jawa Barat', 'Kota Bekasi', 'Jati Sempurna', 'Jatibening Baru', '17413', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(133, 'Jawa Barat', 'Kota Bekasi', 'Medan Satria', 'Harapan Mulya', '17132', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(134, 'Jawa Barat', 'Kota Bekasi', 'Medan Satria', 'Kaliabang Tengah', '17133', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(135, 'Jawa Barat', 'Kota Bekasi', 'Mustika Jaya', 'Mustika Jaya', '17158', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(136, 'Jawa Barat', 'Kota Bekasi', 'Mustika Jaya', 'Mustika Sari', '17159', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(137, 'Jawa Barat', 'Kota Bekasi', 'Pondok Gede', 'Jatibening', '17412', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(138, 'Jawa Barat', 'Kota Bekasi', 'Pondok Gede', 'Jaticempaka', '17411', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(139, 'Jawa Barat', 'Kota Bekasi', 'Pondok Melati', 'Jatimelati', '17414', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(140, 'Jawa Barat', 'Kota Bekasi', 'Pondok Melati', 'Jatimurni', '17415', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(141, 'Jawa Barat', 'Kota Bekasi', 'Rawalumbu', 'Bojong Rawalumbu', '17116', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(142, 'Jawa Barat', 'Kota Bekasi', 'Rawalumbu', 'Sepanjang Jaya', '17117', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(143, 'Jawa Barat', 'Kota Depok', 'Beji', 'Beji', '16421', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(144, 'Jawa Barat', 'Kota Depok', 'Beji', 'Kemiri Muka', '16423', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(145, 'Jawa Barat', 'Kota Depok', 'Bojongsari', 'Bojongsari', '16516', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(146, 'Jawa Barat', 'Kota Depok', 'Bojongsari', 'Curug', '16517', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(147, 'Jawa Barat', 'Kota Depok', 'Cilodong', 'Cilodong', '16414', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(148, 'Jawa Barat', 'Kota Depok', 'Cilodong', 'Kalibaru', '16415', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(149, 'Jawa Barat', 'Kota Depok', 'Cimanggis', 'Cisalak Pasar', '16452', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(150, 'Jawa Barat', 'Kota Depok', 'Cimanggis', 'Curug', '16453', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(151, 'Jawa Barat', 'Kota Depok', 'Cinere', 'Cinere', '16514', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(152, 'Jawa Barat', 'Kota Depok', 'Cinere', 'Gandul', '16513', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(153, 'Jawa Barat', 'Kota Depok', 'Cipayung', 'Cipayung', '16438', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(154, 'Jawa Barat', 'Kota Depok', 'Cipayung', 'Ratujaya', '16439', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(155, 'Jawa Barat', 'Kota Depok', 'Limo', 'Limo', '16512', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(156, 'Jawa Barat', 'Kota Depok', 'Limo', 'Meruyung', '16515', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(157, 'Jawa Barat', 'Kota Depok', 'Pancoran Mas', 'Depok', '16431', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(158, 'Jawa Barat', 'Kota Depok', 'Pancoran Mas', 'Depok Jaya', '16432', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(159, 'Jawa Barat', 'Kota Depok', 'Sawangan', 'Sawangan', '16511', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(160, 'Jawa Barat', 'Kota Depok', 'Sawangan', 'Bedahan', '16519', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(161, 'Jawa Barat', 'Kota Depok', 'Sukmajaya', 'Sukmajaya', '16412', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(162, 'Jawa Barat', 'Kota Depok', 'Sukmajaya', 'Mekar Jaya', '16411', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(163, 'Jawa Barat', 'Kota Depok', 'Tapos', 'Tapos', '16457', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(164, 'Jawa Barat', 'Kota Depok', 'Tapos', 'Leuwinanggung', '16456', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(165, 'Jawa Barat', 'Kabupaten Sumedang', 'Sumedang Selatan', 'Regol Wetan', '45311', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(166, 'Jawa Barat', 'Kabupaten Sumedang', 'Sumedang Selatan', 'Kotakaler', '45312', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(167, 'Jawa Barat', 'Kabupaten Sumedang', 'Sumedang Utara', 'Situ', '45321', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(168, 'Jawa Barat', 'Kabupaten Sumedang', 'Sumedang Utara', 'Talun', '45322', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(169, 'Jawa Barat', 'Kabupaten Sumedang', 'Jatinangor', 'Cikeruh', '45363', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(170, 'Jawa Barat', 'Kabupaten Sumedang', 'Jatinangor', 'Cipacing', '45363', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(171, 'Jawa Barat', 'Kabupaten Sumedang', 'Jatinangor', 'Cileles', '45363', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(172, 'Jawa Barat', 'Kabupaten Sumedang', 'Jatinangor', 'Cibeusi', '45363', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(173, 'Jawa Barat', 'Kabupaten Sumedang', 'Cimanggung', 'Cimanggung', '45364', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(174, 'Jawa Barat', 'Kabupaten Sumedang', 'Cimanggung', 'Sukadana', '45364', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(175, 'Jawa Barat', 'Kabupaten Sumedang', 'Tanjungsari', 'Tanjungsari', '45362', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(176, 'Jawa Barat', 'Kabupaten Sumedang', 'Tanjungsari', 'Sukasari', '45362', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(177, 'Jawa Barat', 'Kota Bogor', 'Bogor Barat', 'Bubulak', '16115', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(178, 'Jawa Barat', 'Kota Bogor', 'Bogor Barat', 'Semplak', '16116', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(179, 'Jawa Barat', 'Kota Bogor', 'Bogor Selatan', 'Batutulis', '16133', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(180, 'Jawa Barat', 'Kota Bogor', 'Bogor Selatan', 'Bondongan', '16131', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(181, 'Jawa Barat', 'Kota Bogor', 'Bogor Tengah', 'Babakan', '16128', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(182, 'Jawa Barat', 'Kota Bogor', 'Bogor Tengah', 'Pabaton', '16121', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(183, 'Jawa Barat', 'Kota Bogor', 'Bogor Timur', 'Baranangsiang', '16143', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(184, 'Jawa Barat', 'Kota Bogor', 'Bogor Timur', 'Katulampa', '16144', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(185, 'Jawa Barat', 'Kota Bogor', 'Bogor Utara', 'Cibuluh', '16155', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(186, 'Jawa Barat', 'Kota Bogor', 'Bogor Utara', 'Tegal Gundil', '16152', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(187, 'Jawa Barat', 'Kota Bogor', 'Tanah Sareal', 'Cibadak', '16161', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(188, 'Jawa Barat', 'Kota Bogor', 'Tanah Sareal', 'Kedung Badak', '16158', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(189, 'Jawa Barat', 'Kota Tasikmalaya', 'Bungursari', 'Bungursari', '46151', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(190, 'Jawa Barat', 'Kota Tasikmalaya', 'Bungursari', 'Cibunigeulis', '46152', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(191, 'Jawa Barat', 'Kota Tasikmalaya', 'Cibeureum', 'Cibeureum', '46196', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(192, 'Jawa Barat', 'Kota Tasikmalaya', 'Cibeureum', 'Karsamenak', '46197', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(193, 'Jawa Barat', 'Kota Tasikmalaya', 'Cihideung', 'Cihideung', '46122', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(194, 'Jawa Barat', 'Kota Tasikmalaya', 'Cihideung', 'Tugujaya', '46123', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(195, 'Jawa Barat', 'Kota Tasikmalaya', 'Kawalu', 'Kawalu', '46182', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(196, 'Jawa Barat', 'Kota Tasikmalaya', 'Kawalu', 'Talagasari', '46183', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(197, 'Jawa Barat', 'Kota Tasikmalaya', 'Mangkubumi', 'Cigantang', '46181', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(198, 'Jawa Barat', 'Kota Tasikmalaya', 'Mangkubumi', 'Indihiang', '46184', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(199, 'Jawa Barat', 'Kota Tasikmalaya', 'Tamansari', 'Mugarsari', '46196', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(200, 'Jawa Barat', 'Kota Tasikmalaya', 'Tamansari', 'Setiaratu', '46195', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(201, 'Jawa Barat', 'Kota Tasikmalaya', 'Tawang', 'Lengkongsari', '46115', '2025-11-18 13:17:28', '2025-11-18 13:17:28'),
(202, 'Jawa Barat', 'Kota Tasikmalaya', 'Tawang', 'Tawangsari', '46114', '2025-11-18 13:17:28', '2025-11-18 13:17:28');

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `gelombang`
--
ALTER TABLE `gelombang`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jurusan`
--
ALTER TABLE `jurusan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `pendaftar`
--
ALTER TABLE `pendaftar`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pendaftar_berkas`
--
ALTER TABLE `pendaftar_berkas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `wilayah`
--
ALTER TABLE `wilayah`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=203;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  ADD CONSTRAINT `log_aktivitas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `pengguna` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pendaftar`
--
ALTER TABLE `pendaftar`
  ADD CONSTRAINT `pendaftar_gelombang_id_foreign` FOREIGN KEY (`gelombang_id`) REFERENCES `gelombang` (`id`),
  ADD CONSTRAINT `pendaftar_jurusan_id_foreign` FOREIGN KEY (`jurusan_id`) REFERENCES `jurusan` (`id`),
  ADD CONSTRAINT `pendaftar_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `pengguna` (`id`);

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
