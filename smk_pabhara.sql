-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 07 Nov 2026 pada 08.51
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smk_pabhara`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` varchar(50) NOT NULL,
  `content` text NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `news`
--

INSERT INTO `news` (`id`, `title`, `category`, `content`, `image_url`, `created_at`, `updated_at`) VALUES
(1, 'Kunjungan Industri Siswa TKJ ke Pusat Data Nasional', 'Kegiatan', 'Siswa kelas XI Teknik Jaringan Komputer SMK Panca Bhakti Rakit mengadakan kunjungan lapangan ke Pusat Data Nasional untuk mempelajari infrastruktur cloud storage, keamanan jaringan pertahanan cyber, dan arsitektur server modern secara rinci.', '', '2026-11-05 07:25:07', '2026-11-07 07:25:07'),
(2, 'Tim Otomotif TKRO Meraih Juara Modifikasi Mesin Ramah Lingkungan', 'Prestasi', 'Inovasi sistem pasokan bahan bakar hemat energi buatan siswa jurusan Teknik Kendaraan Ringan dan Otomotif (TKRO) SMK Panca Bhakti Rakit kembali mengukir prestasi memukau dalam Lomba Karya Inovasi Kejuruan Tingkat Provinsi.', '', '2026-11-02 07:25:07', '2026-11-07 07:25:07'),
(3, 'Jadwal Pelaksanaan Asesmen Sumatif Semester Gasal', 'Pengumuman', 'Diberitahukan kepada seluruh peserta didik kelas X, XI, dan XII mengenai pelaksanaan Asesmen Sumatif Semester Gasal yang akan dimulai serentak pada pekan mendatang.', '', '2026-10-31 07:25:07', '2026-11-07 07:25:07');

-- --------------------------------------------------------

--
-- Struktur dari tabel `school_identity`
--

CREATE TABLE `school_identity` (
  `id` int(11) NOT NULL DEFAULT 1,
  `school_name` varchar(150) NOT NULL,
  `npsn` varchar(20) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `website` varchar(100) DEFAULT 'smkpancabhaktirakit.sch.id',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `school_identity`
--

INSERT INTO `school_identity` (`id`, `school_name`, `npsn`, `phone`, `email`, `address`, `website`, `updated_at`) VALUES
(1, 'SMK Panca Bhakti Rakit', '20362369', '+62 853-2969-9994', 'info@smkpabhara.sch.id', 'Jl. Raya Rakit Km 2.7, Adipasir, Rakit, Banjarnegara 53463', 'smkpancabhaktirakit.sch.id', '2026-11-07 07:25:07');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `name`, `created_at`) VALUES
(1, 'admin', '$2y$10$OCi5vhIPCWWkjxJOayF3ie6dlDA9VYrfknA3lRCMWpqbp1I342Sja', 'Administrator Website', '2026-11-07 07:25:06');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `school_identity`
--
ALTER TABLE `school_identity`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
