-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 15, 2025 at 01:28 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `survei_diskominfo`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` bigint UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('super_admin','admin') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'admin',
  `last_login_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `password`, `name`, `role`, `last_login_at`, `created_at`, `updated_at`) VALUES
(1, 'superadmin', '$2y$12$Ex2KbsRgsXsDAGkcYWMrae0Cy2SWKhgj/lK0N5hLMT/0Xzqrz/JGq', 'Super Administrator', 'super_admin', NULL, '2025-09-07 19:47:24', '2025-09-07 19:47:24');

-- --------------------------------------------------------

--
-- Table structure for table `assets`
--

CREATE TABLE `assets` (
  `id` bigint UNSIGNED NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `original_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assets`
--

INSERT INTO `assets` (`id`, `type`, `name`, `file_path`, `original_name`, `is_active`, `description`, `created_at`, `updated_at`) VALUES
(9, 'logo', '1757297130_pngegg.png', 'assets/1757297130_pngegg.png', 'pngegg.png', 1, 'Logo Dinas Komunikasi dan Informatika Kabupaten Lamongan', '2025-09-07 19:47:24', '2025-09-07 19:47:24');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_info`
--

CREATE TABLE `contact_info` (
  `id` bigint UNSIGNED NOT NULL,
  `department_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Dinas Komunikasi dan Informatika',
  `regency_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Kabupaten Lamongan',
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Jl. Basuki Rahmat No. 1, Lamongan',
  `province` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Jawa Timur 62211',
  `whatsapp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '+628113021708',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'diskominfo@lamongankab.go.id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_info`
--

INSERT INTO `contact_info` (`id`, `department_name`, `regency_name`, `address`, `province`, `whatsapp`, `email`, `created_at`, `updated_at`) VALUES
(1, 'Dinas Komunikasi dan Informatika', 'Kabupaten Lamongan', 'Jl. Basuki Rahmat No. 1, Lamongan', 'Jawa Timur 62211', '+62 811 302 1708', 'diskominfo@lamongankab.go.id', '2025-09-07 19:47:24', '2025-09-07 19:47:24'),
(4, 'Dinas Komunikasi dan Informatika', 'Kabupaten Lamongan', 'Jl. Basuki Rahmat No. 1, Lamongan', 'Jawa Timur 62211', '+628113021708', 'diskominfo@lamongankab.go.id', '2025-09-07 19:47:16', '2025-09-07 19:47:16');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `footer_links`
--

CREATE TABLE `footer_links` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` enum('layanan','informasi') COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_index` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `footer_links`
--

INSERT INTO `footer_links` (`id`, `title`, `url`, `category`, `order_index`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Tentang kami', 'https://lamongankab.go.id/', 'informasi', 1, 1, '2025-09-07 19:47:24', '2025-09-07 19:47:24'),
(2, 'Website Resmi', 'https://lamongankab.go.id/', 'layanan', 1, 1, '2025-09-07 19:47:24', '2025-09-07 19:47:24'),
(3, 'Portal Data', 'https://lamongankab.go.id/', 'layanan', 2, 1, '2025-09-07 19:47:24', '2025-09-07 19:47:24'),
(4, 'Aplikasi Mobile', 'https://lamongankab.go.id/', 'layanan', 3, 1, '2025-09-07 19:47:24', '2025-09-07 19:47:24'),
(5, 'Helpdesk', 'https://laporpakyes.lamongankab.go.id/', 'layanan', 4, 1, '2025-09-07 19:47:24', '2025-09-07 19:47:24'),
(6, 'Kebijakan Privasi', 'https://lamongankab.go.id/', 'informasi', 2, 1, '2025-09-07 19:47:24', '2025-09-07 19:47:24');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_08_21_045023_create_surveys_table', 1),
(5, '2025_08_21_085158_create_admin_users_table', 2),
(6, '2025_08_25_033432_create_survey_sections_table', 3),
(7, '2025_08_25_033512_create_survey_questions_table', 3),
(8, '2025_08_25_033717_create_survey_responses_table', 3),
(9, '2025_08_26_013950_update_surveys_table', 4),
(10, '2025_08_26_014419_remove_unused_fields_from_surveys_table', 4),
(11, '2025_08_30_170645_add_role_to_admin_users_table', 5),
(12, '2025_08_31_083014_create_assets_table', 6),
(13, '2025_09_03_113520_add_question_description_to_survey_questions_table', 7),
(14, '2025_09_04_115203_create_footer_links_table', 8),
(15, '2025_09_07_125605_create_contact_info_table', 9);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('k8YKEQBdSKPQ3J1DzfqsuuGBgSuh1G9UCn2t16BP', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQ1UzOUpRNHJHdmgxamw2Q2NzcHptYXZWUFhTMXlpTUd1OXJJTEQ0TiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1757299647);

-- --------------------------------------------------------

--
-- Table structure for table `surveys`
--

CREATE TABLE `surveys` (
  `id` bigint UNSIGNED NOT NULL,
  `ip_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `survey_questions`
--

CREATE TABLE `survey_questions` (
  `id` bigint UNSIGNED NOT NULL,
  `section_id` bigint UNSIGNED NOT NULL,
  `question_text` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `question_description` text COLLATE utf8mb4_unicode_ci,
  `question_type` enum('short_text','long_text','multiple_choice','checkbox','dropdown','file_upload','linear_scale') COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` json DEFAULT NULL,
  `settings` json DEFAULT NULL,
  `order_index` int NOT NULL DEFAULT '0',
  `is_required` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `survey_questions`
--

INSERT INTO `survey_questions` (`id`, `section_id`, `question_text`, `question_description`, `question_type`, `options`, `settings`, `order_index`, `is_required`, `is_active`, `created_at`, `updated_at`) VALUES
(23, 13, 'Email', NULL, 'short_text', NULL, '[]', 1, 1, 1, '2025-09-07 19:47:24', '2025-09-07 19:47:24'),
(24, 13, 'Nama Lengkap', 'Penulisan nama menggunakan huruf kapital dan gelar menyesuaikan, Contoh : INTANIA SARAH, S.Kom.', 'short_text', NULL, '[]', 2, 1, 1, '2025-09-07 19:47:24', '2025-09-07 19:47:24'),
(25, 13, 'jenis kelamin', NULL, 'multiple_choice', '[\"laki laki\", \"perempuan\"]', '[]', 3, 1, 1, '2025-09-07 19:47:24', '2025-09-07 19:47:24'),
(26, 13, 'usia', NULL, 'multiple_choice', '[\"< 18 Tahun\", \"18 - 25 Tahun\", \"26 - 35 Tahun\", \"36 - 45 Tahun\", \"> 45 Tahun\"]', '[]', 4, 1, 1, '2025-09-07 19:47:24', '2025-09-07 19:47:24'),
(27, 13, 'Pendidikan Terakhir', NULL, 'multiple_choice', '[\"SMP ke bawah\", \"SMA/ Sederajat\", \"Diploma (D1-D4)\", \"S1\", \"S2/S3\"]', '[]', 5, 1, 1, '2025-09-07 19:47:24', '2025-09-07 19:47:24'),
(28, 13, 'Jenis Peserta', NULL, 'dropdown', '[\"Pemerintahan (Pegawai Pemerintah Dengan NIP/NIPTT-PK)\", \"Masyarakat Umum\"]', '[]', 6, 1, 1, '2025-09-07 19:47:24', '2025-09-07 19:47:24'),
(29, 14, 'Pelayanan', NULL, 'dropdown', '[\"Layanan Presentasi Pegawai\", \"Layanan PPID (Pejabat Pengelola Informasi dan Dokumentasi)\", \"Layanan Pengaduan Masyarakat\", \"Layanan Jaringan Internet\", \"Layanan Aplikasi Diskominfo Lamongan & Layanan Tanda Tangan Elektronik (TTE)\", \"Layanan Lainnya\"]', '[]', 1, 1, 1, '2025-09-07 19:47:24', '2025-09-07 19:47:24'),
(30, 14, 'Apakah Saudara pernah mendapati praktik diskriminasi pada layanan Dinas Kominfo Kab. Lamongan', NULL, 'linear_scale', NULL, '{\"scale_max\": \"5\", \"scale_min\": \"1\", \"scale_max_label\": \"Selalu\", \"scale_min_label\": \"Tidak Pernah\"}', 2, 1, 1, '2025-09-07 19:47:24', '2025-09-07 19:47:24'),
(31, 14, 'Apakah Saudara pernah mendapati praktik kecurangan, pungutan liar, atau imbalan dalam layanan ini?', NULL, 'linear_scale', NULL, '{\"scale_max\": \"5\", \"scale_min\": \"1\", \"scale_max_label\": \"Selalu\", \"scale_min_label\": \"Tidak Pernah\"}', 3, 1, 1, '2025-09-07 19:47:24', '2025-09-07 19:47:24'),
(32, 14, 'Apakah sistem layanan ini mudah diakses dan digunakan?', NULL, 'linear_scale', NULL, '{\"scale_max\": \"5\", \"scale_min\": \"1\", \"scale_max_label\": \"Sangat Setuju (sangat mudah diakses dan digunakan)\", \"scale_min_label\": \"Sangat Tidak Setuju (sulit diakses, rumit digunakan)\"}', 4, 1, 1, '2025-09-07 19:47:24', '2025-09-07 19:47:24'),
(33, 14, 'Apakah layanan ini memberikan respon atau tindak lanjut dengan cepat dan sesuai prosedur?', NULL, 'linear_scale', NULL, '{\"scale_max\": \"5\", \"scale_min\": \"1\", \"scale_max_label\": \"Sangat Setuju (sangat cepat dan sesuai prosedur)\", \"scale_min_label\": \"Sangat Tidak Setuju (sangat lambat, tidak sesuai prosedur)\"}', 5, 1, 1, '2025-09-07 19:47:24', '2025-09-07 19:47:24'),
(34, 14, 'Apakah Saudara merasa puas dengan layanan ini secara keseluruhan?', NULL, 'linear_scale', NULL, '{\"scale_max\": \"5\", \"scale_min\": \"1\", \"scale_max_label\": \"sangat puas\", \"scale_min_label\": \"sangat tidak puas\"}', 6, 1, 1, '2025-09-07 19:47:24', '2025-09-07 19:47:24'),
(35, 15, 'Ceritakan Pengelaman anda !', NULL, 'long_text', NULL, '[]', 1, 1, 1, '2025-09-07 19:47:24', '2025-09-07 19:47:24');

-- --------------------------------------------------------

--
-- Table structure for table `survey_responses`
--

CREATE TABLE `survey_responses` (
  `id` bigint UNSIGNED NOT NULL,
  `survey_id` bigint UNSIGNED NOT NULL,
  `question_id` bigint UNSIGNED NOT NULL,
  `answer` text COLLATE utf8mb4_unicode_ci,
  `answer_data` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `survey_sections`
--

CREATE TABLE `survey_sections` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `order_index` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `survey_sections`
--

INSERT INTO `survey_sections` (`id`, `title`, `description`, `order_index`, `is_active`, `created_at`, `updated_at`) VALUES
(13, 'Data Diri', 'Isikan dengan data diri anda', 1, 1, '2025-09-07 19:47:24', '2025-09-07 19:47:24'),
(14, 'Survei Pelayanan', NULL, 2, 1, '2025-09-07 19:47:24', '2025-09-07 19:47:24'),
(15, 'Testimoni Pelayanan', NULL, 3, 1, '2025-09-07 19:47:24', '2025-09-07 19:47:24');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_users_username_unique` (`username`);

--
-- Indexes for table `assets`
--
ALTER TABLE `assets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `contact_info`
--
ALTER TABLE `contact_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `footer_links`
--
ALTER TABLE `footer_links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
    ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
    ADD PRIMARY KEY (`id`),
    ADD KEY `sessions_user_id_index` (`user_id`),
    ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `surveys`
--
ALTER TABLE `surveys`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `survey_questions`
--
ALTER TABLE `survey_questions`
    ADD PRIMARY KEY (`id`),
    ADD KEY `survey_questions_section_id_foreign` (`section_id`);

--
-- Indexes for table `survey_responses`
--
ALTER TABLE `survey_responses`
    ADD PRIMARY KEY (`id`),
    ADD KEY `survey_responses_survey_id_foreign` (`survey_id`),
    ADD KEY `survey_responses_question_id_foreign` (`question_id`);

--
-- Indexes for table `survey_sections`
--
ALTER TABLE `survey_sections`
    ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
    MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `assets`
--
ALTER TABLE `assets`
    MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `contact_info`
--
ALTER TABLE `contact_info`
    MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
    MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `footer_links`
--
ALTER TABLE `footer_links`
    MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
    MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `surveys`
--
ALTER TABLE `surveys`
    MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `survey_questions`
--
ALTER TABLE `survey_questions`
    MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `survey_responses`
--
ALTER TABLE `survey_responses`
    MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=142;

--
-- AUTO_INCREMENT for table `survey_sections`
--
ALTER TABLE `survey_sections`
    MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
    MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `survey_questions`
--
ALTER TABLE `survey_questions`
    ADD CONSTRAINT `survey_questions_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `survey_sections` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `survey_responses`
--
ALTER TABLE `survey_responses`
    ADD CONSTRAINT `survey_responses_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `survey_questions` (`id`) ON DELETE CASCADE,
    ADD CONSTRAINT `survey_responses_survey_id_foreign` FOREIGN KEY (`survey_id`) REFERENCES `surveys` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
