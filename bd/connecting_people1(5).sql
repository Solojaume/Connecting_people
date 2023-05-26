-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-11-2022 a las 12:31:54
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
CREATE DATABASE IF NOT EXISTS `connecting_people1` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci;
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

--
-- Volcado de datos para la tabla `aspecto`
--

INSERT INTO `aspecto` (`aspecto_id`, `aspecto_nombre`, `puntuacion_minima`, `puntuacion_maxima`) VALUES
(1, 'general', 1, 5),
(2, 'Pollo', 1, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagen`
--

DROP TABLE IF EXISTS `imagen`;
CREATE TABLE `imagen` (
  `imagen_id` int(11) NOT NULL,
  `imagen_usuario_id` int(11) NOT NULL,
  `imagen_src` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `imagen_timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `imagen_localizacion_donde_subida` varchar(12) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `imagen`
--

INSERT INTO `imagen` (`imagen_id`, `imagen_usuario_id`, `imagen_src`, `imagen_timestamp`, `imagen_localizacion_donde_subida`) VALUES
(1, 0, 'bc73989f627434e88bbbd57b1266bd9268ff727808e69d392cbbefff368818aa.jpg', '2022-10-13 14:24:22', 'Interno'),
(22, 1, 'bc73989f627434e88bbbd57b1266bd9268ff727808e69d392cbbefff368818aa.jpg', '2022-10-13 14:23:54', 'Interno'),
(25, 4, 'bc73989f627434e88bbbd57b1266bd9268ff727808e69d392cbbefff368818aa.jpg', '2022-10-13 14:23:52', 'Interno'),
(26, 5, 'bc73989f627434e88bbbd57b1266bd9268ff727808e69d392cbbefff368818aa.jpg', '2022-10-13 14:23:50', 'Interno'),
(27, 6, 'c863f0e39ee362bdcf0f56e7ea3eb8dbcaac518e448e48bdc33733c182200c33.jpg', '2022-10-05 15:10:19', 'Interno'),
(28, 6, 'ae5d72fb991c06bcfcd29bc27870dc7b624a3163c371645690c4cda99487bd34.jpg', '2022-10-05 14:14:44', 'Interno'),
(37, 2, 'c1e0fea71759f1aba460326fb551e88f158923f839d66dd407fa8ef9d2b07ac3.jpg', '2022-10-05 13:47:17', 'Interno'),
(39, 1, '7fc92bf19f5c8020c91f675dd5da4d82192c6df98a7ef7797d7858322ff9e2b5.jpg', '2022-10-06 15:01:33', 'Interno'),
(40, 3, 'bc73989f627434e88bbbd57b1266bd9268ff727808e69d392cbbefff368818aa.jpg', '2022-10-13 14:21:53', 'Interno'),
(53, 2, '2a8cbfe6802cb53c36aed9f6e1cceec6aaf329a30e842e84b7b7c482e6b22456.jpg', '2022-10-21 15:27:15', 'Interno'),
(54, 3, 'f0985596914977a8e77d907eb842af870f6a83ae6002db599ab972f4c01e9920.jpg', '2022-10-22 10:40:24', 'Interno');

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
  `match_fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `estado_conexion_u1` varchar(14) COLLATE utf8_spanish2_ci NOT NULL,
  `estado_conexion_u2` varchar(14) COLLATE utf8_spanish2_ci NOT NULL,
  `match_deshecho` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `mach`
--

INSERT INTO `mach` (`match_id`, `match_id_usu1`, `match_id_usu2`, `match_estado_u1`, `match_estado_u2`, `match_fecha`, `estado_conexion_u1`, `estado_conexion_u2`, `match_deshecho`) VALUES
(334, 1, 0, 1, 1, '2022-11-09 10:41:08', 'Conectado', '', 0),
(335, 1, 2, 1, 1, '2022-11-09 10:41:54', 'Conectado', 'Desconectado', 0),
(336, 1, 3, 1, 1, '2022-11-09 10:41:08', 'Conectado', 'Desconectado', 0),
(337, 1, 4, 1, 1, '2022-11-09 10:41:08', 'Conectado', '', 0),
(338, 3, 0, 1, 0, '2022-11-08 15:38:25', '', '', 0),
(339, 3, 2, 1, 1, '2022-11-09 10:41:58', '', 'Desconectado', 0),
(340, 2, 0, 1, 0, '2022-11-09 10:50:56', 'Desconectado', '', 0),
(343, 2, 4, 1, 0, '2022-11-09 11:04:01', '', '', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

DROP TABLE IF EXISTS `mensajes`;
CREATE TABLE `mensajes` (
  `mensajes_id` int(11) NOT NULL,
  `mensajes_match_id` int(11) NOT NULL,
  `mensaje_contenido` varchar(1000) COLLATE utf8_spanish2_ci NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `entregado` int(1) NOT NULL DEFAULT 0,
  `mensajes_usuario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `mensajes`
--

INSERT INTO `mensajes` (`mensajes_id`, `mensajes_match_id`, `mensaje_contenido`, `timestamp`, `entregado`, `mensajes_usuario_id`) VALUES
(271, 337, 'h', '2022-11-08 15:37:09', 0, 1);

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

--
-- Volcado de datos para la tabla `review`
--

INSERT INTO `review` (`review_id`, `review_descripcion`, `review_usuario_id`) VALUES
(0, 'Tenia el coche muy sucio', 0),
(1, 'Un cerdo', 1),
(2, 'Muy divertida', 2),
(3, 'h', 3),
(4, 'holaaaaaaaa', 4),
(5, 'Un tia que sabe mucho de coches', 5),
(6, 'Un león en la cama, pero un Seat :)', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `email` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `password` varchar(64) COLLATE utf8_spanish2_ci NOT NULL,
  `nombre` varchar(16) COLLATE utf8_spanish2_ci NOT NULL,
  `rol` int(11) NOT NULL DEFAULT 0,
  `timestamp_nacimiento` timestamp NOT NULL DEFAULT current_timestamp(),
  `token` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `cad_token` timestamp NOT NULL DEFAULT current_timestamp(),
  `token_recuperar_pass` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `cad_token_recuperar_pass` timestamp NOT NULL DEFAULT current_timestamp(),
  `activo` int(11) NOT NULL DEFAULT 0,
  `ip_cliente` varchar(16) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `puerto_cliente` varchar(16) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `ip_servidor` varchar(16) COLLATE utf8_spanish2_ci NOT NULL,
  `puerto_servidor` varchar(16) COLLATE utf8_spanish2_ci NOT NULL,
  `vuelta_a_actualizar` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `email`, `password`, `nombre`, `rol`, `timestamp_nacimiento`, `token`, `cad_token`, `token_recuperar_pass`, `cad_token_recuperar_pass`, `activo`, `ip_cliente`, `puerto_cliente`, `ip_servidor`, `puerto_servidor`, `vuelta_a_actualizar`) VALUES
(0, 'admin@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'admin', 1, '1982-08-29 17:49:16', 'b1d66b95dd1cd31d6ac00516082285fe9df1396052aba980661827c4dcfc871f', '2022-07-12 07:17:45', 'fcc75849be131c58f158838e1d82e0d589e87bfaf559932ea8657da56bd9f602', '2022-08-30 17:49:16', 1, '', '', '', '', NULL),
(1, '1@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '1', 0, '1995-10-07 09:46:01', 'fb1b201dc4f6737cc33babfbcae58374a436f9d94b86c0616a0ae2b8c54e5762', '2022-11-16 10:50:45', '7e94fe1795d7c01867ed6cf53660e41f6b3a35dfccd6f32ca4fcea978bd559ea', '2022-08-30 17:52:09', 1, '127.0.0.1', '55053', '127.0.0.1', '55053', '2022-07-24 13:28:01'),
(2, '2@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '2Patitos', 0, '2022-10-01 14:48:20', '5cb62689b8a753f0f629e2d311aa052c74401f62efac6a446beb877b18d8a33f', '2022-11-16 11:03:55', '37d4b46a758d46daf69d3fd8fb310a5cb28471153aca106aaf03b5b2497d5283', '2022-08-30 18:00:36', 1, '', '', '', '', NULL),
(3, '3@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'Timestamp', 0, '1970-01-01 10:49:30', '7c52baf8e5631fea91ecca24edd7ddb495fa5b4b9cd6da96d098cf7cfdac6601', '2022-11-15 15:38:23', '3e9a169a3dc9f108639f8b4e24cc194241f8635c3e8b18817ee5b49718f67f0a', '2022-08-30 18:02:31', 1, '', '', '', '', NULL),
(4, '4@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '4', 0, '2022-09-24 11:33:18', 'a77174ef71a77827eeec280dd77c309e22b5566c90c217b045a17ad3627f87a0', '2022-11-02 10:32:47', 'd250978db4f11f3be8bb545066479504e7798b9b949f57c7b78a6f11b6618c61', '2022-08-30 18:06:36', 1, '', '', '', '', NULL),
(5, '5@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '5', 0, '2001-10-04 18:07:58', '5', '2022-11-30 10:46:15', 'b8e0fd766f71a97b3817e40f874c6bfc753de500b9122f82352fd4af3b63225f', '2022-08-30 18:07:58', 1, '', '', '', '', NULL),

--
-- Disparadores `usuario`
--
DROP TRIGGER IF EXISTS `upd_estatus_conexion`;
DELIMITER $$
CREATE TRIGGER `upd_estatus_conexion` BEFORE UPDATE ON `usuario` FOR EACH ROW BEGIN
        IF (ISNULL(NEW.ip_cliente) && ISNULL(NEW.puerto_cliente))&&(ISNULL(NEW.ip_servidor) && ISNULL(NEW.puerto_servidor)) THEN
            /*
                Update estado_conexion_u1
            */
            UPDATE `mach` SET `estado_conexion_u1` = 'Desconectado' WHERE `mach`.`match_id_usu1` = NEW.id && OLD.ID=NEW.ID;

            /*
                Update estado_conexion_u2
            */
            UPDATE `mach` SET `estado_conexion_u2` = 'Desconectado' WHERE `mach`.`match_id_usu2` =  NEW.id && OLD.ID=NEW.ID;
        ELSEIF (NEW.ip_cliente="" && NEW.puerto_cliente="")&& (NEW.ip_servidor="" && NEW.puerto_servidor="") THEN
            /*
                Update estado_conexion_u1
            */
            UPDATE `mach` SET `estado_conexion_u1` = 'Desconectado' WHERE `mach`.`match_id_usu1` = NEW.id && OLD.ID=NEW.ID;

            /*
                Update estado_conexion_u2
            */
            UPDATE `mach` SET `estado_conexion_u2` = 'Desconectado' WHERE `mach`.`match_id_usu2` =  NEW.id && OLD.ID=NEW.ID;
        ELSEIF  (NEW.ip_cliente!="" && NEW.puerto_cliente!="")&& (NEW.ip_servidor!="" && NEW.puerto_servidor!="") THEN
            UPDATE `mach` SET `estado_conexion_u1` = 'Conectado' WHERE `mach`.`match_id_usu1` = NEW.id && OLD.ID=NEW.ID;

            /*
                Update estado_conexion_u2
            */
            UPDATE `mach` SET `estado_conexion_u2` = 'Conectado' WHERE `mach`.`match_id_usu2` =  NEW.id && OLD.ID=NEW.ID;
       END IF;
    END
$$
DELIMITER ;

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
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `email_2` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `aspecto`
--
ALTER TABLE `aspecto`
  MODIFY `aspecto_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `imagen`
--
ALTER TABLE `imagen`
  MODIFY `imagen_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT de la tabla `mach`
--
ALTER TABLE `mach`
  MODIFY `match_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=344;

--
-- AUTO_INCREMENT de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  MODIFY `mensajes_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=272;

--
-- AUTO_INCREMENT de la tabla `puntuaciones_review`
--
ALTER TABLE `puntuaciones_review`
  MODIFY `puntuaciones_review_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `review`
--
ALTER TABLE `review`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
  ADD CONSTRAINT `puntuaciones_review_ibfk_1` FOREIGN KEY (`puntuaciones_review_review_id`) REFERENCES `review` (`review_id`) ON DELETE CASCADE ON UPDATE CASCADE,
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
