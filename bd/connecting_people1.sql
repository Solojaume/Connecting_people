-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-04-2022 a las 15:52:07
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `connecting_people1`
--
CREATE DATABASE IF NOT EXISTS `connecting_people1` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish2_ci;
USE `connecting_people1`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aspecto`
--

DROP TABLE IF EXISTS `aspecto`;
CREATE TABLE `aspecto` (
  `aspecto_id` int(11) NOT NULL,
  `aspecto_nombre` varchar(12) COLLATE utf8_spanish2_ci NOT NULL,
  `puntuacion_minima` int(11) NOT NULL,
  `puntuacion_maxima` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagen`
--

DROP TABLE IF EXISTS `imagen`;
CREATE TABLE `imagen` (
  `imagen_id` int(11) NOT NULL,
  `imagen_usuario_id` int(11) NOT NULL,
  `imagen_src` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `imagen_timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mach`
--

DROP TABLE IF EXISTS `mach`;
CREATE TABLE `mach` (
  `match_id` int(11) NOT NULL,
  `match_id_usu1` int(11) NOT NULL,
  `match_id_usu2` int(11) NOT NULL,
  `match_estado_u1` int(11) NOT NULL,
  `match_estado_u2` int(11) NOT NULL,
  `match_fecha` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

DROP TABLE IF EXISTS `mensajes`;
CREATE TABLE `mensajes` (
  `mensajes_id` int(11) NOT NULL,
  `mensajes_match_id` int(11) NOT NULL,
  `mensajes_contenido` varchar(256) COLLATE utf8_spanish2_ci NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `entregado` int(1) NOT NULL DEFAULT 0,
  `mensajes_usario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puntuaciones_review`
--

DROP TABLE IF EXISTS `puntuaciones_review`;
CREATE TABLE `puntuaciones_review` (
  `puntuaciones_review_id` int(11) NOT NULL,
  `puntuaciones_review_aspecto_id` int(11) NOT NULL,
  `puntuaciones_review_puntuacion` int(11) NOT NULL,
  `puntuaciones_review_review_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reporte`
--

DROP TABLE IF EXISTS `reporte`;
CREATE TABLE `reporte` (
  `reporte_id` int(11) NOT NULL,
  `reporte_motivo_id` varchar(11) COLLATE utf8_spanish2_ci NOT NULL,
  `reporte_usuario_id` int(11) NOT NULL,
  `reporte_match_id` int(11) NOT NULL,
  `reporte_resolucion` varchar(110) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `review`
--

DROP TABLE IF EXISTS `review`;
CREATE TABLE `review` (
  `review_id` int(11) NOT NULL,
  `review_descripcion` varchar(120) COLLATE utf8_spanish2_ci NOT NULL,
  `review_usuario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `email` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `password` varchar(64) COLLATE utf8_spanish2_ci NOT NULL,
  `nombre` varchar(11) COLLATE utf8_spanish2_ci NOT NULL,
  `rol` int(11) NOT NULL DEFAULT 0,
  `timestamp_nacimiento` int(11) NOT NULL,
  `token` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `cad_token` timestamp NOT NULL DEFAULT current_timestamp(),
  `token_recuperar_pass` int(100) NOT NULL,
  `cad_token_recuperar_pass` timestamp NOT NULL DEFAULT current_timestamp(),
  `activo` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `aspecto`
--
ALTER TABLE `aspecto`
  ADD PRIMARY KEY (`aspecto_id`);

--
-- Indices de la tabla `imagen`
--
ALTER TABLE `imagen`
  ADD PRIMARY KEY (`imagen_id`),
  ADD KEY `imagen_usuario_id` (`imagen_usuario_id`);

--
-- Indices de la tabla `mach`
--
ALTER TABLE `mach`
  ADD PRIMARY KEY (`match_id`),
  ADD KEY `match_id_usu1` (`match_id_usu1`,`match_id_usu2`),
  ADD KEY `match_id_usu2` (`match_id_usu2`);

--
-- Indices de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD PRIMARY KEY (`mensajes_id`),
  ADD KEY `mensajes_match_id` (`mensajes_match_id`);

--
-- Indices de la tabla `puntuaciones_review`
--
ALTER TABLE `puntuaciones_review`
  ADD PRIMARY KEY (`puntuaciones_review_id`),
  ADD KEY `puntuaciones_review_aspecto_id` (`puntuaciones_review_aspecto_id`),
  ADD KEY `puntuaciones_review_review_id` (`puntuaciones_review_review_id`);

--
-- Indices de la tabla `reporte`
--
ALTER TABLE `reporte`
  ADD PRIMARY KEY (`reporte_id`),
  ADD UNIQUE KEY `reporte_usuario_id` (`reporte_usuario_id`),
  ADD UNIQUE KEY `reporte_match_id` (`reporte_match_id`);

--
-- Indices de la tabla `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`review_id`),
  ADD UNIQUE KEY `review_usuario_id` (`review_usuario_id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `aspecto`
--
ALTER TABLE `aspecto`
  MODIFY `aspecto_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `imagen`
--
ALTER TABLE `imagen`
  MODIFY `imagen_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `mach`
--
ALTER TABLE `mach`
  MODIFY `match_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  MODIFY `mensajes_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `puntuaciones_review`
--
ALTER TABLE `puntuaciones_review`
  MODIFY `puntuaciones_review_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reporte`
--
ALTER TABLE `reporte`
  MODIFY `reporte_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `review`
--
ALTER TABLE `review`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `imagen`
--
ALTER TABLE `imagen`
  ADD CONSTRAINT `imagen_ibfk_1` FOREIGN KEY (`imagen_usuario_id`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `mach`
--
ALTER TABLE `mach`
  ADD CONSTRAINT `mach_ibfk_1` FOREIGN KEY (`match_id_usu1`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mach_ibfk_2` FOREIGN KEY (`match_id_usu2`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mach_ibfk_3` FOREIGN KEY (`match_id`) REFERENCES `mensajes` (`mensajes_match_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `puntuaciones_review`
--
ALTER TABLE `puntuaciones_review`
  ADD CONSTRAINT `puntuaciones_review_ibfk_1` FOREIGN KEY (`puntuaciones_review_id`) REFERENCES `review` (`review_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`review_id`) REFERENCES `puntuaciones_review` (`puntuaciones_review_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`review_usuario_id`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
