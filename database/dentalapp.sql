-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 16, 2023 at 03:31 AM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dentalapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pasien`
--

CREATE TABLE `pasien` (
  `id` int(11) NOT NULL,
  `nama_pasien` varchar(150) NOT NULL,
  `no_rm` varchar(150) NOT NULL,
  `no_hp` varchar(50) NOT NULL,
  `tgl_periksa` date NOT NULL,
  `keluhan` varchar(150) NOT NULL,
  `td` varchar(150) NOT NULL,
  `gd` varchar(150) NOT NULL,
  `diagnosa` varchar(150) NOT NULL,
  `keterangan` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` varchar(150) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pasien`
--

INSERT INTO `pasien` (`id`, `nama_pasien`, `no_rm`, `no_hp`, `tgl_periksa`, `keluhan`, `td`, `gd`, `diagnosa`, `keterangan`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'Syahroni', '112345678', '0812', '2023-05-15', 'sakit', 'xx1', 'xx2', 'kembung', '-', '2023-05-14 15:17:24', NULL, '2023-05-14 08:31:42', NULL),
(5, 'Siti', '112345678', '0812', '2023-05-16', 'sakit', 'xxxxx', 'xxxxx', 'kembung', '-', '2023-05-15 06:45:45', NULL, '2023-05-15 06:47:04', NULL),
(6, 'Dani', '112345678', '0812', '2023-05-16', 'sakit', 'xxxxx', 'xxxxx', 'kembung', '-', '2023-05-15 06:50:12', NULL, '2023-05-15 06:50:12', NULL),
(7, 'Oji', '112345678', '0812', '2023-05-16', 'sakit', 'xxxxx', 'xxxxx', 'kembung', '-', '2023-05-15 06:53:00', NULL, '2023-05-15 06:53:00', NULL),
(8, 'Fitri', '112345678', '0812', '2023-05-16', 'sakit', 'xxxxx', 'xxxxx', 'kembung', '-', '2023-05-15 06:53:55', NULL, '2023-05-15 06:53:55', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengingat`
--

CREATE TABLE `pengingat` (
  `id` int(11) NOT NULL,
  `nama_pasien` varchar(150) NOT NULL,
  `no_hp` varchar(50) NOT NULL,
  `tgl_kirim` date NOT NULL,
  `kategori` varchar(150) NOT NULL,
  `pesan` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` varchar(150) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pengingat`
--

INSERT INTO `pengingat` (`id`, `nama_pasien`, `no_hp`, `tgl_kirim`, `kategori`, `pesan`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'Syahrini', '0812', '2023-05-02', '1', 'pesan 2', 0, '2023-05-15 06:30:33', NULL, '2023-05-15 06:43:17', NULL),
(2, 'Syahrini', '0812', '2023-05-02', '1', 'pesan 1', 0, '2023-05-15 06:41:23', NULL, '2023-05-15 06:43:27', NULL),
(3, 'Syahrini', '0812', '2023-05-16', '2', 'qqqqqqqqqq', 0, '2023-05-15 06:45:45', NULL, '2023-05-15 06:45:45', NULL),
(4, 'Dani', '0812', '2023-05-09', '2', 'sssssssssss', 0, '2023-05-15 06:50:12', NULL, '2023-05-15 06:50:12', NULL),
(5, 'Oji', '0812', '2023-05-09', '3', 'qswdsdcfc v', 0, '2023-05-15 06:53:00', NULL, '2023-05-15 06:53:00', NULL),
(6, 'Fitri', '0812', '2023-05-08', '2', 'qqqqqqqqqqqq', 0, '2023-05-15 06:53:55', NULL, '2023-05-15 06:53:55', NULL),
(7, 'Siti', '0812', '2023-05-16', '3', 'qwsdfvfd', 0, '2023-05-15 06:54:56', NULL, '2023-05-15 06:54:56', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Rijal', 'rijalmohamad.rijal@gmail.com', NULL, '$2y$10$kA94alPjMb9Pxe8PnouOw.foqqml9lbDcwFY1VhPhUYH4ZSpwlNJu', NULL, '2023-05-13 19:11:18', '2023-05-13 19:11:18'),
(3, 'CHRIS9', 'admin@admin.com', NULL, '$2y$10$GohePQL9t4C3g4GaJELLv.3BMF3aQs0WLSIDzkP4xPmsumIFP47l2', NULL, '2023-05-13 20:39:13', '2023-05-15 07:55:14'),
(4, 'Disney Hotstar', 'admin3@admin.com', NULL, '$2y$10$2zneVa2.xPClNZGCcxA7i.4gZFiMWtev6DAxqcc6FEUDyOSZ36GVu', 'Paj4pRXUPDg1PwDFCkEaLCPj6BYaexgUfHIUG7ZIkZCQyNn8coqoWKEEiBKZ', '2023-05-14 06:34:52', '2023-05-14 06:34:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pasien`
--
ALTER TABLE `pasien`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `pengingat`
--
ALTER TABLE `pengingat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pasien`
--
ALTER TABLE `pasien`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `pengingat`
--
ALTER TABLE `pengingat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
