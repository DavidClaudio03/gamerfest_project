-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-05-2024 a las 14:39:15
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gamerfest_project`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipos`
--

CREATE TABLE `equipos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `id_juego` bigint(20) UNSIGNED NOT NULL,
  `nombre_equipo` varchar(191) NOT NULL,
  `miembros` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(191) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ganadores_grupales`
--

CREATE TABLE `ganadores_grupales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_juego` bigint(20) UNSIGNED NOT NULL,
  `id_equipo` bigint(20) UNSIGNED NOT NULL,
  `posicion` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ganadores_individuales`
--

CREATE TABLE `ganadores_individuales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_juego` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `posicion` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripciones_grupales`
--

CREATE TABLE `inscripciones_grupales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_equipo` bigint(20) UNSIGNED NOT NULL,
  `id_juego` bigint(20) UNSIGNED NOT NULL,
  `estado` enum('inscrito','asistido','cancelado') NOT NULL,
  `comprobante_pago` varchar(191) DEFAULT NULL,
  `nro_comprobante` varchar(191) DEFAULT NULL,
  `valor_comprobante` double(8,2) DEFAULT NULL,
  `estado_pago` enum('verificado','pendiente','cancelado') NOT NULL DEFAULT 'pendiente',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripciones_individuales`
--

CREATE TABLE `inscripciones_individuales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `id_juego` bigint(20) UNSIGNED NOT NULL,
  `estado` enum('inscrito','asistido','cancelado') NOT NULL,
  `comprobante_pago` varchar(191) DEFAULT NULL,
  `nro_comprobante` varchar(191) DEFAULT NULL,
  `valor_comprobante` double(8,2) DEFAULT NULL,
  `estado_pago` enum('verificado','pendiente','cancelado') NOT NULL DEFAULT 'pendiente',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `juegos`
--

CREATE TABLE `juegos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `genero` varchar(50) NOT NULL,
  `costo_inscripcion` decimal(10,2) NOT NULL,
  `fecha_limite_inscripcion` date NOT NULL,
  `modalidad` enum('individual','grupo') NOT NULL,
  `img_id` varchar(20) NOT NULL DEFAULT 'sample_img',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `juegos`
--

INSERT INTO `juegos` (`id`, `nombre`, `genero`, `costo_inscripcion`, `fecha_limite_inscripcion`, `modalidad`, `img_id`, `created_at`, `updated_at`) VALUES
(1, 'DOTA2', 'MOBA', 25.00, '2023-06-05', 'grupo', 'dota2', '2024-05-18 06:58:11', '2024-05-18 06:58:11'),
(2, 'League of Legends', 'MOBA', 25.00, '2023-06-05', 'grupo', 'lol', '2024-05-18 06:58:11', '2024-05-18 06:58:11'),
(3, 'Valorant', 'FPS', 25.00, '2023-06-05', 'grupo', 'valorant', '2024-05-18 06:58:11', '2024-05-18 06:58:11'),
(4, 'Fornite', 'Battle Royale', 25.00, '2023-06-05', 'individual', 'fortnite', '2024-05-18 06:58:11', '2024-05-18 06:58:11'),
(6, 'FIFA', 'Sports', 3.00, '2023-06-05', 'individual', 'fifa', '2024-05-18 06:58:11', '2024-05-18 06:58:11'),
(7, 'Mario Kart', 'Carreras', 3.00, '2023-06-05', 'individual', 'mario_kart', '2024-05-18 06:58:11', '2024-05-18 06:58:11'),
(8, 'Mortal Kombat', 'Peleas', 3.00, '2023-06-05', 'individual', 'mortal_kombat', '2024-05-18 06:58:11', '2024-05-18 06:58:11'),
(9, 'Free Fire', 'Battle Royale', 3.00, '2023-06-05', 'individual', 'free_fire', '2024-05-18 06:58:11', '2024-05-18 06:58:11'),
(10, 'Free Fire Escuadras', 'Battle Royale', 8.00, '2023-06-05', 'grupo', 'free_fire', '2024-05-18 06:58:11', '2024-05-18 06:58:11'),
(11, 'Clash Royale', 'Estrategia', 3.00, '2023-06-05', 'individual', 'clash_royale', '2024-05-18 06:58:11', '2024-05-18 06:58:11'),
(12, 'Dragon Ball', 'Peleas', 3.00, '2023-06-05', 'individual', 'dragon_ball', '2024-05-18 06:58:11', '2024-05-18 06:58:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_05_23_143631_create_roles_table', 1),
(6, '2023_05_23_143645_create_permissions_table', 1),
(7, '2023_05_23_144239_create_juegos_table', 1),
(8, '2023_05_23_144319_create_inscripcion_individuals_table', 1),
(9, '2023_05_23_144334_create_equipos_table', 1),
(10, '2023_05_23_144347_create_inscripcion_grupals_table', 1),
(11, '2023_05_23_144446_create_role_user_table', 1),
(12, '2023_05_23_154415_create_role_permissions_table', 1),
(13, '2023_05_23_193128_create_ganador_grupals_table', 1),
(14, '2023_05_23_193137_create_ganador_individuals_table', 1),
(15, '2023_06_11_050754_create_sponsors_table', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'register_user', '2024-05-18 06:58:11', '2024-05-18 06:58:11'),
(2, 'login_user', '2024-05-18 06:58:11', '2024-05-18 06:58:11'),
(3, 'view_juegos', '2024-05-18 06:58:11', '2024-05-18 06:58:11'),
(4, 'view_self_user', '2024-05-18 06:58:11', '2024-05-18 06:58:11'),
(5, 'logout_self', '2024-05-18 06:58:11', '2024-05-18 06:58:11'),
(6, 'view_participantes', '2024-05-18 06:58:11', '2024-05-18 06:58:11'),
(7, 'view_self_participante', '2024-05-18 06:58:11', '2024-05-18 06:58:11'),
(8, 'create_participante', '2024-05-18 06:58:11', '2024-05-18 06:58:11'),
(9, 'delete_self_participante', '2024-05-18 06:58:11', '2024-05-18 06:58:11'),
(10, 'update_self_participante', '2024-05-18 06:58:11', '2024-05-18 06:58:11'),
(11, 'view_equipos', '2024-05-18 06:58:11', '2024-05-18 06:58:11'),
(12, 'view_self_equipo', '2024-05-18 06:58:11', '2024-05-18 06:58:11'),
(13, 'create_equipo', '2024-05-18 06:58:11', '2024-05-18 06:58:11'),
(14, 'delete_self_equipo', '2024-05-18 06:58:11', '2024-05-18 06:58:11'),
(15, 'update_self_equipo', '2024-05-18 06:58:11', '2024-05-18 06:58:11'),
(16, 'view_ganadores_individuales', '2024-05-18 06:58:11', '2024-05-18 06:58:11'),
(17, 'view_self_ganador_individual', '2024-05-18 06:58:11', '2024-05-18 06:58:11'),
(18, 'view_ganadores_grupales', '2024-05-18 06:58:11', '2024-05-18 06:58:11'),
(19, 'view_self_ganador_grupal', '2024-05-18 06:58:11', '2024-05-18 06:58:11'),
(20, 'view_inscripciones_individuales', '2024-05-18 06:58:11', '2024-05-18 06:58:11'),
(21, 'view_self_inscripcion_individual', '2024-05-18 06:58:11', '2024-05-18 06:58:11'),
(22, 'create_inscripcion_individual', '2024-05-18 06:58:11', '2024-05-18 06:58:11'),
(23, 'delete_self_inscripcion_individual', '2024-05-18 06:58:11', '2024-05-18 06:58:11'),
(24, 'update_self_inscripcion_individual', '2024-05-18 06:58:11', '2024-05-18 06:58:11'),
(25, 'view_inscripciones_grupales', '2024-05-18 06:58:11', '2024-05-18 06:58:11'),
(26, 'view_self_inscripcion_grupal', '2024-05-18 06:58:11', '2024-05-18 06:58:11'),
(27, 'create_inscripcion_grupal', '2024-05-18 06:58:11', '2024-05-18 06:58:11'),
(28, 'delete_self_inscripcion_grupal', '2024-05-18 06:58:11', '2024-05-18 06:58:11'),
(29, 'update_self_inscripcion_grupal', '2024-05-18 06:58:11', '2024-05-18 06:58:11'),
(30, 'create_juego', '2024-05-18 06:58:11', '2024-05-18 06:58:11'),
(31, 'delete_juego', '2024-05-18 06:58:11', '2024-05-18 06:58:11'),
(32, 'update_juego', '2024-05-18 06:58:11', '2024-05-18 06:58:11'),
(33, 'create_ganador_individual', '2024-05-18 06:58:11', '2024-05-18 06:58:11'),
(34, 'delete_ganador_individual', '2024-05-18 06:58:11', '2024-05-18 06:58:11'),
(35, 'update_ganador_individual', '2024-05-18 06:58:11', '2024-05-18 06:58:11'),
(36, 'create_ganador_grupal', '2024-05-18 06:58:11', '2024-05-18 06:58:11'),
(37, 'delete_ganador_grupal', '2024-05-18 06:58:11', '2024-05-18 06:58:11'),
(38, 'update_ganador_grupal', '2024-05-18 06:58:11', '2024-05-18 06:58:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(191) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'admin', '2024-05-18 06:58:11', '2024-05-18 06:58:11'),
(2, 'jugador', '2024-05-18 06:58:11', '2024-05-18 06:58:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role_permissions`
--

CREATE TABLE `role_permissions` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `role_permissions`
--

INSERT INTO `role_permissions` (`role_id`, `permission_id`, `created_at`, `updated_at`) VALUES
(1, 30, NULL, NULL),
(1, 31, NULL, NULL),
(1, 32, NULL, NULL),
(1, 33, NULL, NULL),
(1, 34, NULL, NULL),
(1, 35, NULL, NULL),
(1, 36, NULL, NULL),
(1, 37, NULL, NULL),
(1, 38, NULL, NULL),
(2, 4, NULL, NULL),
(2, 5, NULL, NULL),
(2, 6, NULL, NULL),
(2, 7, NULL, NULL),
(2, 8, NULL, NULL),
(2, 9, NULL, NULL),
(2, 10, NULL, NULL),
(2, 11, NULL, NULL),
(2, 12, NULL, NULL),
(2, 13, NULL, NULL),
(2, 14, NULL, NULL),
(2, 15, NULL, NULL),
(2, 16, NULL, NULL),
(2, 17, NULL, NULL),
(2, 18, NULL, NULL),
(2, 19, NULL, NULL),
(2, 20, NULL, NULL),
(2, 21, NULL, NULL),
(2, 22, NULL, NULL),
(2, 23, NULL, NULL),
(2, 24, NULL, NULL),
(2, 25, NULL, NULL),
(2, 26, NULL, NULL),
(2, 27, NULL, NULL),
(2, 28, NULL, NULL),
(2, 29, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role_user`
--

CREATE TABLE `role_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sponsors`
--

CREATE TABLE `sponsors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(191) NOT NULL,
  `url_pagina` varchar(191) NOT NULL,
  `url_imagen` varchar(191) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `phone` varchar(191) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) NOT NULL,
  `es_externo` tinyint(1) NOT NULL DEFAULT 0,
  `numero_cedula` varchar(10) DEFAULT NULL,
  `id_espe` varchar(9) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `equipos`
--
ALTER TABLE `equipos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `equipos_id_juego_foreign` (`id_juego`),
  ADD KEY `equipos_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `ganadores_grupales`
--
ALTER TABLE `ganadores_grupales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ganadores_grupales_id_juego_foreign` (`id_juego`),
  ADD KEY `ganadores_grupales_id_equipo_foreign` (`id_equipo`);

--
-- Indices de la tabla `ganadores_individuales`
--
ALTER TABLE `ganadores_individuales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ganadores_individuales_id_juego_foreign` (`id_juego`),
  ADD KEY `ganadores_individuales_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `inscripciones_grupales`
--
ALTER TABLE `inscripciones_grupales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inscripciones_grupales_id_equipo_foreign` (`id_equipo`),
  ADD KEY `inscripciones_grupales_id_juego_foreign` (`id_juego`);

--
-- Indices de la tabla `inscripciones_individuales`
--
ALTER TABLE `inscripciones_individuales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inscripciones_individuales_user_id_foreign` (`user_id`),
  ADD KEY `inscripciones_individuales_id_juego_foreign` (`id_juego`);

--
-- Indices de la tabla `juegos`
--
ALTER TABLE `juegos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_unique` (`name`);

--
-- Indices de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indices de la tabla `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD PRIMARY KEY (`role_id`,`permission_id`),
  ADD KEY `role_permissions_permission_id_foreign` (`permission_id`);

--
-- Indices de la tabla `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_user_role_id_foreign` (`role_id`),
  ADD KEY `role_user_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `sponsors`
--
ALTER TABLE `sponsors`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `equipos`
--
ALTER TABLE `equipos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ganadores_grupales`
--
ALTER TABLE `ganadores_grupales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ganadores_individuales`
--
ALTER TABLE `ganadores_individuales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inscripciones_grupales`
--
ALTER TABLE `inscripciones_grupales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `inscripciones_individuales`
--
ALTER TABLE `inscripciones_individuales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `juegos`
--
ALTER TABLE `juegos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `role_user`
--
ALTER TABLE `role_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `sponsors`
--
ALTER TABLE `sponsors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `equipos`
--
ALTER TABLE `equipos`
  ADD CONSTRAINT `equipos_id_juego_foreign` FOREIGN KEY (`id_juego`) REFERENCES `juegos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `equipos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `ganadores_grupales`
--
ALTER TABLE `ganadores_grupales`
  ADD CONSTRAINT `ganadores_grupales_id_equipo_foreign` FOREIGN KEY (`id_equipo`) REFERENCES `equipos` (`id`),
  ADD CONSTRAINT `ganadores_grupales_id_juego_foreign` FOREIGN KEY (`id_juego`) REFERENCES `juegos` (`id`);

--
-- Filtros para la tabla `ganadores_individuales`
--
ALTER TABLE `ganadores_individuales`
  ADD CONSTRAINT `ganadores_individuales_id_juego_foreign` FOREIGN KEY (`id_juego`) REFERENCES `juegos` (`id`),
  ADD CONSTRAINT `ganadores_individuales_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `inscripciones_grupales`
--
ALTER TABLE `inscripciones_grupales`
  ADD CONSTRAINT `inscripciones_grupales_id_equipo_foreign` FOREIGN KEY (`id_equipo`) REFERENCES `equipos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inscripciones_grupales_id_juego_foreign` FOREIGN KEY (`id_juego`) REFERENCES `juegos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `inscripciones_individuales`
--
ALTER TABLE `inscripciones_individuales`
  ADD CONSTRAINT `inscripciones_individuales_id_juego_foreign` FOREIGN KEY (`id_juego`) REFERENCES `juegos` (`id`),
  ADD CONSTRAINT `inscripciones_individuales_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD CONSTRAINT `role_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
