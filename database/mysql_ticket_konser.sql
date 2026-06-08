-- ============================================================
-- MySQL Dump - TicketKonser
-- Dibuat: June 2026
-- Konversi dari: Oracle ke MySQL
-- ============================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ============================================================
-- Struktur tabel `users`
-- ============================================================
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(191) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- Data untuk tabel `users`
-- ============================================================
INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`, `updated_at`, `email_verified_at`) VALUES
(1,  'holi',        'holi@gmail.com',                     '$2y$12$LeOl4oj3zjIIT1syjKMVNO6ePh7mrRvHsmHVcSLWxNQua7G2ERwbG', 'user',  '2026-05-10 14:03:42', '2026-05-10 14:03:42', NULL),
(2,  'hanna',       'hanna@gmail.com',                    '$2y$12$ruERkrNd6380yboA1ze.nu0CHs3rv4kDIUrm38AQiD4xtdjDMXpZS', 'user',  '2026-05-10 15:28:17', '2026-05-10 15:28:17', NULL),
(21, 'holi',        'holikristin@gmail.com',              '$2y$12$qxBQSCy.qYCd7cdGBNuGaOSkP7BvrtL3Jqs7rlOyoCwWRchBtkbHa', 'admin', '2026-05-10 18:00:31', '2026-05-10 19:34:43', NULL),
(22, 'mia',         'mia@gmail.com',                      '$2y$12$/MD6zQGAAmbN48sNC/itbOK/wDbOblMbH1xXKjKCYXgPfVnPJq42m', 'user',  '2026-05-10 19:45:36', '2026-05-10 19:45:36', NULL),
(23, 'holi',        'holi@gmal.com',                      '$2y$12$2IhlCaDW.daB95jVXOxT3OrkMrR.O/tpg37mlPtMYsX9K9Z5Xa2lO', 'user',  '2026-05-10 19:47:44', '2026-05-10 19:47:44', NULL),
(24, 'rizka',       'rizka@gmail.com',                    '$2y$12$.SB3IxGei.soDQjAtnoE.OnX1vz0ugmWx5GzNfvar1BxFwZvhkCjK', 'user',  '2026-05-10 19:51:50', '2026-05-10 19:51:50', NULL),
(25, 'agres',       'agres@gmail.com',                    '$2y$12$mDLyY.s2FLHRlakVAE/8AO5yV/X9ydKST2sBDHoO09B5OVppwUTt.', 'user',  '2026-05-10 21:55:38', '2026-05-10 21:55:38', NULL),
(41, 'dwi',         'dwi@gmail.com',                      '$2y$12$3ZZ2bRi0ZQmOusiaHaGmtOB/XB0lAsQ7kXp1pftY/pfZvUobuJGru', 'user',  '2026-05-11 04:29:19', '2026-05-11 04:29:19', NULL),
(65, 'holikristin', 'holikristinbr@students.polmed.ac.id','$2y$12$TBcjMm/WDPlNP.XXQL13hugydep.DI4lReGWL/JUlRzAAtxHINAi6', 'user',  '2026-06-08 04:56:50', '2026-06-08 04:56:50', NULL),
(66, 'holikristin', 'holikristinbr@gmail.com',            '$2y$12$6kJ1M/bYyaroNUFb6lKN4O4LbHPanY6R4cfEhIfD5uq5j0Tt24qMu', 'user',  '2026-06-08 05:01:28', '2026-06-08 05:01:28', NULL),
(67, 'holikristin', 'holiaja@gmail.com',                  '$2y$12$56uKLP9/q/ds55PFP464LeiE98Ge1c8ficklyyJ6168jDrwz5/OSG',  'user',  '2026-06-08 05:05:25', '2026-06-08 05:05:25', NULL),
(68, 'chrin',       'chrin1718@gmail.com',                '$2y$12$C8Wk31YtjdUf3pEKZr46X.rcj7wfEar3LpcR3boxl5Qhym.T716vu', 'user',  '2026-06-08 05:09:22', '2026-06-08 05:09:22', NULL),
(69, 'holikristin', 'jeonholi@gmail.com',                 '$2y$12$PztTllLf2ZqdsBhgx4xsYecdsqE9Hy8pTPQxGo2Nq2SSKQ8onOCC2', 'user',  '2026-06-08 05:59:11', '2026-06-08 05:59:11', '2026-06-08 06:23:35');

-- ============================================================
-- Struktur tabel `concerts`
-- ============================================================
CREATE TABLE IF NOT EXISTS `concerts` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_konser` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `harga` decimal(15,2) NOT NULL,
  `tanggal_konser` date DEFAULT NULL,
  `lokasi` varchar(255) DEFAULT NULL,
  `stok_tiket` int(10) NOT NULL DEFAULT 0,
  `poster` varchar(255) DEFAULT NULL,
  `genre` varchar(100) NOT NULL DEFAULT 'General',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- Data untuk tabel `concerts`
-- ============================================================
INSERT INTO `concerts` (`id`, `nama_konser`, `harga`, `tanggal_konser`, `lokasi`, `stok_tiket`, `created_at`, `poster`, `genre`) VALUES
(1, 'TULUS - Tur Manusia',          550000.00, '2026-06-15', 'Gedung Serbaguna Pemprovsu, Medan',             497, '2026-05-11 05:24:54', 'posters/Tulus.jpeg',  'Pop / Soul'),
(2, 'Raisa Anggiani - Renung Resah',350000.00, '2026-07-20', 'Medan International Convention Center (MICC)', 296, '2026-05-11 05:25:07', 'posters/Raisa.jpeg',  'Folk Pop'),
(3, 'Nadin Amizah - Konser Bakat',  400000.00, '2026-08-10', 'Pardede Hall, Medan',                          446, '2026-05-11 05:25:19', 'posters/Nadin.jpeg',  'Indie Folk');

-- ============================================================
-- Struktur tabel `bookings`
-- ============================================================
CREATE TABLE IF NOT EXISTS `bookings` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `concert_id` bigint(20) UNSIGNED NOT NULL,
  `jumlah_tiket` int(5) NOT NULL,
  `total_harga` decimal(15,2) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'PENDING',
  `bukti_transfer` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bookings_user_id_foreign` (`user_id`),
  KEY `bookings_concert_id_foreign` (`concert_id`),
  CONSTRAINT `bookings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `bookings_concert_id_foreign` FOREIGN KEY (`concert_id`) REFERENCES `concerts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- Data untuk tabel `bookings`
-- ============================================================
INSERT INTO `bookings` (`id`, `user_id`, `concert_id`, `jumlah_tiket`, `total_harga`, `status`, `created_at`, `bukti_transfer`) VALUES
(47, 22, 3, 2, 800000.00, 'SUKSES', '2026-06-08 09:17:01', 'bukti_pembayaran/8Drh10DAkh7uu5koqsD5zDgzRtPnBFpkhbaQUDax.png'),
(61, 69, 2, 2, 700000.00, 'SUKSES', '2026-06-08 13:56:55', 'bukti_pembayaran/xQDi45ivErNwW81f39lxaiKsxqlWh7DmrexEQ3HE.png');

-- ============================================================
-- Struktur tabel `user_otps`
-- ============================================================
CREATE TABLE IF NOT EXISTS `user_otps` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(191) NOT NULL,
  `otp` varchar(255) NOT NULL,
  `expires_at` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_otps_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;
