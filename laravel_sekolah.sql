-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 01 Jan 2025 pada 12.09
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
-- Database: `laravel_sekolah`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `berita_sekolahs`
--

CREATE TABLE `berita_sekolahs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `berita_sekolahs`
--

INSERT INTO `berita_sekolahs` (`id`, `judul`, `deskripsi`, `gambar`, `created_at`, `updated_at`) VALUES
(2, 'Perpisahan angkatan 20', 'Acara perpisahan sekolah sdn 1 caringin ngumbang', 'Perpisahan angkatan 20_20240625_133754.jpg', '2024-06-25 06:37:54', '2024-06-25 06:37:54'),
(3, 'Tampil drum band di acara perpisahan', 'Siswa Siswi SDN 1 caringin ngumbang tampil dalam perpisahan angkatan 20', 'Tampil drum band di acara perpisahan_20240625_133857.jpg', '2024-06-25 06:38:57', '2024-06-25 06:38:57');

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
-- Struktur dari tabel `contact_sekolahs`
--

CREATE TABLE `contact_sekolahs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `icon` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `contact_sekolahs`
--

INSERT INTO `contact_sekolahs` (`id`, `icon`, `name`, `link`, `created_at`, `updated_at`) VALUES
(1, 'https://img.icons8.com/?size=100&id=X0mEIh0RyDdL&format=png&color=000000', 'rizkychandra2204@ummi.ac.id', 'mailto:rizkychandra2204@ummi.ac.id', NULL, NULL),
(2, 'https://img.icons8.com/fluent/48/000000/whatsapp.png', 'chandra22 628586051708', 'https://wa.me/6285860517808', NULL, '2024-06-27 10:58:39'),
(3, 'https://img.icons8.com/fluent/48/000000/instagram-new.png', '_chndr_22', 'https://instagram.com/', NULL, '2024-06-22 12:46:31'),
(4, 'https://img.icons8.com/fluent/48/000000/facebook-new.png', 'facebook_saya', 'https:facebook.com/', NULL, '2024-06-22 12:46:52'),
(5, 'https://img.icons8.com/fluent/48/000000/youtube-play.png', 'youtube_saya', 'https://youtube.com/', NULL, '2024-06-22 12:47:04');

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
-- Struktur dari tabel `gallery_events`
--

CREATE TABLE `gallery_events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `gallery_events`
--

INSERT INTO `gallery_events` (`id`, `title`, `subtitle`, `gambar`, `created_at`, `updated_at`) VALUES
(5, '17 Agustus', 'dgssgxvgdsgs', '17 Agustus_20240625_024138.jpg', '2024-06-17 11:57:21', '2024-06-24 19:41:38');

-- --------------------------------------------------------

--
-- Struktur dari tabel `gallery_lombas`
--

CREATE TABLE `gallery_lombas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `gallery_lombas`
--

INSERT INTO `gallery_lombas` (`id`, `title`, `subtitle`, `gambar`, `created_at`, `updated_at`) VALUES
(4, 'Sang Pemimpivxvv', 'dgssgxv', 'Sang Pemimpivxvv_20240625_024218.jpg', '2024-06-17 10:35:58', '2024-06-24 19:42:18');

-- --------------------------------------------------------

--
-- Struktur dari tabel `gallery_pariwisatas`
--

CREATE TABLE `gallery_pariwisatas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `gallery_pariwisatas`
--

INSERT INTO `gallery_pariwisatas` (`id`, `title`, `subtitle`, `gambar`, `created_at`, `updated_at`) VALUES
(2, 'Sang Pemimpi', 'dgssgxvgdsgsfggeetteeg', 'Sang Pemimpi_20240625_024301.jpg', '2024-06-17 13:37:13', '2024-06-24 19:43:01');

-- --------------------------------------------------------

--
-- Struktur dari tabel `gallery_perpisahans`
--

CREATE TABLE `gallery_perpisahans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `gallery_perpisahans`
--

INSERT INTO `gallery_perpisahans` (`id`, `title`, `subtitle`, `gambar`, `created_at`, `updated_at`) VALUES
(3, 'Sang Pemimpi', 'gdfhdhdhfgdhgd', 'Sang Pemimpi_20240625_024344.jpg', '2024-06-17 14:28:08', '2024-06-24 19:43:44');

-- --------------------------------------------------------

--
-- Struktur dari tabel `gurus`
--

CREATE TABLE `gurus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `jabatan` varchar(255) NOT NULL,
  `motivasi` varchar(255) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `gurus`
--

INSERT INTO `gurus` (`id`, `nama`, `jabatan`, `motivasi`, `gambar`, `created_at`, `updated_at`) VALUES
(17, 'Paiman Raechamt Afandi M.PD', 'Kepala Sekolah SD Caringin Ngumbang', 'Semangatlah untuk belajar karena ilmu merupakan warisan yang tidak akan pernah habis', 'Paiman Raechamt Afandi_20240617_141643.jpg', '2024-06-17 07:16:43', '2024-06-17 07:21:16');

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
-- Struktur dari tabel `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_06_11_063109_create_pemasukans_table', 2),
(5, '2024_06_11_071748_create_pemasukans_table', 3),
(6, '2024_06_11_130138_create_pemasukans_table', 4),
(7, '2024_06_11_145133_create_pengeluaran_table', 5),
(8, '2024_06_15_133300_create_pemasukans_table', 6),
(9, '2024_06_15_144318_create_pemasukans_table', 7),
(10, '2024_06_15_161730_create_pengeluarans_table', 8),
(11, '2024_06_16_073538_create_prestasis_table', 9),
(12, '2024_06_16_085831_create_gurus_table', 10),
(13, '2024_06_16_141454_create_gallery_events_table', 11),
(14, '2024_06_16_162431_create_messages_table', 12),
(15, '2024_06_16_173552_create_messages_table', 13),
(16, '2024_06_16_203044_create_gallery_lombas_table', 14),
(17, '2024_06_16_211635_create_gallery_lombas_table', 15),
(18, '2024_06_17_113415_create_study_tours_table', 16),
(19, '2024_06_17_122026_create_perpisahans_table', 17),
(20, '2024_06_17_153812_create_prestasis_table', 18),
(21, '2024_06_17_164641_create_gallery_lombas_table', 19),
(22, '2024_06_17_175114_create_gallery_events_table', 20),
(23, '2024_06_17_190418_create_gallery_study_tours_table', 21),
(24, '2024_06_17_194942_create_gallery_pariwisatas_table', 22),
(25, '2024_06_17_205442_create_gallery_perpisahans_table', 23),
(26, '2024_06_18_095737_create_sambutans_table', 24),
(27, '2024_06_22_072902_create_contact_sekolahs_table', 25),
(28, '2024_06_22_181129_create_contact_sekolahs_table', 26),
(29, '2024_06_24_063519_create_programkerjas_table', 27),
(30, '2024_06_24_073041_create_beritas_table', 28),
(31, '2024_06_25_130725_create_berita_sekolahs_table', 29);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemasukans`
--

CREATE TABLE `pemasukans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sumber` varchar(255) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `jumlah` decimal(15,2) NOT NULL,
  `tanggal` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengeluarans`
--

CREATE TABLE `pengeluarans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kebutuhan` varchar(255) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `jumlah` decimal(15,2) NOT NULL,
  `sumber` varchar(255) NOT NULL,
  `tanggal` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `prestasis`
--

CREATE TABLE `prestasis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `prestasis`
--

INSERT INTO `prestasis` (`id`, `judul`, `deskripsi`, `gambar`, `created_at`, `updated_at`) VALUES
(37, 'Pak Guru', 'fdgf', 'Pak Guru_20240619_073325.jpg', '2024-06-19 00:33:25', '2024-06-19 00:33:25'),
(38, 'Lomba Antar RT', 'vc', 'Lomba Antar RT_20240619_073347.jpg', '2024-06-19 00:33:47', '2024-06-19 00:33:47');

-- --------------------------------------------------------

--
-- Struktur dari tabel `programkerjas`
--

CREATE TABLE `programkerjas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `judul` text NOT NULL,
  `deskripsi` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `programkerjas`
--

INSERT INTO `programkerjas` (`id`, `judul`, `deskripsi`, `created_at`, `updated_at`) VALUES
(2, 'dsa', 'df', '2024-06-24 00:29:19', '2024-06-24 00:29:19'),
(3, 'Lomba 17 Agustus', 'nn', '2024-06-24 05:43:56', '2024-06-24 05:43:56');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sambutans`
--

CREATE TABLE `sambutans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sambutans`
--

INSERT INTO `sambutans` (`id`, `nama`, `deskripsi`, `gambar`, `created_at`, `updated_at`) VALUES
(1, 'Paiman Raechamt Afandi M.PD', 'Assalamualaikum bapak ibu wali murid saya mengucapkan terima kasih atas kepercayaan anda untuk mendidik anak anda di sekolah SDN 1 Caringin Ngumbang', 'Paiman Raechamt Afandi M.PD_20240618_111013.jpg', '2024-06-18 04:10:13', '2024-06-18 04:10:13');

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
('9fLeY30C9NIjOZpeKEIi59qCGvN5D0Z4axifaVfm', 4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36 Edg/131.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidFZLbm5FRWRjYzFqZ3RXZ1NIOGxremFyWFZPUmVhZzlEaHNXQVlxTyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQva2V1YW5nYW4vcmVrYXAvdHJhbnNha3NpIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NDt9', 1735453527),
('9LHcCnYj67q5OMQS4fUQT3FgFyURaysyrTNQc0TV', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36 Edg/131.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYTNmMDBpbk1CUUFaeVE2Q1BiYVZuM3dtMEt0UUZSV1J5VXZiZmZNWiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1735475870),
('JivpKpSPum0oAcyK5mIiO2bvIQJy1G9ZVesBM39h', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36 Edg/131.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidEpaeEpxMjZENkMyMkxEcnVrZDNaSVJSR0Y4RVFLVzZjbGFJb3dQQyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1735729644);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','operator','keuangan','siswa') NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `gambar`, `username`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 'Chandra Khusuma', 'Chandra Khusuma_20240716_130607.jpg', 'admin123', NULL, '$2y$12$p4gVcslGXcoNK87RQl5Kx.y49344opnNIHDbzCtuNw9y4G262uUgK', 'admin', NULL, '2024-06-02 21:56:39', '2024-07-16 06:06:07'),
(3, 'Kayla Sandi Putri', 'Kayla Sandi Putri_20240715_193104.jpg', 'operator123', NULL, '$2y$12$E7EorQkB8cDFsGHJWP8OW.XLNiHpY6uLwjqWKiAxYjHCLTFEMA5/q', 'operator', NULL, '2024-06-02 21:56:39', '2024-07-15 12:43:24'),
(4, 'Rizky Chandra Khusuma', 'Rizky Chandra Khusuma_20240715_195759.jpg', 'bendahara123', NULL, '$2y$12$DZ7J//eOmNtYcMr9ZHgtdOl7wtNTQAtjAA40EqAPzFndHl1S9yDBm', 'keuangan', NULL, '2024-06-02 21:56:39', '2024-07-15 12:57:59'),
(7, 'Rizky Chandra', 'Rizky Chandra_20240716_171506.jpg', 'chandra22', NULL, '$2y$12$nbGQL5PJb2h66Cwtq4dRW.qswhOkHC20R2TqPl1bsXsvUXzOPK5VK', 'siswa', NULL, '2024-07-16 10:15:06', '2024-07-16 10:15:06'),
(14, 'Muhamad Fadhillah Dinurahman', 'Muhamad Fadhillah Dinurahman_20240719_144919.png', 'fadillah22', NULL, '$2y$12$I8OQep1zQmHwO29TpXY03OVh/ICdlfKMXK4XW3fi2u4HAIKsusOXm', 'siswa', NULL, '2024-07-19 07:49:19', '2024-07-19 07:49:19');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `berita_sekolahs`
--
ALTER TABLE `berita_sekolahs`
  ADD PRIMARY KEY (`id`);

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
-- Indeks untuk tabel `contact_sekolahs`
--
ALTER TABLE `contact_sekolahs`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `gallery_events`
--
ALTER TABLE `gallery_events`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `gallery_lombas`
--
ALTER TABLE `gallery_lombas`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `gallery_pariwisatas`
--
ALTER TABLE `gallery_pariwisatas`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `gallery_perpisahans`
--
ALTER TABLE `gallery_perpisahans`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `gurus`
--
ALTER TABLE `gurus`
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
-- Indeks untuk tabel `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `pemasukans`
--
ALTER TABLE `pemasukans`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pengeluarans`
--
ALTER TABLE `pengeluarans`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `prestasis`
--
ALTER TABLE `prestasis`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `programkerjas`
--
ALTER TABLE `programkerjas`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `sambutans`
--
ALTER TABLE `sambutans`
  ADD PRIMARY KEY (`id`);

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
  ADD UNIQUE KEY `users_email_unique` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `berita_sekolahs`
--
ALTER TABLE `berita_sekolahs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `contact_sekolahs`
--
ALTER TABLE `contact_sekolahs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `gallery_events`
--
ALTER TABLE `gallery_events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `gallery_lombas`
--
ALTER TABLE `gallery_lombas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `gallery_pariwisatas`
--
ALTER TABLE `gallery_pariwisatas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `gallery_perpisahans`
--
ALTER TABLE `gallery_perpisahans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `gurus`
--
ALTER TABLE `gurus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT untuk tabel `pemasukans`
--
ALTER TABLE `pemasukans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pengeluarans`
--
ALTER TABLE `pengeluarans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `prestasis`
--
ALTER TABLE `prestasis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT untuk tabel `programkerjas`
--
ALTER TABLE `programkerjas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `sambutans`
--
ALTER TABLE `sambutans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
