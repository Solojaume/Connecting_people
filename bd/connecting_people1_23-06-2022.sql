-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-06-2022 a las 11:12:29
-- Versión del servidor: 10.4.18-MariaDB
-- Versión de PHP: 8.0.5

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
CREATE TABLE IF NOT EXISTS `aspecto` (
  `aspecto_id` int(11) NOT NULL AUTO_INCREMENT,
  `aspecto_nombre` varchar(12) COLLATE utf8_spanish2_ci NOT NULL,
  `puntuacion_minima` int(11) NOT NULL,
  `puntuacion_maxima` int(11) NOT NULL,
  PRIMARY KEY (`aspecto_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Truncar tablas antes de insertar `aspecto`
--

TRUNCATE TABLE `aspecto`;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagen`
--

DROP TABLE IF EXISTS `imagen`;
CREATE TABLE IF NOT EXISTS `imagen` (
  `imagen_id` int(11) NOT NULL AUTO_INCREMENT,
  `imagen_usuario_id` int(11) NOT NULL,
  `imagen_src` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `imagen_timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`imagen_id`),
  KEY `imagen_usuario_id` (`imagen_usuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Truncar tablas antes de insertar `imagen`
--

TRUNCATE TABLE `imagen`;
--
-- Volcado de datos para la tabla `imagen`
--

INSERT DELAYED IGNORE INTO `imagen` (`imagen_id`, `imagen_usuario_id`, `imagen_src`, `imagen_timestamp`) VALUES
(1, 0, 'https://cdn.pixabay.com/photo/2014/12/06/19/46/girl-559307_960_720.jpg', '2022-05-17 16:02:32'),
(2, 1, 'https://cdn.pixabay.com/photo/2014/12/06/19/46/girl-559307_960_720.jpg', '2022-05-17 16:06:56'),
(3, 2, 'https://cdn.pixabay.com/photo/2014/12/06/19/46/girl-559307_960_720.jpg', '2022-05-17 16:03:59'),
(4, 3, 'https://cdn.pixabay.com/photo/2014/12/06/19/46/girl-559307_960_720.jpg', '2022-05-17 16:03:59'),
(5, 4, 'https://cdn.pixabay.com/photo/2014/12/06/19/46/girl-559307_960_720.jpg', '2022-05-17 16:02:32'),
(6, 5, 'https://cdn.pixabay.com/photo/2014/12/06/19/46/girl-559307_960_720.jpg', '2022-05-17 16:06:56'),
(7, 6, 'https://cdn.pixabay.com/photo/2014/12/06/19/46/girl-559307_960_720.jpg', '2022-05-17 16:03:59');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mach`
--

DROP TABLE IF EXISTS `mach`;
CREATE TABLE IF NOT EXISTS `mach` (
  `match_id` int(11) NOT NULL AUTO_INCREMENT,
  `match_id_usu1` int(11) NOT NULL,
  `match_id_usu2` int(11) NOT NULL,
  `match_estado_u1` int(11) NOT NULL,
  `match_estado_u2` int(11) NOT NULL,
  `match_fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `estado_conexion_u1` varchar(11) COLLATE utf8_spanish2_ci NOT NULL,
  `estado_conexion_u2` varchar(11) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`match_id`),
  KEY `match_id_usu1` (`match_id_usu1`,`match_id_usu2`),
  KEY `match_id_usu2` (`match_id_usu2`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Truncar tablas antes de insertar `mach`
--

TRUNCATE TABLE `mach`;
--
-- Volcado de datos para la tabla `mach`
--

INSERT DELAYED IGNORE INTO `mach` (`match_id`, `match_id_usu1`, `match_id_usu2`, `match_estado_u1`, `match_estado_u2`, `match_fecha`, `estado_conexion_u1`, `estado_conexion_u2`) VALUES
(0, 0, 1, 1, 1, '2022-04-11 16:25:13', '', ''),
(1, 1, 2, 1, 1, '2022-06-07 08:23:10', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

DROP TABLE IF EXISTS `mensajes`;
CREATE TABLE IF NOT EXISTS `mensajes` (
  `mensajes_id` int(11) NOT NULL AUTO_INCREMENT,
  `mensajes_match_id` int(11) NOT NULL,
  `mensaje_contenido` varchar(256) COLLATE utf8_spanish2_ci NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `entregado` int(1) NOT NULL DEFAULT 0,
  `mensajes_usuario_id` int(11) NOT NULL,
  PRIMARY KEY (`mensajes_id`),
  KEY `mensajes_match_id` (`mensajes_match_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Truncar tablas antes de insertar `mensajes`
--

TRUNCATE TABLE `mensajes`;
--
-- Volcado de datos para la tabla `mensajes`
--

INSERT DELAYED IGNORE INTO `mensajes` (`mensajes_id`, `mensajes_match_id`, `mensaje_contenido`, `timestamp`, `entregado`, `mensajes_usuario_id`) VALUES
(1, 0, 'Hola', '2022-04-11 16:34:05', 1, 0),
(2, 0, 'Hola', '2022-05-23 14:54:08', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puntuaciones_review`
--

DROP TABLE IF EXISTS `puntuaciones_review`;
CREATE TABLE IF NOT EXISTS `puntuaciones_review` (
  `puntuaciones_review_id` int(11) NOT NULL AUTO_INCREMENT,
  `puntuaciones_review_aspecto_id` int(11) NOT NULL,
  `puntuaciones_review_puntuacion` int(11) NOT NULL,
  `puntuaciones_review_review_id` int(11) NOT NULL,
  PRIMARY KEY (`puntuaciones_review_id`),
  KEY `puntuaciones_review_aspecto_id` (`puntuaciones_review_aspecto_id`),
  KEY `puntuaciones_review_review_id` (`puntuaciones_review_review_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Truncar tablas antes de insertar `puntuaciones_review`
--

TRUNCATE TABLE `puntuaciones_review`;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reporte`
--

DROP TABLE IF EXISTS `reporte`;
CREATE TABLE IF NOT EXISTS `reporte` (
  `reporte_id` int(11) NOT NULL,
  `reporte_motivo_id` varchar(11) COLLATE utf8_spanish2_ci NOT NULL,
  `reporte_usuario_id` int(11) NOT NULL,
  `reporte_match_id` int(11) NOT NULL,
  `reporte_resolucion` varchar(110) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`reporte_id`),
  UNIQUE KEY `reporte_usuario_id` (`reporte_usuario_id`),
  UNIQUE KEY `reporte_match_id` (`reporte_match_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Truncar tablas antes de insertar `reporte`
--

TRUNCATE TABLE `reporte`;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `review`
--

DROP TABLE IF EXISTS `review`;
CREATE TABLE IF NOT EXISTS `review` (
  `review_id` int(11) NOT NULL AUTO_INCREMENT,
  `review_descripcion` varchar(120) COLLATE utf8_spanish2_ci NOT NULL,
  `review_usuario_id` int(11) NOT NULL,
  PRIMARY KEY (`review_id`),
  UNIQUE KEY `review_usuario_id` (`review_usuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Truncar tablas antes de insertar `review`
--

TRUNCATE TABLE `review`;
--
-- Volcado de datos para la tabla `review`
--

INSERT DELAYED IGNORE INTO `review` (`review_id`, `review_descripcion`, `review_usuario_id`) VALUES
(0, 'Tenia el coche muy sucio', 0),
(1, 'Un cerdo', 1),
(2, 'Muy divertida', 2),
(3, 'h', 3),
(4, '', 4),
(5, 'Un tia que sabe mucho de coches', 5),
(6, 'Un león en la cama, pero un Seat :)', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `password` varchar(64) COLLATE utf8_spanish2_ci NOT NULL,
  `nombre` varchar(11) COLLATE utf8_spanish2_ci NOT NULL,
  `rol` int(11) NOT NULL DEFAULT 0,
  `timestamp_nacimiento` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `token` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `cad_token` timestamp NOT NULL DEFAULT current_timestamp(),
  `token_recuperar_pass` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `cad_token_recuperar_pass` timestamp NOT NULL DEFAULT current_timestamp(),
  `activo` int(11) NOT NULL DEFAULT 0,
  `ip` varchar(16) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `puerto` varchar(6) COLLATE utf8_spanish2_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `email_2` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Truncar tablas antes de insertar `usuario`
--

TRUNCATE TABLE `usuario`;
--
-- Volcado de datos para la tabla `usuario`
--

INSERT DELAYED IGNORE INTO `usuario` (`id`, `email`, `password`, `nombre`, `rol`, `timestamp_nacimiento`, `token`, `cad_token`, `token_recuperar_pass`, `cad_token_recuperar_pass`, `activo`, `ip`, `puerto`) VALUES
(0, 'admin@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'admin', 1, '2022-06-10 14:42:18', 'c67c94846861340de457aea85c112059751f71d03ef8d64872812bc43119a351', '2022-06-17 14:42:18', '', '2022-05-13 19:14:53', 1, '', ''),
(1, '1@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '1', 0, '2022-06-11 11:15:15', '54e566990f5eaedfd90fcc8369d9409da731e34bef8c4631648cdfb4eee6a8d8', '2022-06-18 11:15:15', 'cca41e4e3d75c125cceedd679901c074d98ee96fa1bc245a155dddb10266ba0e', '2022-05-14 09:02:08', 1, '', ''),
(2, '2@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '2', 0, '2022-06-08 08:57:31', '29d82de1c1822374dfaa7f4078a302411778b82a24fd22f2deee391137c56987', '2022-06-15 08:57:31', '', '2022-05-14 09:06:31', 1, '', ''),
(3, '3@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '3', 0, '1982-05-25 08:30:00', 'fb340f19d3ed1fdf7c3c5b66b401bef96ce71a6be2b2a0e482cc41c8c7aa2da0', '2022-05-24 08:30:00', '', '2022-05-14 09:06:42', 1, '', ''),
(4, '4@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '4', 0, '1979-05-24 08:29:10', '4', '2022-11-30 10:46:15', '8b5c39da04820987854e4e6313d1a2644db7ae55d01a55f7f5c09f8fd7d2329a', '2022-05-14 09:24:26', 1, '', ''),
(5, '5@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '5', 0, '1979-05-24 08:29:10', '5', '2022-11-30 10:46:15', 'a7fa677f4cbc9f93e8638cd83849b04cdd2edf4ee26324177455695aca664c4a', '2022-05-14 09:25:01', 1, '', ''),
(6, 'jaumeponsorti@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'jaume', 0, '0000-00-00 00:00:00', 'a9434cacf8b7edf472e8a36ac61c9cc0fd99e6ca17c87d11a65166e653b5d927', '2022-05-23 08:44:03', '', '2022-05-14 15:31:21', 1, '', '');

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
  ADD CONSTRAINT `mach_ibfk_2` FOREIGN KEY (`match_id_usu2`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD CONSTRAINT `mensajes_ibfk_1` FOREIGN KEY (`mensajes_match_id`) REFERENCES `mach` (`match_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `puntuaciones_review`
--
ALTER TABLE `puntuaciones_review`
  ADD CONSTRAINT `puntuaciones_review_ibfk_1` FOREIGN KEY (`puntuaciones_review_id`) REFERENCES `review` (`review_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `puntuaciones_review_ibfk_2` FOREIGN KEY (`puntuaciones_review_aspecto_id`) REFERENCES `aspecto` (`aspecto_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`review_usuario_id`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
